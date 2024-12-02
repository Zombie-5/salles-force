@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <form action="{{ route('admin.machine.create') }}" method="GET" class="input-btn" style="justify-content: end">
            @csrf
            <button type="submit">Nova Máquina</button>
        </form>

        <div class="responsive-table">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Alugados</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($machines as $machine)
                        <tr>
                            <td>{{ $machine->name }}</td>
                            <td>{{ $machine->isActive?"Activo":"Inactivo" }}</td>
                            <td>{{ $machine->users_count }}</td>
                            <th>
                                <a href="{{ route('admin.machine.show', ['machine' => $machine->id]) }}">Visualizar</a>
                            </th>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Nenhuma máquina encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <br><br><br>
    </div>
@endsection
