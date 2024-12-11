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

     /* public function coletarRecompensas()
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

        return redirect()
            ->back()
            ->with('success', "Recompensas coletadas com sucesso! Total: {$user->incomeDaily} kz.");
    } */
}
