@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <h1 class="titulo-pagina">Resgatar Código de Presente</h1>
            <form action="{{ route('gift.redeem') }}" method="POST" class="form">
                @csrf
                <label for="token">Código do Presente:</label>
                <input type="text" name="token" id="token" required>

                <button type="submit" class="botao">Resgatar Código</button>
            </form>
    </div>
@endsection
