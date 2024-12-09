@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">

        <br><br>
        <form class="form" action="{{ route('admin.bank.store') }}" method="POST">
            @csrf
            <span>Criar Conta Bancária</span>

            <select id="bankSelect" class="bank-select" name="name">
                <option value="">Selecione um banco</option>
                @foreach ($bancos as $banco)
                    <option value="{{ $banco->name }}">
                        {{ $banco->name }}
                    </option>
                @endforeach
            </select>
            {{ $errors->has('name') ? $errors->first('name') : '' }}

            <input type="text" value="{{ old('owner') }}" name="owner" placeholder="insira o nome do Proprietario">
            {{ $errors->has('owner') ? $errors->first('owner') : '' }}

            <input type="text" name="iban" value="{{ old('iban') }}" placeholder="insira o Iban">
            {{ $errors->has('iban') ? $errors->first('iban') : '' }}

            <input type="hidden" name="isAdmin" value="0">
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

            <button type="submit">Salvar</button>
            <a class="btn-logout ajust" href="{{ route('app.bank')}}">Cancelar</a>
        </form>
    </div>
@endsection
