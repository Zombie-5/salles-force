@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="card">
            <div class="user-info">
                <img src="{{ asset('img/logo.jpg') }}" alt="Home">
                <div>
                    <span class="number">{{$user->telefone}}</span>
                    <span class="titulo">ID: <span class="titulo-static">{{$user->id}}</span></span>
                </div>
            </div>
            <hr>
            <div class="user-money">
                <div>
                    <span class="sup">{{number_format($user->incomeToday, 0, ',', '.') }}</span>
                    <span class="sub">Renda Hoje</span>
                </div>
                <div>
                    <span class="sup"><td>{{number_format($user->incomeDaily, 0, ',', '.') }}</span>
                    <span class="sub">Renda Diária</span>
                </div>
                <div>
                    <span class="sup">{{number_format($user->money, 0, ',', '.') }}</span>
                    <span class="sub">Meu Saldo</span>
                </div>
                <div>
                    <span class="sup">{{number_format($user->incomeTotal, 0, ',', '.') }}</span>
                    <span class="sub">Renda Total</span>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="user-money">
                <a href="{{ route('app.deposit') }}" class="menu-item">
                    <img src="{{ asset('img/withdraw.png') }}" alt="Home" class="menu-icon-2">
                    <span class="sub-2">Recarregar</span>
                </a>
                <a href="{{ route('app.withdraw') }}" class="menu-item">
                    <img src="{{ asset('img/retirar.png') }}" alt="Home" class="menu-icon-2">
                    <span class="sub-2">Retirar</span>
                </a>
                <a href="{{ route('app.bank') }}" class="menu-item">
                    <img src="{{ asset('img/card.png') }}" alt="Home" class="menu-icon-2">
                    <span class="sub-2">Conta Bancária</span>
                </a>
                <a href="{{ route('app.records') }}" class="menu-item">
                    <img src="{{ asset('img/progress.png') }}" alt="Home" class="menu-icon-2">
                    <span class="sub-2">Registos</span>
                </a>
            </div>
            <hr>
            <div class="user-money">
                <a href="{{ route('app.team') }}" class="menu-item">
                    <img src="{{ asset('img/group.png') }}" alt="Equipe" class="menu-icon-2">
                    <span class="sub-2">Equipe</span>
                </a>
                <a href="{{ route('app.gift') }}" class="menu-item">
                    <img src="{{ asset('img/gift.png') }}" alt="Home" class="menu-icon-2">
                    <span class="sub-2">Presente</span>
                </a>
                <a href="{{ route('app.custumerCare') }}" class="menu-item">
                    <img src="{{ asset('img/customer-care.png') }}" alt="Home" class="menu-icon-2">
                    <span class="sub-2">Serviços</span>
                </a>
                <a href="{{ route('app.about') }}" class="menu-item">
                    <img src="{{ asset('img/about.png') }}" alt="aboutUs" class="menu-icon-2">
                    <span class="sub-2">Sobre Nós</span>
                </a>
            </div>
        </div>
        <a href="{{ route('app.sair') }}" class="btn-sair">Terminar Sessão</a>
    </div>
@endsection
