<?php

namespace App\Http\Controllers;

use App\GiftCode;
use App\User;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;


class GiftCodeController extends Controller
{

    public function generate(Request $request)
    {
        $request->validate([
            'value' => 'required',
        ]);

        // Dados do token com um identificador único
        $data = [
            'value' => $request->value,
        ];

        // Criptografa os dados
        $shortToken = Str::random(8);

        // Salva no banco de dados
        $giftCode = GiftCode::create([
            'token' => $shortToken,
            'value' => $request->value,
        ]);

        return redirect()->route('gift.index')->with([
            'token' => $shortToken,
            'value' => $giftCode->value,
        ]);
    }

    public function redeem(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        try {
            // Busca o giftCode com o token informado
            $giftCode = GiftCode::where('token', $request->token)->first();

            if (!$giftCode) {
                return response()->json(['error' => 'Token inválido'], 400);
            }

            // Verifica se o token já foi utilizado
            if ($giftCode->status === 'used') {
                return response()->json(['error' => 'Token já resgatado'], 400);
            }

            // Simula o depósito na conta do usuário (implementação do seu método depositToUserAccount)
            $userId = Auth::user();
            $user = User::findOrFail($userId->id);
            $user->money += $giftCode->value;
            $user->incomeToday += $giftCode->value;
            $user->save();

            Record::create([
                'name' => 'Bônus Presente',
                'money' => $giftCode->value,
                'user_id' => $user->id,
            ]);

            // Marca o token como usado no banco de dados
            $giftCode->update(['status' => 'used']);

            return redirect()->back()->with('success', 'presente resgatado com sucesso!');;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Token inválido');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gifts = GiftCode::orderBy('created_at', 'desc')->get();
        return view('admin.app.gift.index', ['gifts' => $gifts]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.app.gift.generate');
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
     * @param  \App\GiftCode  $giftCode
     * @return \Illuminate\Http\Response
     */
    public function show(GiftCode $giftCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GiftCode  $giftCode
     * @return \Illuminate\Http\Response
     */
    public function edit(GiftCode $giftCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GiftCode  $giftCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GiftCode $giftCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GiftCode  $giftCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(GiftCode $giftCode)
    {
        //
    }
}
