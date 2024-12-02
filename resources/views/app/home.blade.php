@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        <main class="main">
            <div class="hero-banner">
                <div class="carousel">
                    <div class="carousel-inner">
                        <img src="{{ asset('carrousel/8.jpg') }}" alt="Farm scene with barn and cows">
                        <img src="{{ asset('carrousel/9.jpg') }}" alt="Beautiful field">
                        <img src="{{ asset('carrousel/10.jpg') }}" alt="Farm sunset view">
                    </div>
                </div>
            </div>

            <section class="news-section">
                <div class="news-header">
                    <h2>Últimas notícias</h2>
                    <a href="#" class="more-link">Mais ></a>
                </div>
                <div class="news-card">
                    <img src="{{ asset('img/mine.png') }}" alt="News thumbnail" width="60" height="60">
                    <span>Aproveita a semana de promoção, e ganha ate 500.000kz na sua proxima recarga de 3.000kz</span>
                </div>
            </section>

            <div class="menu-grid">
                <a href="{{ route('app.custumerCare') }}" class="menu-card">
                    <img src="{{ asset('img/customer-care.png') }}" alt="Home" width="30" height="30">
                    <span>Serviços</span>
                </a>
                <a href="{{ route('app.team') }}" class="menu-card">
                    <img src="{{ asset('img/group.png') }}" alt="Equipe" width="30" height="30">
                    <span>Minha Equipe</span>
                </a>
            </div>

            <button id="copyLinkButton" class="online-service-button" onclick="copyToClipboard('{{ $inviteLink }}')">
                <div class="icon">
                    <img src="{{ asset('img/invite.png') }}" alt="Ranch icon" width="24" height="24">
                </div>
                <div class="text">
                    <span class="title">Meu Link de Convite</span>
                    <span class="subtitle">Click para copiar o teu link</span>
                </div>
            </button>
        </main>
    </div>

    <script>
        function copyToClipboard(link) {
            navigator.clipboard.writeText(link);
        }
    </script>
@endsection
