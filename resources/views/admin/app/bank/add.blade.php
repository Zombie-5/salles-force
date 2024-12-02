@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <div class="input-btn" style="justify-content: end">
            <a href="{{ route('admin.bank.index')}}">Voltar</a>
        </div>

        <form class="form" action="{{ route('admin.bank.store') }}" method="POST">
            @csrf
            <span>Criar Conta Bancária</span>
            <input type="text" value="{{ old('name') }}" name="name" placeholder="insira o nome">
            {{ $errors->has('name') ? $errors->first('name') : '' }}
        
            <input type="text" value="{{ old('owner') }}" name="owner" placeholder="insira o nome do Proprietario">
            {{ $errors->has('owner') ? $errors->first('owner') : '' }}

            <input type="text" name="iban" value="{{ old('iban') }}" placeholder="insira o Iban">
            {{ $errors->has('iban') ? $errors->first('iban') : '' }}

            <input type="hidden" name="isAdmin" value="1">

            <button type="submit">Salvar</button>
        </form>
    </div>
@endsection
