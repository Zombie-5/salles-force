@extends('site.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        <img src="{{ asset('img/logo.jpg') }}" alt="Home" class="menu-icon-top">
        <h1 class="titulo">SallesForce</h1>
        <span>Crie uma conta e Comece a Ganhar</span>
        <form action="{{ route('site.cadastro.auth') }}" method="post">
            @csrf
            <input class="padrao" name="telefone" value="{{ old('telefone') }}" type="text" placeholder="Telefone">
            {{ $errors->has('telefone') ? $errors->first('telefone') : '' }}
            <br>
            <input class="padrao" name="password" value="{{ old('password') }}" type="password" placeholder="palavra-passe">
            {{ $errors->has('password') ? $errors->first('password') : '' }}
            <br>
            <input class="padrao" name="convite" value="{{ old('convite', $convite) }}" type="text" placeholder="código de convite">
            {{ $errors->has('convite') ? $errors->first('convite') : '' }}
            <br>
            <button class="padrao padbtn" type="submit">Criar Conta</button>
            <br>
            <span>Já tem uma conta? <a href="{{ route('site.login') }}">Iniciar Sessão</a></span>
        </form>
    </div>
@endsection
