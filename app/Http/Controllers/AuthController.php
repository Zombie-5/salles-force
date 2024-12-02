<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // User Actions
    public function login(Request $request)
    {

        $error  = '';
        if ($request->get('error') == "1") {
            $error  = 'Usuario e ou senha não existe';
        } else if ($request->get('error') == "2") {
            $error  = 'Usuario precisa logar';
        }
        return view('site.login', ['titulo' => 'Login', 'error' => $error]);
    }

    public function loginAdmin(Request $request)
    {
        $error  = '';
        if ($request->get('error') == "1") {
            $error  = 'Admin e ou senha não existe';
        } else if ($request->get('error') == "2") {
            $error  = 'Admin precisa logar';
        }
        return view('admin.site.login', ['titulo' => 'Login', 'error' => $error]);
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
            // Usar o Auth para autenticar o usuário
            Auth::login($user);

            // Redirecionar para a página inicial após o login bem-sucedido
            return redirect()->route('app.home');
        } else {
            // Se o usuário não existir ou a senha não corresponder
            return redirect()->route('site.login', ['error' => "1"]);
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
        $admin = Admin::where('email', $email)->first();

        if ($admin && Hash::check($password, $admin->password)) {
            // Usar o Auth guard para autenticar o admin
            Auth::login($admin);

            // Redirecionar para a página inicial do admin após o login bem-sucedido
            return redirect()->route('admin.dashboard');
        } else {
            // Se o administrador não existir ou a senha não corresponder
            return redirect()->route('admin.login', ['error' => "1"]);
        }
    }

    public function sair()
    {
        Auth::logout();
        return redirect()->route('site.login');
    }
}
