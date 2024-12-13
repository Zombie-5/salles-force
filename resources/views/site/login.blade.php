@extends('site.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        <img src="{{ asset('img/logo.jpg') }}" alt="Home" class="menu-icon-top">
        <h1 class="titulo">SallesForce</h1>
        <form action={{ route('site.auth') }} method="post">
            @csrf
            <input class="padrao" name="telefone" value="{{ old('telefone') }}" type="text" placeholder="Telefone">
            {{ $errors->has('telefone') ? $errors->first('telefone') : '' }}
            <br>

            <input class="padrao" name="password" value="{{ old('password') }}" type="password" placeholder="palavra-passe">
            {{ $errors->has('password') ? $errors->first('password') : '' }}
            <br>
            <button class="padrao padbtn" type="submit">Iniciar Sessão</button>
            <br>
            <span>Não tem uma conta? <a href="{{ route('site.cadastro') }}">Criar conta</a></span>
        </form>
    </div>
@endsection
