@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <br>
        <h1 class="titulo-pagina">Selecione o Banco</h1>

        <div class="select-div">
            <select id="bankSelect" class="bank-select bank-info" style="background-color: white">
                <option value="">Selecione um banco</option>
                @foreach ($bancos as $banco)
                    <option value="{{ $banco->id }}" data-name="{{ $banco->owner }}" data-iban="{{ $banco->iban }}"
                        data-money="{{ $money }} ">
                        {{ $banco->name }}
                    </option>
                @endforeach
            </select>

            <div id="bankInfo" class="bank-info">
                <div>
                    <span id="bankName">-- Proprietário da Conta --</span>
                </div>
                <div>
                    <span id="bankIban">Iban</span>
                </div>
                <div>
                    <span id="quant">Quantia</span>
                </div>
            </div>

            <a href="{{ route('app.records.deposit') }}">Concluido</a>
        </div>
    </div>

    <script>
        function formatIban(iban) {
            // Remove qualquer caractere que não seja número ou letra
            iban = iban.replace(/[^A-Za-z0-9]/g, '');

            // Formata o IBAN com espaços a cada 4 caracteres
            return iban.replace(/(.{4})(?=.)/g, '$1 ');
        }

        // Obtém o select e o elemento para exibir as informações do banco
        const bankSelect = document.getElementById('bankSelect');
        const bankInfo = document.getElementById('bankInfo');
        const bankName = document.getElementById('bankName');
        const bankIban = document.getElementById('bankIban');
        const quant = document.getElementById('quant');

        // Adiciona um ouvinte para quando o banco for selecionado
        bankSelect.addEventListener('change', function() {
            const selectedOption = bankSelect.options[bankSelect.selectedIndex];

            // Verifica se um banco foi selecionado
            if (selectedOption.value) {
                const name = selectedOption.getAttribute('data-name');
                const iban = selectedOption.getAttribute('data-iban');
                const money = selectedOption.getAttribute('data-money');

                // Atualiza as informações do banco
                bankName.textContent = name;
                bankIban.textContent = formatIban(iban);
                quant.textContent = money;
            } else {
                // Se não houver banco selecionado, exibe texto padrão
                bankName.textContent = "-- Proprietário da Conta --";
                bankIban.textContent = "-- Iban --";
            }
        });
    </script>
@endsection
