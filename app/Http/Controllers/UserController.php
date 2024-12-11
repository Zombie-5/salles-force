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
        $decodedId = $validatedData['convite'];

        // Verificar se o ID é válido
        if (!is_numeric($decodedId) || !User::find($decodedId)) {
            return back()->withErrors(['Código de convite inválido.']);
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

            Record::create([
                'name' => 'Bônus Convite',
                'money' => '100',
                'user_id' => $inviter->id,
            ]);
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

            return redirect()->back()->withErrors(['Usuario não encontrado']);
        }

        // Somar o valor depositado ao saldo atual
        $user->money += $valorDepositado;
        $user->incomeTotal += $valorDepositado;
        $user->save();

        Record::create([
            'name' => 'Bônus Especial',
            'money' => $valorDepositado,
            'user_id' => $user->id,
        ]);

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
        return redirect()->back()->withErrors(['Usuario não encontrado']);
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

    public function alugarMaquina(Request $request, $machineId)
    {
        // Obter o usuário autenticado
        $userId = Auth::user();
        $user = User::find($userId->id);

        // Obter a máquina
        $machine = Machine::findOrFail($machineId);

        if ($user->money < $machine->price) {
            return back()->withErrors(['Você não tem dinheiro suficiente para alugar esta máquina.']);
        }

        // Verificar e definir valores de coleta
        $today = now()->toDateString();
        $remainingTotal = $machine->duration; // Duração total da máquina
        $incomeTotal = 0; // Rendimento inicial

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

        if (!$user->isVip) {

            // Comissão de 10% para o superior de nível 1 (direto)
            $superiorNivel1 = User::find($user->userId);
            if ($superiorNivel1) {
                $comissaoNivel1 = $machine->price * 0.1;
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

            $user->isVip = true;
            $user->save();
        }

        return redirect()->back()->with('success', 'Máquina alugada com sucesso!');
    }

    public function coletarRecompensas()
    {
        $userId = Auth::user();
        $user = User::find($userId->id);

        // Recuperar todas as máquinas do usuário com os dados da pivot
        $machines = $user->machines()->withPivot('incomeTotal', 'last_collection')->get();

        // Iterar pelas máquinas para calcular o total, atualizar incomeTotal e decrementar remainingTotal
        foreach ($machines as $machine) {

            // Verificar se a máquina já coletou hoje
            $today = now()->toDateString();
            if ($machine->pivot->last_collection === $today) continue;

            $income = $machine->income;

            // Atualizar o saldo do usuário
            $user->money += $income;
            $user->incomeToday += $income;
            $user->incomeTotal += $income;
            $user->save();

            $user->machines()->updateExistingPivot($machine->id, [
                'incomeTotal' => $machine->pivot->incomeTotal + $income,
                'last_collection' => $today,
            ]);

            Record::create([
                'name' => 'Renda Diária',
                'money' => $income,
                'user_id' => $user->id,
            ]);
        }

        return redirect()->back()->with('success', 'Recompensas coletadas com sucesso');
    }

}
