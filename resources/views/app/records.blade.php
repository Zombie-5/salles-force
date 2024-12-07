@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <br><br>
        @forelse ($transactions as $transaction)
            <div class="card-vip" style="padding:5px">
                <div class="card-vip-info trans">
                    <span style="font-size: 30px; color: {{ $transaction->action == 'depositar' ? 'green' : 'red' }}">
                        {{ $transaction->action == 'depositar' ? '+' : '-' }}
                    </span>
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
                Nenhum registro de transação encontrado.
            </div>
        </div>
        @endforelse
    </div>
@endsection
