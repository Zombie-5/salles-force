@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <br><br>
        <form class="form" action="{{ route('admin.bank.update', $banco->id) }}" method="POST">
            @csrf
            @method('PUT')

            <span>Editar Conta Bancária</span>
            <input type="text" value="{{ $banco->name ?? old('name') }}" name="name" placeholder="insira o nome">
            {{ $errors->has('name') ? $errors->first('name') : '' }}

            <input type="text" value="{{ $banco->owner ?? old('owner') }}" name="owner" placeholder="insira o nome do Proprietario">
            {{ $errors->has('owner') ? $errors->first('owner') : '' }}

            <input type="text" name="iban" value="{{ $banco->iban ?? old('iban') }}" placeholder="insira o Iban">
            {{ $errors->has('iban') ? $errors->first('iban') : '' }}

            <button type="submit">Actualizar</button>
            <a class="btn-logout ajust" href="{{ route('app.bank')}}">Cancelar</a>
        </form>
    </div>
@endsection
