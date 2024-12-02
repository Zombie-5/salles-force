@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <form action="{{ route('admin.bank.edit', $banco->id) }}" method="get" class="input-btn" style="justify-content: end">
            <button type="submit">Editar</button>
            <a href="{{ route('admin.bank.index')}}">Voltar</a>
        </form>

        <div class="responsive-table">
            <table>
                <tr>
                    <th>ID</th>
                    <td>{{ $banco->id }}</td>
                </tr>
                <tr>
                    <th>nome</th>
                    <td>{{ $banco->name }}</td>
                </tr>
                <tr>
                    <th>Proprietario</th>
                    <td>{{ $banco->owner }}</td>
                </tr>
                <tr>
                    <th>Iban</th>
                    <td>{{ chunk_split($banco->iban, 4, ' ') }}</td>
                </tr>
                <tr>
                    <th>Criado Em</th>
                    <td>{{ $banco->created_at }}</td>
                </tr>

            </table>
        </div>
    </div>
@endsection
