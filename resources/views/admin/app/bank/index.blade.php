@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <form action="{{ route('admin.bank.create') }}" method="GET" class="input-btn" style="justify-content: end">
            @csrf
            <button type="submit">Nova conta bancária</button>
        </form>

        <div class="responsive-table">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Proprietario</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bancos as $banco)
                        <tr>
                            <td>{{ $banco->name }}</td>
                            <td>{{ $banco->owner }}</td>
                            <th>
                                <a href="{{ route('admin.bank.show', ['banco' => $banco->id]) }}">Visualizar</a>
                            </th>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum banco encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <br><br><br>
    </div>
@endsection
