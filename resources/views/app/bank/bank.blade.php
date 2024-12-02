@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        @if ($banco)
            <form action="{{ route('app.bank.edit') }}" method="GET" class="bank-info">
                <div class="card-vip-info">
                    <span class="item">Nome do banco: <span class="suave">{{ $banco->name }}</span></span>
                    <span class="item">Proprietário: <span class="suave">{{ $banco->owner  }}</span></span>
                    <span class="item">IBAN: <span class="suave">{{ chunk_split($banco->iban, 4, ' ') }}</span></span>
                </div>
                <button type="submit" class="submit-btn">Actulizar banco</button>
            </form>
        @else
            <form action="{{ route('app.bank.create') }}" method="GET" class="bank-info">
                <div class="card-vip-info">
                    Você ainda não tem uma conta bancária associada.
                </div>
                <button type="submit" class="submit-btn">Adicionar banco</button>
            </form>
        @endif

    </div>
@endsection
