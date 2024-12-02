<?php

namespace App\Http\Controllers;

use App\Banco;
use Illuminate\Http\Request;

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
            return redirect()->route('app.bank');
        }

        return redirect()->route('admin.bank.index');
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
        $regras = [
            'name' => 'required',
            'owner' => 'required',
            'iban' => 'required|numeric|unique:bancos,iban,' . $banco->id,
        ];

        $feedback = [
            'required' => 'O campo :attribute deve ser preenchido',
            'numeric' => 'O campo :attribute precisa receber um número',
            'unique' => 'O :attribute já pertence a um usuario',
        ];

        $request->validate($regras, $feedback);
        $banco->update($request->all());

        if (isset($banco->user_id)) {
            return redirect()->route('app.bank');
        }

        return redirect()->route('admin.bank.show', $banco->id);
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
