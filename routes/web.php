<?php

use App\Http\Controllers\MachineController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/cadastrar/{convite?}', 'UserController@create')->name('site.cadastro');
Route::post('/cadastrar', 'UserController@store')->name('site.cadastro');

Route::get('/login/{error?}', 'AuthController@login')->name('site.login');
Route::post('/login', 'AuthController@autenticar')->name('site.login');

Route::get('/master/login/{error?}', 'AuthController@loginAdmin')->name('admin.login');
Route::post('/master/login', 'AuthController@autenticarAdmin')->name('admin.login');

Route::middleware('autenticacao')->prefix('/app')->group(function () {

    Route::get('/pagina-inicial', 'AppController@home')->name('app.home');
    Route::get('/mina', 'UserController@exibirMaquinas')->name('app.mine');
    Route::get('/alugar-maquina', 'AppController@machine')->name('app.machine');
    Route::post('/alugar-maquina/{machineId}', 'UserController@alugarMaquina')->name('user.alugar');

    Route::get('/profile', 'AppController@profile')->name('app.profile');

    Route::get('/team', 'AppController@team')->name('app.team');
    Route::get('/about-us', 'AppController@about')->name('app.about');
    Route::get('/presentes', 'AppController@gift')->name('app.gift');

    Route::get('/bank', 'AppController@bank')->name('app.bank');
    Route::get('/bank-add', 'AppController@addBank')->name('app.bank.create');
    Route::get('/bank-edit', 'AppController@editBank')->name('app.bank.edit');

    Route::get('/deposit', 'AppController@deposit')->name('app.deposit');
    Route::get('/select-bank-account', 'TransactionController@selecionarBanco')->name('selecionar.banco');

    Route::get('/withdraw', 'AppController@withdraw')->name('app.withdraw');

    Route::get('/records', 'AppController@records')->name('app.records');
    Route::get('/records-withdraw', 'TransactionController@indexDeposit')->name('app.records.deposit');
    Route::get('/records-deposit', 'TransactionController@indexWithdraw')->name('app.records.withdraw');

    Route::get('/custumer-care', 'AppController@custumerCare')->name('app.custumerCare');


    Route::post('/redeem', 'GiftCodeController@redeem')->name('gift.redeem');

    Route::get('/sair', 'AuthController@sair')->name('app.sair');
});

Route::middleware('autenticacao')->prefix('/master')->group(function () {

    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    Route::get('/config', 'AdminController@config')->name('admin.config');

    Route::get('/users', 'UserController@index')->name('admin.users');
    Route::get('/show-user/{user}', 'UserController@show')->name('admin.users.show');
    Route::post('/depositar/{user}/admin', 'UserController@depositar')->name('admin.depositar');
    Route::post('/set-status/{user}', 'UserController@toggleStatus')->name('admin.user.status');
    Route::post('/coletar-recompensas', 'UserController@coletarRecompensas')->name('machines.collect');


    Route::get('/transaction', 'TransactionController@index')->name('transaction.index');
    Route::patch('/transactions/{id}', 'TransactionController@updateStatus')->name('transaction.status');
    Route::post('/transaction/user', 'TransactionController@store')->name('transaction.store');

    Route::get('/machine-list', 'MachineController@index')->name('admin.machine.index');
    Route::get('/machine-show/{machine}', 'MachineController@show')->name('admin.machine.show');
    Route::get('/machine-add', 'MachineController@create')->name('admin.machine.create');
    Route::post('/machine-save', 'MachineController@store')->name('admin.machine.store');
    Route::post('/set-status/{machine}', 'MachineController@toggleStatus')->name('admin.machine.status');
    Route::get('/machine-edit/{machine}', 'MachineController@edit')->name('admin.machine.edit');
    Route::put('/machine-update/{machine}', 'MachineController@update')->name('admin.machine.update');
    Route::post('/admin/machine/{machine}/status', [MachineController::class, 'toggleStatus'])->name('admin.machine.status');

    Route::get('/bank-list', 'BancoController@index')->name('admin.bank.index');
    Route::get('/bank-show/{banco}', 'BancoController@show')->name('admin.bank.show');
    Route::get('/bank-add', 'BancoController@create')->name('admin.bank.create');
    Route::post('/bank-save', 'BancoController@store')->name('admin.bank.store');
    Route::get('/bank-edit/{banco}', 'BancoController@edit')->name('admin.bank.edit');
    Route::put('/bank-update/{banco}', 'BancoController@update')->name('admin.bank.update');

    Route::post('/generate', 'GiftCodeController@generate')->name('gift.generate');
    Route::get('/gift-generate', 'GiftCodeController@create')->name('gift.generate.view');
    Route::get('/gift-index', 'GiftCodeController@index')->name('gift.index');


    Route::get('/sair', 'AdminController@sair')->name('admin.sair');
});
