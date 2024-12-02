<?php

namespace App\Http\Controllers;

use App\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $machines = Machine::orderBy('id', 'desc')
            ->withCount('users')
            ->get();
        return view('admin.app.machine.index', ['machines' => $machines]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.app.machine.add');
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
            'function' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required|integer'
        ];

        $feedback = [
            'required' => 'O campo :attribute deve ser preenchido',
            'numeric' => 'O campo :attribute precisa receber um número',
            'integer' => 'O campo :attribute precisa receber um número inteiro'
        ];

        $request->validate($regras, $feedback);
        $data = $request->all();
        $data['income'] = $data['price'] * 0.1;
        $machine = Machine::create($data);

        return redirect()->route('admin.machine.show', $machine->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function show(Machine $machine)
    {
        $machine->loadCount('users');
        return view('admin.app.machine.show', ['machine' => $machine]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function edit(Machine $machine)
    {
        return view('admin.app.machine.edit', ['machine' => $machine]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Machine $machine)
    {
        $regras = [
            'name' => 'required',
            'function' => 'required',
            'price' => 'required|numeric',
            'income' => 'required|numeric',
            'duration' => 'required|integer'
        ];

        $feedback = [
            'required' => 'O campo :attribute deve ser preenchido',
            'numeric' => 'O campo :attribute precisa receber um número',
            'integer' => 'O campo :attribute precisa receber um número inteiro'
        ];

        $request->validate($regras, $feedback);
        $machine->update($request->all());

        return redirect()->route('admin.machine.show', $machine->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Machine $machine)
    {
        //
    }

    public function toggleStatus(Machine $machine)
    {
        // Alternar o status da máquina
        $machine->isActive = !$machine->isActive;
        $machine->save();

        // Redirecionar de volta para a lista ou para a página de edição
        return redirect()->route('admin.machine.show', ['machine' => $machine->id]);
    }
}
