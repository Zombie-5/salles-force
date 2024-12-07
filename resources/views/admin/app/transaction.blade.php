@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <h1 class="titulo-pagina">Transações</h1>
        <div class="responsive-table">
            <table>
                <thead>
                    <tr>
                        <th>ID do Usuário</th>
                        <th>Acção</th>
                        <th>Valor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td style="text-align: center">{{ 1852+$transaction->userId }}</td>
                            <td>{{ $transaction->action }}</td>
                            <td>{{ $transaction->money }}</td>
                            <td>
                                <form action="{{ route('transaction.status', $transaction->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="select">
                                        <option value="pendente" {{ $transaction->status == 'pendente' ? 'selected' : '' }}>
                                            Pendente</option>
                                        <option value="processando"
                                            {{ $transaction->status == 'processando' ? 'selected' : '' }}>
                                            Processando</option>
                                        <option value="concluido"
                                            {{ $transaction->status == 'concluido' ? 'selected' : '' }}>
                                            Aprovado</option>
                                        <option value="rejeitado"
                                            {{ $transaction->status == 'rejeitado' ? 'selected' : '' }}>
                                            Rejeitado</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhuma Transação encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <br><br><br>
    </div>
@endsection
