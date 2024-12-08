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
                <p>O valor mínimo do depósito é de 10.000KZ (horário de carregamento: 9h00 às 21h00)</p>
                <p>Processo de recarga:</p>
                <p>1.º Selecione o mesmo banco para transferir fundos. Os fundos chegarão à conta em 10 minutos. Se não
                    utilizar o mesmo banco para transferência, os fundos não chegarão à sua conta a tempo.</p>
                <p>2. Copie o nome do banco, o nome, o número da conta e o valor.</p>
            </div>
        </form>
    </div>
@endsection
