@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        @forelse ($machines as $machine)
            <div class="card-vip">
                <div class="card-vip-info">
                    <span class="titulo-static">{{ number_format($machine->price, 2, ',', '.') }} kz</span>
                    <span class="item">{{ $machine->name }}: <span class="suave">{{ $machine->function }}</span></span>
                    <span class="item">Renda diária: <span class="suave">{{ number_format($machine->income, 2, ',', '.') }}
                            kz</span></span>
                    <span class="item">Duração: <span class="suave">{{ $machine->duration }} Dias</span></span>
                    <span class="item">Renda total: <span
                            class="suave">{{ number_format($machine->income * $machine->duration, 2, ',', '.') }}
                            kz</span></span>
                </div>
                <button
                    @if ($machine->isActive) onclick="event.preventDefault(); document.getElementById('alugar-form-{{ $machine->id }}').submit();"
                    @else
                    disabled @endif>{{ $machine->isActive ? 'Alugar' : 'Indisponivel' }}</button>
                <form id="alugar-form-{{ $machine->id }}" action="{{ route('user.alugar', $machine->id) }}"
                    method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        @empty
            <div class="card-vip-info">
                Nenhuma máquina encontrada.
            </div>
        @endforelse
    </div>
@endsection
