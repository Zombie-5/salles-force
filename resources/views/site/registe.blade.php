@extends('site.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        <img src="{{ asset('img/logo.jpg') }}" alt="Home" class="menu-icon-top">
        <h1>SallesForce</h1>
        <span>Crie uma conta e Comece a Ganhar</span>
        <form action="{{ route('site.cadastro') }}" method="post">
            @csrf
            <input name="telefone" value="{{ old('telefone') }}" type="text" placeholder="Telefone">
            {{ $errors->has('telefone') ? $errors->first('telefone') : '' }}
            <br>
            <input name="password" value="{{ old('password') }}" type="password" placeholder="palavra-passe">
            {{ $errors->has('password') ? $errors->first('password') : '' }}
            <br>
            <input name="convite" value="{{ old('convite', $convite) }}" type="text" placeholder="código de convite">
            {{ $errors->has('convite') ? $errors->first('convite') : '' }}
            <br>
            <button type="submit">Criar Conta</button>
            <br>
            <span>Já tem uma conta? <a href="{{ route('site.login') }}">Iniciar Sessão</a></span>
        </form>
    </div>
@endsection
