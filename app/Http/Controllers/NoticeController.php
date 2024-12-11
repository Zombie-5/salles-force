<?php

namespace App\Http\Controllers;

use App\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notices = Notice::orderBy('created_at', 'desc')->get();
        return view('admin.app.notice.index', ['notices' => $notices]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.app.notice.generate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required',
        ]);

        // Salva no banco de dados
        $giftCode = Notice::create([
            'notice' => $request->value,
        ]);

        return redirect()->route('notice.index');
    }

    public function toggleStatus($noticeId)
    {
        $notice = Notice::find($noticeId);

        if ($notice) {
            // Inverte o status do noticia
            $notice->isActive = !$notice->isActive;
            $notice->save();

            // Retorna uma resposta JSON indicando sucesso
            return redirect()->back()->with('success', 'Depósito realizado com sucesso!');
        }

        // Caso o noticia não seja encontrada
        return redirect()->back()->withErrors('Noticia não encontrada');
    }
}
