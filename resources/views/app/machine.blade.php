@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        @forelse ($machinesData as $data)
            <div class="myCard-vip">
                <div class="myCard-vip-info">
                    <span class="titulo-static">{{ number_format($data['machine']->price, 2, ',', '.') }} kz</span>
                    <span class="item">{{ $data['machine']->name }}: <span class="suave">{{ $data['machine']->function }}</span></span>
                    <span class="item">Renda diária: <span class="suave">{{ number_format($data['machine']->income, 2, ',', '.') }} kz</span></span>
                    <span class="item">Duração: <span class="suave">{{ $data['machine']->duration }} Dias</span></span>
                    <span class="item">Renda total: <span class="suave">{{ number_format($data['machine']->income * $data['machine']->duration, 2, ',', '.') }} kz</span></span>
                </div>
                
                @php
                    $buttonState = '';
                    $buttonText = '';
                    $disabled = false;

                    if (!$data['machine']->isActive) {
                        $buttonState = 'Indisponível';
                        $disabled = true;
                    } elseif ($data['isRent']) {
                        $buttonState = 'Alugando';
                        $disabled = true;
                    } else {
                        $buttonState = 'Alugar';
                    }
                @endphp

                <button
                    @if (!$disabled)
                        onclick="event.preventDefault(); document.getElementById('alugar-form-{{ $data['machine']->id }}').submit();"
                    @endif
                    @disabled($disabled)>
                    {{ $buttonState }}
                </button>

                <form id="alugar-form-{{ $data['machine']->id }}" action="{{ route('user.alugar', $data['machine']->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        @empty
            <div class="myCard-vip-info">
                Nenhuma máquina encontrada.
            </div>
        @endforelse
    </div>
@endsection
