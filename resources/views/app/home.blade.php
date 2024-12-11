@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        <main class="main">
            <div class="hero-banner">
                <div class="carrousel">
                    <div class="carrousel-inner">
                        <img src="{{ asset('carrousel/8.jpg') }}" alt="Farm scene with barn and cows">
                        <img src="{{ asset('carrousel/9.jpg') }}" alt="Beautiful field">
                        <img src="{{ asset('carrousel/10.jpg') }}" alt="Farm sunset view">
                    </div>
                </div>
            </div>

            <section class="news-section">
                <div class="news-header">
                    <h2>Últimas notícias</h2>
                    <a href="#" id="moreLink" class="more-link">Mais ></a>
                </div>
                <div id="newsCard" class="news-myCard">
                    <img src="{{ asset('img/mine.png') }}" alt="News thumbnail" width="60" height="60">
                    @if (!empty($notices) && count($notices) > 0)
                        <span style="flex-wrap: nowrap" id="newsTitle">{{ $notices[0]->notice }}</span>
                    @else
                        <span>Olá mundo</span>
                    @endif
                </div>
            </section>

            <div class="menu-grid">
                <a href="{{ route('app.custumerCare') }}" class="menu-myCard">
                    <img src="{{ asset('img/customer-care.png') }}" alt="Home" width="30" height="30">
                    <span>Serviços</span>
                </a>
                <a href="{{ route('app.team') }}" class="menu-myCard">
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

        let currentIndex = 0;
        const notices = @json($notices); // Transforma a variável notices em um array JavaScript
        const newsTitle = document.getElementById('newsTitle');
        const newsCard = document.getElementById('newsCard');

        document.getElementById('moreLink').addEventListener('click', function(e) {
            e.preventDefault(); // Evita que o link recarregue a página

            // Atualiza o índice da notícia atual
            currentIndex = (currentIndex + 1) % notices.length;

            // Atualiza o título da notícia
            newsTitle.textContent = notices[currentIndex].notice;
        });
    </script>
@endsection
