<?php

namespace App\Http\Controllers;

use App\Machine;
use App\User;
use App\Record;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Obtém o valor da pesquisa
        $query = $request->input('query');

        // Verifica se há uma pesquisa ou retorna todos os usuários
        if ($query) {
            $users = User::where('id', $query)
                ->orWhere('telefone', $query)
                ->orderBy('id', 'asc')
                ->get();
        } else {
            $users = User::orderBy('id', 'asc')->get();
        }

        // Retorna a view com os usuários encontrados
        return view('admin.app.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($convite = null)
    {
        return view('site.registe', compact('convite'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'telefone' => 'required|max:9|min:9|unique:users,telefone',
            'password' => 'required',
            'convite'  => 'required',
        ]);

        // Descriptografar o convite (ID do usuário)
        $decodedId = base64_decode($validatedData['convite']);

        // Verificar se o ID é válido
        if (!is_numeric($decodedId) || !User::find($decodedId)) {
            return back()->withErrors(['convite' => 'Código de convite inválido.'])->withInput();
        }

        $user = User::create([
            'telefone' => $validatedData['telefone'],
            'password' => Hash::make($validatedData['password']),
            'userId' => $decodedId,
        ]);

        $inviter = User::find($user->userId);
        $invitedCount = User::where('userId', $inviter->id)->count();

        if ($invitedCount <= 10) {
            $inviter->money += 100;
            $inviter->incomeToday += 100;
            $inviter->incomeTotal += 100;
            $inviter->save();
        }

        return redirect()->route('site.login')->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->loadCount('machines');
        return view('admin.app.user.show', ['user' => $user]);
    }

    public function depositar(Request $request, $userId)
    {

        // Validar se o valor foi fornecido e é um número
        $validated = $request->validate([
            'query' => 'required|numeric',
        ]);


        // Recuperar o valor inserido
        $valorDepositado = $validated['query'];

        // Obter o usuário pelo ID
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'Usuário não encontrado.');
        }

        // Somar o valor depositado ao saldo atual
        $user->money += $valorDepositado;
        $user->incomeTotal += $valorDepositado;
        $user->save();

        // Retornar com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Depósito realizado com sucesso!');
    }

    public function toggleStatus($userId)
    {
        $user = User::find($userId);

        if ($user) {
            // Inverte o status do usuário
            $user->isActive = !$user->isActive;
            $user->save();

            // Retorna uma resposta JSON indicando sucesso
            return redirect()->back()->with('success', 'Depósito realizado com sucesso!');
        }

        // Caso o usuário não seja encontrado
        return response()->json(['success' => false]);
    }

    public function alugarMaquina(Request $request, $machineId)
    {

        // Obter o usuário autenticado
        $userId = Auth::user();
        $user = User::find($userId->id);

        // Obter a máquina
        $machine = Machine::findOrFail($machineId);

        if ($user->money < $machine->price) {
            return redirect()->back()->with('error', 'Você não tem dinheiro suficiente para alugar esta máquina.');
        }

        // Verificar e definir valores de coleta
        $today = now()->toDateString();
        $remainingTotal = $machine->duration; // Duração total da máquina
        $incomeTotal = 0; // Rendimento inicial

        // Verificar se o usuário já coletou hoje
        if ($user->last_collection === $today) {
            $remainingTotal -= 1; // Reduzir 1 dia se a máquina já foi usada hoje
            $incomeTotal += $machine->income;
            $user->incomeToday += $machine->income;
            $user->incomeTotal += $machine->income;
            $user->save();
        }

        // Anexar a máquina ao usuário na tabela pivot
        $user->machines()->attach($machine->id, [
            'remainingToday' => 24 * 60 * 60, // Tempo restante em segundos
            'remainingTotal' => $remainingTotal,
            'incomeToday' => $machine->income,
            'incomeTotal' => $incomeTotal,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Subtrair o preço da máquina do saldo do usuário
        $user->money -= $machine->price;
        $user->incomeDaily += $machine->income;
        $user->save(); // O save deve funcionar agora se o User for um modelo Eloquent

        // Comissão de 10% para o superior de nível 1 (direto)
        $superiorNivel1 = User::find($user->userId);
        if ($superiorNivel1) {
            $comissaoNivel1 = $machine->price * 0.10;
            $superiorNivel1->money += $comissaoNivel1;
            $superiorNivel1->incomeToday += $comissaoNivel1;
            $superiorNivel1->incomeTotal += $comissaoNivel1;
            $superiorNivel1->save();

            Record::create([
                'name' => 'Bônus Convidado',
                'money' => $comissaoNivel1,
                'user_id' => $superiorNivel1->id,
            ]);
        }

        // Comissão de 5% para o superior de nível 2 (indiretamente)
        $superiorNivel2 = User::find($superiorNivel1 ? $superiorNivel1->userId : null);
        if ($superiorNivel2) {
            $comissaoNivel2 = $machine->price * 0.05;
            $superiorNivel2->money += $comissaoNivel2;
            $superiorNivel2->incomeToday += $comissaoNivel2;
            $superiorNivel2->incomeTotal += $comissaoNivel2;
            $superiorNivel2->save();

            Record::create([
                'name' => 'Bônus Convidado',
                'money' => $comissaoNivel2,
                'user_id' => $superiorNivel2->id,
            ]);
        }

        // Comissão de 2% para o superior de nível 3 (indiretamente)
        $superiorNivel3 = User::find($superiorNivel2 ? $superiorNivel2->userId : null);
        if ($superiorNivel3) {
            $comissaoNivel3 = $machine->price * 0.02;
            $superiorNivel3->money += $comissaoNivel3;
            $superiorNivel3->incomeToday += $comissaoNivel3;
            $superiorNivel3->incomeTotal += $comissaoNivel3;
            $superiorNivel3->save();

            Record::create([
                'name' => 'Bônus Convidado',
                'money' => $comissaoNivel3,
                'user_id' => $superiorNivel3->id,
            ]);
        }


        return redirect()->back()->with('success', 'Máquina alugada com sucesso!');
    }

    public function exibirMaquinas()
    {
        $userId = Auth::user();
        $user = User::find($userId->id);
        $machines = $user->machines()->get();

        $machinesData = $machines->map(function ($machine) {
            $pivot = $machine->pivot;
            return [
                'machine' => $machine,
                'remainingTotal' => $pivot->remainingTotal,
                'incomeTotal' => number_format($pivot->incomeTotal, 2) . 'kz',
            ];
        });

        return view('app.mine', ['machinesData' => $machinesData, 'canCollect' => $user->last_collection !== now()->toDateString()]);
    }

    public function coletarRecompensas()
    {
        $userId = Auth::user();
        $user = User::find($userId->id);

        // Verificar se o usuário já coletou hoje
        $today = now()->toDateString();
        if ($user->last_collection === $today) {
            return redirect()->back()->with('error', 'Você já coletou as recompensas de hoje.');
        }

        // Recuperar todas as máquinas do usuário com os dados da pivot
        $machines = $user->machines()->withPivot('incomeTotal', 'remainingTotal')->get();

        // Iterar pelas máquinas para calcular o total, atualizar incomeTotal e decrementar remainingTotal
        foreach ($machines as $machine) {
            $income = $machine->income;

            // Decrementar o campo remainingTotal na pivot
            $newRemainingTotal = $machine->pivot->remainingTotal - 1;

            if ($newRemainingTotal > 0) {
                // Atualizar incomeTotal e remainingTotal se ainda houver tempo restante
                $user->machines()->updateExistingPivot($machine->id, [
                    'incomeTotal' => $machine->pivot->incomeTotal + $income,
                    'remainingTotal' => $newRemainingTotal,
                ]);

                Record::create([
                    'name' => 'Renda Diária',
                    'money' => $income,
                    'user_id' => $user->id,
                ]);

            } else {
                // Remover a relação se remainingTotal chegar a 0
                $user->machines()->detach($machine->id);
                $user->incomeDaily -= $machine->income;
                $user->save();
            }
        }

        // Atualizar o saldo do usuário
        $user->money += $user->incomeDaily;
        $user->incomeToday = $user->incomeDaily;
        $user->incomeTotal += $user->incomeDaily;
        $user->last_collection = $today;
        $user->save();

        return redirect()->back()->with('success', "Recompensas coletadas com sucesso! Total: {$user->incomeDaily} kz.");
    }





    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
