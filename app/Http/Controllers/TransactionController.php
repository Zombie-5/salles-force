<?php

namespace App\Http\Controllers;

use App\Banco;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
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

            $transactionsDeposited = Transaction::orderBy('created_at', 'desc')
                ->where('userId', $query)
                ->where('status','!=', 'concluido')
                ->where('status','!=', 'rejeitado')
                ->where('action', 'depositar')
                ->get();
            
            $transactionsWithdrawn = Transaction::orderBy('created_at', 'desc')
                ->where('userId', $query)
                ->where('status','!=', 'concluido')
                ->where('status','!=', 'rejeitado')
                ->where('action', 'retirar')
                ->get();

            $transactions = Transaction::orderBy('created_at', 'desc')
                ->where('status','!=', 'pendente')
                ->where('status','!=', 'processando')
                ->get();
            
         } else {
            $transactionsDeposited = Transaction::orderBy('created_at', 'desc')->where('status','!=', 'concluido')->where('status','!=', 'rejeitado')->where('action', 'depositar')->get();
            $transactionsWithdrawn = Transaction::orderBy('created_at', 'desc')->where('status','!=', 'concluido')->where('status','!=', 'rejeitado')->where('action', 'retirar')->get();
            $transactions = Transaction::orderBy('created_at', 'desc')->where('status','!=', 'pendente')->where('status','!=', 'processando')->get();
         }

        return view('admin.app.transaction', ['transactions' => $transactions, 'transactionsDeposited' => $transactionsDeposited, 'transactionsWithdrawn' => $transactionsWithdrawn]);
    }

    public function indexDeposit()
    {
        $user = Auth::user();
        $transactions = Transaction::where('userId', $user->id)
            ->where('action', 'depositar')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('app.transaction.records-deposit', compact('transactions'));
    }

    public function indexWithdraw()
    {
        $user = Auth::user();
        $transactions = Transaction::where('userId', $user->id)
            ->where('action', 'retirar')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('app.transaction.records-withdraw', compact('transactions'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validar o status recebido
        $validated = $request->validate([
            'status' => 'required|in:pendente,processando,concluido,rejeitado',
        ]);

        // Encontrar a transação
        $transaction = Transaction::findOrFail($id);

        // Verifique se a transação já está concluída
        if ($transaction->status == 'concluido') {
            return redirect()->back()->withErrors(['A transação já foi concluída e não pode ser alterada.']);
        }

        if ($transaction->status == 'rejeitado') {
            return redirect()->back()->withErrors(['A transação já foi rejeitada e não pode ser alterada.']);
        }

        // Se o status for "concluído"
        if ($validated['status'] == 'concluido') {
            try {
                DB::beginTransaction(); // Inicia uma transação no banco de dados

                // Verifica a ação da transação
                if ($transaction->action == 'depositar') {
                    // Lógica para adicionar o dinheiro ao saldo do usuário (apenas para depósito)
                    $user = User::findOrFail($transaction->userId);
                    $user->money += $transaction->money; // Adiciona o valor ao saldo do usuário
                    $user->save();

                    // Atualiza o status da transação
                    $transaction->status = 'concluido';
                    $transaction->save();

                    DB::commit(); // Confirma a transação no banco de dados

                    return redirect()->back()->with('success', 'Depósito concluído e dinheiro depositado com sucesso.');
                } elseif ($transaction->action == 'retirar') {
                    // Se for uma retirada, não faz nada
                    // Atualiza o status da transação
                    $transaction->status = 'concluido';
                    $transaction->save();
                    DB::commit(); // Confirma a transação sem alterar nada
                    return redirect()->back()->with('success', 'Transação de retirada concluída.');
                }
            } catch (\Exception $e) {
                DB::rollBack(); // Desfaz qualquer mudança no banco se ocorrer um erro
                return redirect()->back()->withErrors(['Erro ao concluir a transação']);
            }
        }

        // Se o status for "rejeitado"
        if ($validated['status'] == 'rejeitado') {
            try {
                DB::beginTransaction(); // Inicia uma transação no banco de dados

                // Verifica a ação da transação
                if ($transaction->action == 'depositar') {
                    // Atualiza o status da transação
                    $transaction->status = 'rejeitado';
                    $transaction->save();

                    DB::commit(); // Confirma a transação no banco de dados

                    return redirect()->back()->with('success', 'Depósito rejeitado com sucesso.');
                } elseif ($transaction->action == 'retirar') {

                    $user = User::findOrFail($transaction->userId);
                    $user->money += $transaction->money; // Adiciona o valor ao saldo do usuário
                    $user->save();

                    $transaction->status = 'rejeitado';
                    $transaction->save();
                    DB::commit(); // Confirma a transação sem alterar nada
                    return redirect()->back()->with('success', 'Transação de retirada rejeitada, saldo reajustado.');
                }
            } catch (\Exception $e) {
                DB::rollBack(); // Desfaz qualquer mudança no banco se ocorrer um erro
                return redirect()->back()->withErrors(['Erro ao concluir a transação']);
            }
        }

        // Caso o status não seja "concluido", apenas atualize o status
        $transaction->status = $validated['status'];
        $transaction->save();

        return redirect()->back()->with('success', 'Status da transação atualizado com sucesso.');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validação de entrada
        $request->validate([
            'query' => 'required|numeric|min:1',
            'action' => 'required|string|in:depositar,retirar',
        ]);

        // Recuperando o usuário logado
        $userId = Auth::user();
        $user = User::findOrFail($userId->id);

        // Recuperando a ação (depositar ou retirar)
        $action = $request->input('action');
        $bancoId = null;  // Atribua o banco se necessário

        // Verifica a ação
        if ($action === 'depositar') {

             // Validação de entrada
            $request->validate([
                'query' => 'required|numeric|min:10000',
            ], [
                'query.required' => 'O montante é obrigatório.',
                'query.numeric' => 'O montante deve ser númerico.',
                'query.min' => 'O valor mínimo permitido para recarga é 5.000 kz',
            ]);

            $depositAmount = $request->input('query') ?: $request->input('custom_amount');


            // Lógica de depósito
            Transaction::create([
                'action' => 'depositar',
                'money' => $depositAmount,
                'status' => 'pendente',
                'bancoId' => $bancoId,
                'userId' => $user->id,
            ]);

            return redirect()->route('selecionar.banco')->with('success', 'Depósito solicitado com sucesso!')->with('money', $depositAmount);
        } elseif ($action === 'retirar') {

            $request->validate([
                'query' => 'required|numeric|min:1200|max:50000',
            ], [
                'query.required' => 'O montante é obrigatório.',
                'query.numeric' => 'O montante deve ser númerico.',
                'query.min' => 'O valor mínimo permitido para retirada é 1.200 kz',
                'query.max' => 'O valor maximo permitido para retirada é 50.000 kz',
            ]);

            if (!$user->isVip) {
                return back()->withErrors(['Apenas mineiros podem soicitar saques, alugue uma máquina e se torne um mineiro']);
            }

            // Obtém o horário atual
            $currentTime = Carbon::now();

            // Define o intervalo de horário permitido
            $startTime = Carbon::createFromTime(9, 0, 0);  // 09:00
            $endTime = Carbon::createFromTime(14, 0, 0);   // 14:00

            // Verifica se o dia é sábado ou domingo
            if ($currentTime->isWeekend()) {
                return back()->withErrors(['A solicitação de saque não pode ser feita durante o fim de semana. O horário é de segunda a sexta-feira.']);
            }

            // Verifica se o horário atual está fora do intervalo permitido (9h às 14h)
            if ($currentTime->lt($startTime) || $currentTime->gt($endTime)) {
                return back()->withErrors(['O horário para solicitação de saque é das 9h às 14h, de segunda a sexta-feira.']);
            }

            if ($user->last_withdraw === Carbon::now()->toDateString()) {
                return back()->withErrors(['O limite permitido é de um saque por dia.']);
            }

            $depositAmount = $request->input('query');

            if ($depositAmount > $user->money) {
                return redirect()->back()->withErrors(['Saldo insuficiente']);
            }

            $descount =  $depositAmount * 0.14;
            $depositValue =  $depositAmount - $descount;

            // Lógica de retirada
            $transaction = Transaction::create([
                'action' => 'retirar',
                'money' => $depositValue,
                'status' => 'pendente',
                'bancoId' => $bancoId,
                'userId' => $user->id,
            ]);

            $user->money -= $depositAmount;
            $user->last_withdraw = Carbon::now()->toDateString();
            $user->save();

            return redirect()->route('app.records.withdraw')->with('success', 'Retirada solicitada com sucesso!');
        }

        // Caso a ação seja inválida
        return back()->withErrors(['Ação inválida']);
    }


    public function selecionarBanco(Request $request)
    {
        // Filtra os bancos onde o campo 'isAdmin' é true
        $bancos = Banco::where('isAdmin', true)->get();

        // Verifica se há um banco selecionado e o passa para a view
        $selectedBank = null;
        $money = $request->session()->get('money');

        if ($request->has('banco_id')) {
            $selectedBank = Banco::find($request->input('banco_id'));
        }
        // Retorna a view com os bancos e o banco selecionado
        return view('app.transaction.selectBank', [
            'bancos' => $bancos,
            'selectedBank' => $selectedBank,
            'money' => $money
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
