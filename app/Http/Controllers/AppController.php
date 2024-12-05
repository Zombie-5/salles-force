<?php

namespace App\Http\Controllers;

use App\Machine;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function generateInviteLink()
    {
        // Obter o usuário autenticado
        $baseURL = 'https://salles-force.onrender.com/cadastrar';
        $encodeId = base64_encode(Auth::user()->id);
        return $baseURL . '/' . $encodeId;
    }

    public function home()
    {
        $inviteLink = $this->generateInviteLink();
        return view('app.home', compact('inviteLink'));
    }

    public function team()
    {
        $inviteLink = $this->generateInviteLink();

        // Buscar subordinados de nível 1 (os que foram convidados diretamente por você)
        $nivel1 = User::where('userId', Auth::id())->get();  // O userId deve ser igual ao ID do usuário logado
        $totalNivel1 = $nivel1->count();  // Total de subordinados de nível 1

        // Buscar subordinados de nível 2 (os convidados pelos subordinados de nível 1)
        $nivel2 = User::whereIn('userId', $nivel1->pluck('id'))->get();  // Os userIds dos subordinados de nível 1
        $totalNivel2 = $nivel2->count();  // Total de subordinados de nível 2

        // Buscar subordinados de nível 3 (os convidados pelos subordinados de nível 2)
        $nivel3 = User::whereIn('userId', $nivel2->pluck('id'))->get();  // Os userIds dos subordinados de nível 2
        $totalNivel3 = $nivel3->count();  // Total de subordinados de nível 3

        // Passar as variáveis para a view
        return view('app.team', compact('nivel1', 'nivel2', 'nivel3', 'totalNivel1', 'totalNivel2', 'totalNivel3', 'inviteLink'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('app.profile', ['user' => $user]);
    }

    public function about()
    {
        return view('app.about');
    }


    public function machine()
    {
        $machines = Machine::all();
        return view('app.machine', ['machines' => $machines]);
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
        return view('app.bank.add');
    }

    public function editBank()
    {
        $user = Auth::user();
        $banco = $user->banco;
        return view('app.bank.edit', compact('banco'));
    }

    public function deposit()
    {
        $user = Auth::user();
        return view('app.transaction.deposit', ['user' => $user]);
    }

    public function records()
    {
        $user = Auth::user();
        $transactions = Transaction::where('userId', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('app.records', compact('transactions'));
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
}
