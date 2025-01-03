@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <br>
        <h2>Registro de Retiradas</h2>
        <br>
        @forelse ($transactions as $transaction)
            <div class="myCard-vip" style="padding:5px">
                <div class="myCard-vip-info trans">
                    <div class="div-data">
                        <span class="item">{{ number_format($transaction->money, 2, ',', '.') }} kz</span>
                        <span class="suave" style="font-size: 12px; font-weight: 500">{{ $transaction->created_at }}</span>
                    </div>
                    <span class="suave"
                          style="color:
                          @if($transaction->status == 'processando') orange
                          @elseif($transaction->status == 'concluido') green
                          @elseif($transaction->status == 'rejeitado') red
                          @else grey
                          @endif;">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </div>
            </div>
        @empty
        <div class="conteudo-pagina">
            <div class="myCard-vip-info">
                Nenhum registro de retirada encontrado.
            </div>
        </div>
        @endforelse
        <br><br>
    </div>
@endsection
