<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    // User Actions
    public function login(Request $request)
    {

        $error = '';
        if ($request->get('error') == "1") {
            $error = 'Usuario e ou senha não existe';
        } else if ($request->get('error') == "2") {
            $error = 'Usuario precisa logar';
        }
        return view('site.login', ['titulo' => 'Login', 'error' => $error]);
    }

    public function loginAdmin(Request $request)
    {

        $error = '';
        if ($request->get('error') == "1") {
            $error = 'Admin e ou senha não existe';
        } else if ($request->get('error') == "2") {
            $error = 'Admin precisa logar';
        }
        return view('admin.site.login', ['titulo' => 'Login', 'error' => $error]);
    }

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

    public function autenticar(Request $request)
    {
        // Definir as regras de validação
        $regras = [
            'telefone' => 'required|max:9|min:9',
            'convite' => 'max:50',
            'password' => 'required'
        ];

        // Feedback de validação
        $feedback = [
            'required' => 'O campo :attribute deve ser preenchido',
        ];

        // Validar os dados do formulário
        $request->validate($regras, $feedback);

        // Obter os dados de telefone e senha do request
        $telefone = $request->get('telefone');
        $password = $request->get('password');

        // Verificar se o usuário com o telefone informado existe e autenticar
        $user = User::where('telefone', $telefone)->first();

        if ($user && Hash::check($password, $user->password)) {

            if (!$user->isActive) {
                // Se o usuário estiver banido, redirecionar com uma mensagem de erro
                return redirect()->route('site.login')->withErrors(['Sua conta foi banida. Contacte um assistente']);
            }

            if ($user->last_reset_income_today !== Carbon::now()->toDateString()) {
                $this->decrementMachineRemaining($user);
            }

            // Usar o Auth para autenticar o usuário
            Auth::login($user);

            // Redirecionar para a página inicial após o login bem-sucedido
            return redirect()->route('app.home')->with('success', 'logado com sucesso!');
        } else {
            // Se o usuário não existir ou a senha não corresponder
            return redirect()->route('site.login')->withErrors(['esse número não esta registrado']);
        }
    }

    public function autenticarAdmin(Request $request)
    {

        // Definir as regras de validação
        $regras = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        // Feedback de validação
        $feedback = [
            'required' => 'O campo :attribute deve ser preenchido',
            'email' => 'O campo :attribute deve ser um email válido'
        ];

        // Validar os dados do formulário
        $request->validate($regras, $feedback);

        // Obter os dados de email e senha do request
        $email = $request->get('email');
        $password = $request->get('password');


        // Verificar se o administrador com o email informado existe e autenticar
        $admin = User::where('telefone', $email)->first();
        if ($admin && Hash::check($password, $admin->password)) {

            // Usar o Auth guard para autenticar o admin
            Auth::login($admin);


            // Redirecionar para a página inicial do admin após o login bem-sucedido
            return redirect()->route('admin.dashboard')->with('success', 'logado com sucesso!');
        } else {
            // Se o administrador não existir ou a senha não corresponder
            return redirect()->route('admin.login')->withErrors(['Credencias Invalidas']);;
        }
    }

    public function sair(Request $request)
    {
         // Finaliza a sessão do usuário
         Auth::logout();

         // Invalida a sessão atual
         $request->session()->invalidate();
 
         // Gera um novo token de sessão para evitar CSRF
         $request->session()->regenerateToken();
 
        return redirect()->route('site.login')->with('success', 'Sessão encerrada com sucesso!');
    }
}
