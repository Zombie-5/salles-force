<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Machine;
use App\MachineUser;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::whereNotIn('telefone', ['admin@mina.vip', '921621790'])->count();
        $activeUsers = User::where('isVip', true)->count();
        $totalDeposited = Transaction::where('action', 'depositar')->where('status', 'concluido')->sum('money');
        $totalWithdrawn = Transaction::where('action', 'retirar')->where('status', 'concluido')->sum('money');
        $totalMachines = Machine::count();
        $rentedMachines = MachineUser::count();

        $machineData = Machine::select('machines.name', DB::raw('COUNT(*) as purchases'))
            ->join('machine_user', 'machines.id', '=', 'machine_user.machine_id')
            ->groupBy('machines.id', 'machines.name')
            ->orderByDesc('purchases')
            ->limit(10)
            ->get();

        return view('admin.app.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'totalDeposited',
            'totalWithdrawn',
            'totalMachines',
            'rentedMachines',
            'machineData'
        ));
    }

    public function config()
    {
        return view('admin.app.config');
    }

    public function sair()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
