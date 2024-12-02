<div class="rodape">
    <a href="{{ route('admin.dashboard') }}" class="menu-item">
        <img src="{{ asset('img/dashboard.png') }}" alt="Home" class="menu-icon">
        <span>Dashbord</span>
    </a>
    <a href="{{ route('transaction.index') }}" class="menu-item">
        <img src="{{ asset('img/investment.png') }}" alt="Perfil" class="menu-icon">
        <span>Transações</span>
    </a>
    <a href="{{ route('admin.users') }}" class="menu-item">
        <img src="{{ asset('img/user.png') }}" alt="Perfil" class="menu-icon">
        <span>Utilizadores</span>
    </a>
    <a href="{{ route('admin.config') }}" class="menu-item">
        <img src="{{ asset('img/gear.png') }}" alt="Mina" class="menu-icon">
        <span>Configurações</span>
    </a>
</div>
