@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <h1 class="titulo-pagina">Transações</h1>

        <ul class="tab-list">
            <li class="tab-item">
                <a href="#n1" class="tab-link active" data-tab="n1">Depositos</a>
            </li>
            <li class="tab-item">
                <a href="#n2" class="tab-link" data-tab="n2">Retiradas</a>
            </li>
            <li class="tab-item">
                <a href="#n3" class="tab-link" data-tab="n3">Histórico</a>
            </li>
        </ul>

        <div class="tab-content">

            <div id="n1" class="tab-pane active">
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
                            @forelse ($transactionsDeposited as $transaction)
                                <tr>
                                    <td style="text-align: center">{{ $transaction->userId }}</td>
                                    <td>{{ $transaction->action }}</td>
                                    <td>{{ $transaction->money }}</td>

                                    <td>
                                        <!-- Formulário de alteração de status com select -->
                                        <form action="{{ route('transaction.status', $transaction->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()"
                                                class="select @if ($transaction->status == 'pendente') status-pendente @elseif ($transaction->status == 'processando') status-processando @elseif ($transaction->status == 'concluido') status-concluido @elseif ($transaction->status == 'rejeitado') status-rejeitado @endif">
                                                <option value="pendente"
                                                    {{ $transaction->status == 'pendente' ? 'selected' : '' }}>
                                                    Pendente</option>
                                                <option value="processando"
                                                    {{ $transaction->status == 'processando' ? 'selected' : '' }}>
                                                    Processando
                                                </option>
                                                <option value="concluido"
                                                    {{ $transaction->status == 'concluido' ? 'selected' : '' }}>Aprovado
                                                </option>
                                                <option value="rejeitado"
                                                    {{ $transaction->status == 'rejeitado' ? 'selected' : '' }}>Rejeitado
                                                </option>
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

            <div id="n2" class="tab-pane">
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
                            @forelse ($transactionsWithdrawn as $transaction)
                                <tr>
                                    <td style="text-align: center">{{ $transaction->userId }}</td>
                                    <td>{{ $transaction->action }}</td>
                                    <td>{{ $transaction->money }}</td>

                                    <td>
                                        <!-- Formulário de alteração de status com select -->
                                        <form action="{{ route('transaction.status', $transaction->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()"
                                                class="select @if ($transaction->status == 'pendente') status-pendente @elseif ($transaction->status == 'processando') status-processando @elseif ($transaction->status == 'concluido') status-concluido @elseif ($transaction->status == 'rejeitado') status-rejeitado @endif">
                                                <option value="pendente"
                                                    {{ $transaction->status == 'pendente' ? 'selected' : '' }}>
                                                    Pendente</option>
                                                <option value="processando"
                                                    {{ $transaction->status == 'processando' ? 'selected' : '' }}>
                                                    Processando
                                                </option>
                                                <option value="concluido"
                                                    {{ $transaction->status == 'concluido' ? 'selected' : '' }}>Aprovado
                                                </option>
                                                <option value="rejeitado"
                                                    {{ $transaction->status == 'rejeitado' ? 'selected' : '' }}>Rejeitado
                                                </option>
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

            <div id="n3" class="tab-pane">
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
                                    <td style="text-align: center">{{ $transaction->userId }}</td>
                                    <td>{{ $transaction->action }}</td>
                                    <td>{{ $transaction->money }}</td>

                                    <td>
                                        <!-- Formulário de alteração de status com select -->
                                        <form action="{{ route('transaction.status', $transaction->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()"
                                                class="select @if ($transaction->status == 'pendente') status-pendente @elseif ($transaction->status == 'processando') status-processando @elseif ($transaction->status == 'concluido') status-concluido @elseif ($transaction->status == 'rejeitado') status-rejeitado @endif">
                                                <option value="pendente"
                                                    {{ $transaction->status == 'pendente' ? 'selected' : '' }}>
                                                    Pendente</option>
                                                <option value="processando"
                                                    {{ $transaction->status == 'processando' ? 'selected' : '' }}>
                                                    Processando
                                                </option>
                                                <option value="concluido"
                                                    {{ $transaction->status == 'concluido' ? 'selected' : '' }}>Aprovado
                                                </option>
                                                <option value="rejeitado"
                                                    {{ $transaction->status == 'rejeitado' ? 'selected' : '' }}>Rejeitado
                                                </option>
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

        </div>
        <br><br><br>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-link');
            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabId = this.getAttribute('data-tab');

                    // Remove active class from all tabs and panes
                    document.querySelectorAll('.tab-link, .tab-pane').forEach(el => {
                        el.classList.remove('active');
                    });

                    // Add active class to clicked tab and corresponding pane
                    this.classList.add('active');
                    document.getElementById(tabId).classList.add('active');
                });
            });
        });
    </script>
@endsection
