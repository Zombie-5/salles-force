<?php

namespace App\Http\Controllers;

use App\Machine;
use App\Transaction;
use App\Record;
use App\Banco;
use Carbon\Carbon;
use App\User;
use App\MachineUser;
use App\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function generateInviteLink()
    {
        // Obter o usuário autenticado
        $baseURL = 'https://www.sallesforce.vip/cadastrar';
        //$baseURL = 'https://salles-force.onrender.com/cadastrar';
        //$baseURL = 'http://127.0.0.1:8000/cadastrar';
        $encodeId = Auth::user()->id;
        return $baseURL . '/' . $encodeId;
    }

    public function home()
    {
        $userId = Auth::user();
        $user = User::find($userId->id);

        if ($user->last_reset_income_today !== Carbon::now()->toDateString()) {
            $this->decrementMachineRemaining($user);
        }

        $inviteLink = $this->generateInviteLink();
        $notices = Notice::orderBy('created_at', 'desc')->where('isActive', true)->get();
        return view('app.home', compact('inviteLink', 'notices'));
    }

    public function team()
    {
        $inviteLink = $this->generateInviteLink();

        // Buscar subordinados de nível 1 (os que foram convidados diretamente por você)
        $nivel1 = User::where('userId', Auth::id())->orderBy('created_at', 'desc')->get();  // O userId deve ser igual ao ID do usuário logado
        $totalNivel1 = $nivel1->count();  // Total de subordinados de nível 1

        // Buscar subordinados de nível 2 (os convidados pelos subordinados de nível 1)
        $nivel2 = User::whereIn('userId', $nivel1->pluck('id'))->orderBy('created_at', 'desc')->get();  // Os userIds dos subordinados de nível 1
        $totalNivel2 = $nivel2->count();  // Total de subordinados de nível 2

        // Buscar subordinados de nível 3 (os convidados pelos subordinados de nível 2)
        $nivel3 = User::whereIn('userId', $nivel2->pluck('id'))->orderBy('created_at', 'desc')->get();  // Os userIds dos subordinados de nível 2
        $totalNivel3 = $nivel3->count();  // Total de subordinados de nível 3


        // Buscar as máquinas associadas a cada subordinado
        $nivel1WithMachines = $nivel1->map(function ($user) {
            $user->machines = $user->machines;  // Obtendo as máquinas de cada usuário de nível 1
            return $user;
        });

        $nivel2WithMachines = $nivel2->map(function ($user) {
            $user->machines = $user->machines;  // Obtendo as máquinas de cada usuário de nível 2
            return $user;
        });

        $nivel3WithMachines = $nivel3->map(function ($user) {
            $user->machines = $user->machines;  // Obtendo as máquinas de cada usuário de nível 3
            return $user;
        });

       // $totalIncomeInvites = Record::where('user_id', Auth::id())->where('name', 'Bônus Convidado')->orWhere('name', 'Renda Convidado')->sum('money');
        $totalIncomeInvites = Record::where('user_id', Auth::id())->where('name', 'like', '%Convidado%')->sum('money');

        $totalInvites = $totalNivel1 + $totalNivel2 + $totalNivel3;

        // Passar as variáveis para a view
        return view('app.team', compact(
            'nivel1WithMachines',
            'nivel2WithMachines',
            'nivel3WithMachines',
            'totalNivel1',
            'totalNivel2',
            'totalNivel3',
            'inviteLink',
            'totalIncomeInvites',
            'totalInvites'
        ));
        // Passar as variáveis para a view
        //return view('app.team', compact('nivel1', 'nivel2', 'nivel3', 'totalNivel1', 'totalNivel2', 'totalNivel3', 'inviteLink'));
    }

    public function profile()
    {
        $user = Auth::user();

        if ($user->last_reset_income_today !== Carbon::now()->toDateString()) {
            $this->decrementMachineRemaining($user);
        }
        
        return view('app.profile', ['user' => $user]);
    }

    public function about()
    {
        return view('app.about');
    }


    public function machine()
    {
        $machines = Machine::where('id','!=', 10 )->orderBy('price', 'asc')->get();

        $machinesData = $machines->map(function ($machine) {

            // Verificar se o usuário já está alugando a máquina
            $relation = MachineUser::where('user_id', Auth::user()->id)
                ->where('machine_id', $machine->id)
                ->first(); // Usar first() para pegar apenas o primeiro registro, não a coleção

            // Se a relação existe, então a máquina já está sendo alugada
            $isRent = $relation ? true : false;

            return [
                'machine' => $machine,
                'isRent' => $isRent
            ];
        });

        return view('app.machine', ['machinesData' => $machinesData]);
    }

    public function gift()
    {
        return view('app.gift');
    }

    public function bank()
    {
        $user = Auth::user();
        $banco = $user->banco;
        return view('app.bank.bank', compact('banco'));
    }

    public function addBank()
    {
        $bancos = Banco::orderBy('id', 'desc')
            ->where('isAdmin', true)
            ->get();
        return view('app.bank.add', compact('bancos'));
    }

    public function editBank()
    {
        $user = Auth::user();
        $banco = $user->banco;
        $bancos = Banco::orderBy('id', 'desc')
            ->where('isAdmin', true)
            ->get();
        return view('app.bank.edit', compact('bancos', 'banco'));
    }

    public function deposit()
    {
        $user = Auth::user();
        $banco = $user->banco;
        return view('app.transaction.deposit', ['user' => $user, 'bancos' => $banco]);
    }

    public function records()
    {
        $user = Auth::user();
        $records = Record::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('app.records', compact('records'));
    }

    public function withdraw()
    {
        $user = Auth::user();
        return view('app.transaction.withdraw', ['user' => $user]);
    }

    public function custumerCare()
    {
        return view('app.services');
    }

    // 
    private function decrementMachineRemaining($user)
    {
        // Recuperar todas as máquinas do usuário com os dados da pivot
        $machines = $user->machines()->withPivot('remainingTotal')->get();

        // Iterar pelas máquinas para decrementar remainingTotal
        foreach ($machines as $machine) {

            // Decrementar o campo remainingTotal na pivot
            $newRemainingTotal = $machine->pivot->remainingTotal - 1;

            if ($newRemainingTotal > 0) {
                // Atualizar remainingTotal se ainda houver tempo restante
                $user->machines()->updateExistingPivot($machine->id, [
                    'remainingTotal' => $newRemainingTotal,
                ]);
            } else {
                // Remover a relação se remainingTotal chegar a 0
                $user->machines()->detach($machine->id);
                $user->incomeDaily -= $machine->income;
                $user->save();
            }
        }
        // bellow
        $user->incomeToday = 0;
        $user->last_reset_income_today = Carbon::now()->toDateString();
        $user->save();
    }

}
