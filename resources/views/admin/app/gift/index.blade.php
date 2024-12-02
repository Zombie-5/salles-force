@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <form action="{{ route('gift.generate.view') }}" method="GET" class="input-btn" style="justify-content: end">
            @csrf
            <button type="submit">Gerar Presente</button>
        </form>

        <div class="responsive-table">
            <table>
                <thead>
                    <tr>
                        <th>Valor</th>
                        <th>Código</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gifts as $gift)
                        <tr>
                            <td>{{ $gift->value }}</td>
                            <td>
                                <span class="copy-token" data-token="{{ $gift->token }}">
                                    {{ $gift->token }}
                                </span>
                            </td>
                            <td>{{ $gift->status == 'unused'?'N/Resgatado':'Resgatado' }}</td>
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

    <script>
        // Seleciona todos os elementos com a classe 'copy-token'
        document.querySelectorAll('.copy-token').forEach(function(element) {
            element.addEventListener('click', function() {
                // Cria um elemento de input temporário para copiar o valor
                var tempInput = document.createElement('input');
                tempInput.value = element.getAttribute('data-token'); // Pega o valor do token
                document.body.appendChild(tempInput);
                tempInput.select(); // Seleciona o valor

                // Copia o valor para a área de transferência
                document.execCommand('copy');
                
                // Remove o input temporário
                document.body.removeChild(tempInput);
            });
        });
    </script>
@endsection
