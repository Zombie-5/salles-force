@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        @forelse ($machinesData as $data)
            <div class="myCard-vip">
                <div class="myCard-vip-info">
                    <span class="titulo-static">{{ $data['machine']->name }}: <span class="titulo">Minerando</span></span>

                    <span class="item">Tempo restante total:
                        <span class="suave contador-dias">
                            {{ $data['remainingTotal'] }} dias
                        </span>
                    </span>

                    <span class="item">Lucro: <span class="suave">{{ $data['incomeTotal'] }}</span></span>
                </div>
            </div>
        @empty
            <div class="myCard-vip-info">
                Nenhuma máquina encontrada.
            </div>
        @endforelse

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <br>
    <form action="{{ route('machines.collect') }}" method="POST">
        @csrf
        <button type="submit" class="btn-primary" {{ $canCollect ? '' : 'disabled' }}>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-2.83-.48-5.08-2.74-5.56-5.57H5v-2h1.44C6.92 8.81 9.17 6.55 12 6.07V5h2v1.07c2.83.48 5.08 2.74 5.56 5.57H19v2h-1.44c-.48 2.83-2.73 5.08-5.56 5.57V19h-2v.93zM13 9h-2v6h2V9zm0 8h-2v2h2v-2z"/>
            </svg>
        </button>

    </form>
    <br><br>

    @endsection
