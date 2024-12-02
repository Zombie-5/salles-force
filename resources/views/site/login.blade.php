@extends('site.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        <img src="{{ asset('img/logo.jpg') }}" alt="Home" class="menu-icon-top">
        <h1>SallesForce</h1>
        <form action={{ route('site.login') }} method="post">
            @csrf
            <input name="telefone" value="{{ old('telefone') }}" type="text" placeholder="Telefone">
            {{ $errors->has('telefone') ? $errors->first('telefone') : '' }}
            <br>

            <input name="password" value="{{ old('password') }}" type="password" placeholder="palavra-passe">
            {{ $errors->has('password') ? $errors->first('password') : '' }}
            <br>
            <button type="submit">Iniciar Sessão</button>
            <br>
            <span>Não tem uma conta? <a href="{{ route('site.cadastro') }}">Criar conta</a></span>
        </form>
    </div>
@endsection
