@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <form action="{{ route('admin.users') }}" method="GET" class="input-btn">
            @csrf
            <input type="text" name="query" placeholder="Pesquise pelo ID ou Telefone">
            <button type="submit">Pesquisar</button>
        </form>

        <div class="responsive-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Telefone</th>
                        <th>Saldo</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->telefone }}</td>
                            <td>{{number_format($user->money, 2, ',', '.') }} Kz</td>
                            <th>
                                <a href="{{ route('admin.users.show', ['user' => $user->id]) }}">Visualizar</a>
                            </th>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum usuário encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <br><br><br>
    </div>
@endsection
