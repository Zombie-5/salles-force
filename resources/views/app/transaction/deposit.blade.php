@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        <form action="{{ route('transaction.store') }}" method="post" class="recharge-section" id="deposit-form">
            @csrf
            <h1>Recarregar</h1>
            <div class="balance-myCard">
                <div class="balance-label">Saldo da conta</div>
                <div class="balance-amount">{{ number_format($user->money ?? 0, 2, ',', '.') }} Kz</div>
            </div>

            <input type="hidden" name="query" id="deposit-amount">
            <input type="hidden" name="action" id="form-action" value="depositar">
            <input type="text" name="custom_amount" id="custom-amount" placeholder="Insira a quantia em kwanzas">

            <div class="news-header">
                <h2></h2>
                <a href="{{ route('app.records.deposit') }}" class="more-link">Registros de Recargas</a>
            </div>

            <div class="amount-grid">
                <button type="button" class="amount-btn" data-value="10000">10000</button>
                <button type="button" class="amount-btn" data-value="20000">20000</button>
                <button type="button" class="amount-btn" data-value="55000">55000</button>
                <button type="button" class="amount-btn" data-value="150000">150000</button>
                <button type="button" class="amount-btn" data-value="250000">25000</button>
                <button type="button" class="amount-btn" data-value="350000">350000</button>
                <button type="button" class="amount-btn" data-value="700000">700000</button>
                <button type="button" class="amount-btn" data-value="1000000">1000000</button>
            </div>

            <button type="submit" class="submit-btn">Enviar</button>

            <div class="instructions">
                <h5 style="color: black">Regras de recarga</h5>
                <p>O valor mínimo do depósito é de 10.000KZ </p>
                <p>1.º Selecione o mesmo banco para transferir fundos. Os fundos chegarão à conta em 10 minutos. Se não
                    utilizar o mesmo banco para transferência, os fundos não chegarão à sua conta a tempo.</p>
                <p>2. Copie o nome do banco, o nome do beneficiário, o número da conta e o valor.</p>
                <p>3. O valor da transferência deve ser consistente ao valor solicitado</p>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const amountButtons = document.querySelectorAll('.amount-btn');
            const depositAmountInput = document.getElementById('deposit-amount');
            const customAmountInput = document.getElementById('custom-amount');
            let isAmountSelected = false;

            if (customAmountInput.value === '') {
                amountButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        // Remove a classe 'selected' de todos os botões
                        amountButtons.forEach(btn => btn.classList.remove('selected'));

                        // Define o valor no input oculto
                        depositAmountInput.value = '';

                        // Marca que um valor foi selecionado
                        isAmountSelected = false;
                    });
                });
            }

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
                    customAmountInput.value = button.getAttribute('data-value');

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
