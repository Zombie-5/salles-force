@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        <form action="{{ route('transaction.store') }}" method="post" class="recharge-section" id="deposit-form">
            @csrf
            <h1>Retirar</h1>
            <div class="balance-card">
                <div class="balance-label">Saldo da conta</div>
                <div class="balance-amount">{{ number_format($user->money ?? 0, 2, ',', '.') }} Kz</div>
            </div>

            <input type="hidden" name="query" id="deposit-amount">
            <input type="hidden" name="action" id="form-action" value="retirar">
            <input type="text" name="custom_amount" id="custom-amount" placeholder="Insira a quantia em kwanzas">

            <br>
            <div>
                <button type="submit" class="submit-btn">Retirar</button>
                <a class="ajust2" href="{{ route('app.records.withdraw') }}">Registros</a>
            </div>


            <div class="instructions">
                <p>O valor mínimo do depósito é de 10.000KZ (horário de carregamento: 9h00 às 21h00)</p>
                <p>Processo de recarga:</p>
                <p>1.º Selecione o mesmo banco para transferir fundos. Os fundos chegarão à conta em 10 minutos. Se não
                    utilizar o mesmo banco para transferência, os fundos não chegarão à sua conta a tempo.</p>
                <p>2. Copie o nome do banco, o nome, o número da conta e o valor.</p>
                <p>3. O valor da transferência deve ser consistente</p>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const amountButtons = document.querySelectorAll('.amount-btn');
            const depositAmountInput = document.getElementById('deposit-amount');
            const customAmountInput = document.getElementById('custom-amount');
            let isAmountSelected = false;

            // Adiciona evento aos botões de valor predefinido
            amountButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove a classe 'selected' de todos os botões
                    amountButtons.forEach(btn => btn.classList.remove('selected'));

                    // Adiciona a classe 'selected' ao botão clicado
                    button.classList.add('selected');

                    // Define o valor no input oculto
                    depositAmountInput.value = button.getAttribute('data-value');

                    // Limpa o campo de entrada personalizada
                    customAmountInput.value = '';

                    // Marca que um valor foi selecionado
                    isAmountSelected = true;
                });
            });

            // Se o campo de valor personalizado for preenchido, marca que não foi selecionado um valor predefinido
            customAmountInput.addEventListener('input', () => {
                if (customAmountInput.value) {
                    depositAmountInput.value = customAmountInput.value;
                    isAmountSelected = false;
                }
            });

            // Quando o formulário for enviado, verifica se o valor foi definido
            const form = document.getElementById('deposit-form');
            form.addEventListener('submit', (event) => {
                // Se nenhum valor foi selecionado nem no campo customizado nem nos botões, impede o envio do formulário
                if (!isAmountSelected && !customAmountInput.value) {
                    event.preventDefault();
                    alert('Por favor, insira um valor para o depósito.');
                }
            });
        });
    </script>
@endsection
