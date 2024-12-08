@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <br>
        <h2>Registro de Retiradas</h2>
        <br>
        @forelse ($transactions as $transaction)
            <div class="card-vip" style="padding:5px">
                <div class="card-vip-info trans">
                    <div class="div-data">
                        <span class="item">{{ number_format($transaction->money, 2, ',', '.') }} kz</span>
                        <span class="suave" style="font-size: 12px; font-weight: 500">{{ $transaction->created_at }}</span>
                    </div>
                    <span class="suave">{{ $transaction->status }}</span>
                </div>
            </div>
        @empty
        <div class="conteudo-pagina">
            <div class="card-vip-info">
                Nenhum registro de retirada encontrado.
            </div>
        </div>
        @endforelse
        <br><br>
    </div>
@endsection
