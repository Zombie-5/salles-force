@extends('site.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        <img src="{{ asset('img/logo.jpg') }}" alt="Home" class="menu-icon-top">
        <h1 class="titulo" >SallesForce</h1>
        <span>Seja bem vindo a area vip</span>
        <form action={{ route('admin.login') }} method="post">
            @csrf
            <input class="padrao" name="email" value="{{ old('email') }}" type="email" placeholder="Email">
            {{ $errors->has('email') ? $errors->first('email') : '' }}
            <br>

            <input class="padrao" name="password" value="{{ old('password') }}" type="password" placeholder="palavra-passe">
            {{ $errors->has('password') ? $errors->first('password') : '' }}
            <br>
            <button class="padrao padbtn" type="submit">Iniciar Sessão</button>
            <br>
            <span>Não tem uma conta? Então você não é vip</span>
        </form>
    </div>
@endsection
