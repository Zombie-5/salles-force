@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <form action="{{ route('notice.create') }}" method="GET" class="input-btn" style="justify-content: end">
            @csrf
            <button type="submit">Criar Noticias</button>
        </form>

        <div class="responsive-table">
            <table>
                <thead>
                    <tr>
                        <th>Notice</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notices as $notice)
                        <tr>
                            <td>{{ $notice->notice }}</td>
                            <td style="cursor: pointer;">
                                <form action="{{ route('notice.status', $notice->id) }}" method="POST">
                                    @csrf
                                    @method('POST') <!-- Necessário para indicar que é um POST -->

                                    <!-- Botão de status que alterna entre 'Ativo' e 'Inativo' -->
                                    <button type="submit" style="border: none; background: none; cursor: pointer; color: {{ $notice->isActive ? 'green' : 'red' }};">
                                        {{ $notice->isActive ? 'Activo' : 'Inactivo' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Nenhuma noticia encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <br><br><br>
    </div>
@endsection
