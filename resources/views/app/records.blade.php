@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <br><br>
        @forelse ($records as $record)
            <div class="myCard-vip" style="padding:5px">
                <div class="myCard-vip-info trans">
                    <div class="div-data">
                        <span class="item">{{ number_format($record->money, 2, ',', '.') }} kz</span>
                        <span class="suave" style="font-size: 12px; font-weight: 500">{{ $record->created_at }}</span>
                    </div>
                    <span class="suave">{{ $record->name }}</span>
                </div>
            </div>
        @empty
        <div class="conteudo-pagina">
            <div class="myCard-vip-info">
                Nenhum registro encontrado.
            </div>
        </div>
        @endforelse
        <br><br>
    </div>
@endsection
