<?php

namespace App\Http\Controllers;

use App\Banco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bancos = Banco::orderBy('id', 'desc')
            ->where('isAdmin', true)
            ->get();
        return view('admin.app.bank.index', ['bancos' => $bancos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Filtra os bancos onde o campo 'isAdmin' é true
        return view('admin.app.bank.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regras = [
            'name' => 'required',
            'owner' => 'required',
            'iban' => 'required|numeric|unique:bancos,iban',
        ];

        $feedback = [
            'required' => 'O campo :attribute deve ser preenchido',
            'numeric' => 'O campo :attribute precisa receber um número',
            'unique' => 'O :attribute já pertence a um usuario',
        ];

        $request->validate($regras, $feedback);
        $banco = Banco::create($request->all());

        if (isset($banco->user_id)) {
            return redirect()->route('app.bank')->withErrors(['Você já tem uma conta bancaria associada']);
        }

        return redirect()->route('admin.bank.index')->with('success', 'Banco Associado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function show(Banco $banco)
    {
        return view('admin.app.bank.show', ['banco' => $banco]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function edit(Banco $banco)
    {
        return view('admin.app.bank.edit', ['banco' => $banco]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banco $banco)
    {
        // Recuperar o usuário atual
        $userId = Auth::id(); // ID do usuário logado

        // Definir as regras de validação
        $regras = [
            'name' => 'required',
            'owner' => 'required',
            'iban' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($banco, $userId) {
                    // Verificar se o IBAN está sendo alterado
                    if ($banco->iban !== $value) {
                        // Verificar se o IBAN pertence a outro usuário
                        $ibanExistente = Banco::where('iban', $value)
                            ->where('user_id', '!=', $userId)
                            ->first();

                        if ($ibanExistente) {
                            $fail('O IBAN já pertence a outro usuário');
                        }
                    }
                },
            ],
        ];

        // Mensagens de feedback
        $feedback = [
            'required' => 'O campo :attribute deve ser preenchido',
            'numeric' => 'O campo :attribute precisa receber um número',
        ];

        // Validar os dados
        $request->validate($regras, $feedback);

        // Atualizar o banco
        $banco->update($request->all());

        // Redirecionar conforme o caso
        if (isset($banco->user_id)) {
            return redirect()->route('app.bank');
        }

        return redirect()->route('admin.bank.show', $banco->id)->with('success', 'Banco editado com sucesso!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banco  $banco
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banco $banco)
    {
        //
    }
}
