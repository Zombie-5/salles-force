@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <h1 class="titulo-pagina">Gerar Código de Presente</h1>
            <form action="{{ route('gift.generate') }}" method="POST" class="form">
                @csrf
                <label for="value">Valor do Presente:</label>
                <input type="text" name="value" id="value" step="0.01" min="0.01" required>

                <button type="submit" class="botao">Gerar Código</button>
            </form>

            @if (session('token'))
                <div class="resultado">
                    <p><strong>Código Gerado:</strong> {{ session('token') }}</p>
                    <p><strong>Valor:</strong> {{ session('value') }}</p>
                </div>
            @endif
    </div>
@endsection
