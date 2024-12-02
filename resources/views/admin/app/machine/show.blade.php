@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <form action="{{ route('admin.machine.edit', $machine->id) }}" method="get" class="input-btn" style="justify-content: end">
            <button type="submit">Editar</button>
            <a href="{{ route('admin.machine.index')}}">Voltar</a>
        </form>

        <div class="responsive-table">
            <table>
                <tr>
                    <th>ID</th>
                    <td>{{ $machine->id }}</td>
                </tr>
                <tr>
                    <th>nome</th>
                    <td>{{ $machine->name }}</td>
                </tr>
                <tr>
                    <th>Função</th>
                    <td>{{ $machine->function }}</td>
                </tr>
                <tr>
                    <th>Preço</th>
                    <td>{{ number_format($machine->price, 2, ',', '.') }} kz</td>
                </tr>
                <tr>
                    <th>Renda</th>
                    <td>{{ number_format($machine->income, 2, ',', '.') }} kz</td>
                </tr>
                <tr>
                    <th>Renda Total</th>
                    <td>{{ number_format($machine->income * $machine->duration, 2, ',', '.') }} kz</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <form action="{{ route('admin.machine.status', $machine->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('POST')
                            <button type="submit" style="border: none; background: none; cursor: pointer; color: {{ $machine->isActive ? 'green' : 'red' }};">
                                {{ $machine->isActive ? 'Activo' : 'Inactivo' }}
                            </button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <th>Duração</th>
                    <td>{{ $machine->duration }} Dias</td>
                </tr>
                <tr>
                    <th>Alugados</th>
                    <td>{{ $machine->users_count }}</td>
                </tr>
                <tr>
                    <th>Criado Em</th>
                    <td>{{ $machine->created_at }}</td>
                </tr>

            </table>
        </div>
    </div>
@endsection
