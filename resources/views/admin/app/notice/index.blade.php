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
                            <td>{{ $notice->isActive ? 'Activo':'Inactivo' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Nenhum presente encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <br><br><br>
    </div>
@endsection
