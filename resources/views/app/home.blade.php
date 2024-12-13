@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        <main class="main">

            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="{{ asset('carrousel/8.jpg') }}" class="d-block w-100" alt="Farm scene with barn and cows">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('carrousel/9.jpg') }}" class="d-block w-100" alt="Beautiful field">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('carrousel/10.jpg') }}" class="d-block w-100" alt="Farm sunset view">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
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
