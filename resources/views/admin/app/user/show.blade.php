@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <form action="{{ route('admin.depositar', $user->id) }}" method="POST" class="input-btn">
            @csrf
            <input name="query" placeholder="insira o valor em Kz">
            <button type="submit">Depositar</button>
            <a href="{{ route('admin.users') }}" class="btn-voltar">Voltar</a>
        </form>

        <div class="responsive-table">
            <table>
                <tr>
                    <th>ID</th>
                    <td>{{ 1852+$user->id }}</td>
                </tr>
                <tr>
                    <th>Telefone</th>
                    <td>{{ $user->telefone }}</td>
                </tr>
                <tr>
                    <th>Renda Hoje</th>
                    <td>{{number_format($user->incomeToday, 2, ',', '.') }} Kz</td>
                </tr>
                <tr>
                    <th>Renda Diária</th>
                    <td>{{number_format($user->incomeDaily, 2, ',', '.') }} Kz</td>
                </tr>
                <tr>
                    <th>Renda Total</th>
                    <td>{{number_format($user->incomeTotal, 2, ',', '.') }} Kz</td>
                </tr>
                <tr>
                    <th>Saldo</th>
                    <td>{{number_format($user->money, 2, ',', '.') }} Kz</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td style="cursor: pointer;">
                        <form action="{{ route('admin.user.status', $user->id) }}" method="POST">
                            @csrf
                            @method('POST') <!-- Necessário para indicar que é um POST -->

                            <!-- Botão de status que alterna entre 'Ativo' e 'Inativo' -->
                            <button type="submit" style="border: none; background: none; cursor: pointer; color: {{ $user->isActive ? 'green' : 'red' }};">
                                {{ $user->isActive ? 'Activo' : 'Inactivo' }}
                            </button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <th>Banco</th>
                    <td>{{ $user->banco ? $user->banco->name : 'Não Fornecido' }}</td>
                </tr>
                <tr>
                    <th>Nome</th>
                    <td>{{ $user->banco ? $user->banco->owner : 'Não Fornecido' }}</td>
                </tr>
                <tr>
                    <th>Iban</th>
                    <td style="cursor: pointer" id="iban-copy"
                        onclick="copyIban('{{ $user->banco ? $user->banco->iban : '' }}')">
                        {{ $user->banco ? $user->banco->iban : 'Não Fornecido' }}
                    </td>
                </tr>
                <tr>
                    <th>Máquinas</th>
                    <td>{{ $user->machines_count }}</td>
                </tr>
                <tr>
                    <th>Criado Em</th>
                    <td>{{ $user->created_at }}</td>
                </tr>

            </table>
        </div>
    </div>

    <script>
        function copyIban(iban) {
            if (iban) {
                // Tenta copiar o valor do IBAN para a área de transferência
                navigator.clipboard.writeText(iban).then(function() {
                    console.log("IBAN copiado para a área de transferência!");
                }).catch(function(err) {
                    console.error("Erro ao copiar o IBAN: ", err);
                });
            } else {
                console.log("IBAN não disponível!");
            }
        }
    </script>
@endsection
