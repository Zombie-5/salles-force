@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        <form action="{{ route('transaction.store') }}" method="POST" class="recharge-section">
            @csrf
            <h1>Retirar</h1>
            <div class="balance-myCard">
                <div class="balance-label">Saldo da conta</div>
                <div class="balance-amount">{{ number_format($user->money ?? 0, 2, ',', '.') }} Kz</div>
            </div>

            <input type="hidden" name="action" id="form-action" value="retirar">
            <input type="text" name="query" id="query" placeholder="Insira a quantia em kwanzas">

            <br>
            <div>
                <button type="submit" class="submit-btn">Retirar</button>
                <a class="ajust2" href="{{ route('app.records.withdraw') }}">Registros</a>
            </div>


            <div class="instructions">
                <h5 style="color: black">Regras de Retirada</h5>
                <p>1. Saque mínimo: 1.200 KZ.</p>
                <p>2. Taxa de retirada: 14%.</p>
                <p>3. Horário para solicitação de saque: das 10h às 15h, de segunda a sexta-feira.</p>
                <p>4. Após a solicitação de saque, os fundos serão transferidos para a conta em até 72 horas úteis. Caso o prazo de 72 horas seja excedido, entre em contato com o apoio ao cliente.</p>
            </div>
        </form>
    </div>
@endsection
