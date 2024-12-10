@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <h1 class="titulo-pagina">Criar nova noticia</h1>
            <form action="{{ route('notice.store') }}" method="POST" class="form">
                @csrf
                <label for="value">Noticia:</label>
                <textarea name="value" id="value" require cols="40" rows="10" class="desc"></textarea>

                <button type="submit" class="botao">Salvar</button>
            </form>

            @if (session('token'))
                <div class="resultado">
                    <p><strong>Código Gerado:</strong> {{ session('token') }}</p>
                    <p><strong>Valor:</strong> {{ session('value') }}</p>
                </div>
            @endif
    </div>
@endsection
