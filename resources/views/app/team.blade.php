@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <br>
        <button id="copyLinkButton" class="online-service-button" onclick="copyToClipboard('{{ $inviteLink }}')">
            <div class="icon">
                <img src="{{ asset('img/invite.png') }}" alt="Ranch icon" width="24" height="24">
            </div>
            <div class="text">
                <span class="title">Meu Link de Convite</span>
                <span class="subtitle">Click para copiar o teu link</span>
            </div>
        </button>
        <br>
        <div style="display: flex; flex-direction: column; width:100%; justify-content: flex-start; color: #008cbb">
            <span style=" color: #008cbb">Total de convidados: {{ $totalInvites }}</span>
            <span style=" color: #008cbb">Total de Comissão: {{ number_format($totalIncomeInvites, 2, ',', '.') }} kz</span>
        </div>
        <br>
        <ul class="tab-list">
            <li class="tab-item">
                <a href="#n1" class="tab-link active" data-tab="n1">Nível 1</a>
            </li>
            <li class="tab-item">
                <a href="#n2" class="tab-link" data-tab="n2">Nível 2</a>
            </li>
            <li class="tab-item">
                <a href="#n3" class="tab-link" data-tab="n3">Nível 3</a>
            </li>
        </ul>

        <div class="tab-content">

            <div id="n1" class="tab-pane active">
                <div class="myCard-vip-info">
                    Total Convidados N1: {{ $totalNivel1 }}
                </div>
                <hr>
                @forelse ($nivel1WithMachines as $guest)
                    <div class="myCard-vip-info">
                        <span class="item">{{ $guest->telefone }}</span>
                        <ul class="machine-list">
                            @foreach ($guest->machines as $machine)
                                <li>{{ $machine->name }}. </li>
                            @endforeach
                        </ul>
                        <span class="suave"
                            style="font-size: 12px; font-weight: 500; margin-top: -10px">{{ $guest->created_at }}</span>
                    </div>
                    <hr>
                @empty
                    <div class="myCard-vip-info">
                        Nenhum convidado encontrado.
                    </div>
                @endforelse
            </div>

            <div id="n2" class="tab-pane">
                <div class="myCard-vip-info">
                    Total Convidados N2: {{ $totalNivel2 }}
                </div>
                <hr>
                @forelse ($nivel2WithMachines as $guest)
                    <div class="myCard-vip-info">
                        <span class="item">{{ $guest->telefone }}</span>
                        <ul class="machine-list">
                            @foreach ($guest->machines as $machine)
                                <li>{{ $machine->name }}. </li>
                            @endforeach
                        </ul>
                        <span class="suave" style="font-size: 12px; font-weight: 500; margin-top: -10px">{{ $guest->created_at }}</span>
                    </div>
                    <hr>
                @empty
                    <div class="myCard-vip-info">
                        Nenhum convidado encontrado.
                    </div>
                @endforelse
            </div>

            <div id="n3" class="tab-pane">
                <div class="myCard-vip-info">
                    Total Convidados N3: {{ $totalNivel3 }}
                </div>
                <hr>
                @forelse ($nivel3WithMachines as $guest)
                    <div class="myCard-vip-info">
                        <span class="item">{{ $guest->telefone }}</span>
                        <ul class="machine-list">
                            @foreach ($guest->machines as $machine)
                                <li>{{ $machine->name }}. </li>
                            @endforeach
                        </ul>
                        <span class="suave" style="font-size: 12px; font-weight: 500; margin-top: -10px">{{ $guest->created_at }}</span>
                    </div>
                    <hr>
                @empty
                    <div class="myCard-vip-info">
                        Nenhum convidado encontrado.
                    </div>
                @endforelse
            </div>

        </div>
        <br>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-link');
            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabId = this.getAttribute('data-tab');

                    // Remove active class from all tabs and panes
                    document.querySelectorAll('.tab-link, .tab-pane').forEach(el => {
                        el.classList.remove('active');
                    });

                    // Add active class to clicked tab and corresponding pane
                    this.classList.add('active');
                    document.getElementById(tabId).classList.add('active');
                });
            });
        });

        function copyToClipboard(link) {
            navigator.clipboard.writeText(link);
        }
    </script>
@endsection
