@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <div class="input-btn" style="justify-content: end">
            <a href="{{ route('admin.machine.index')}}">Voltar</a>
        </div>

        <form class="form" action="{{ route('admin.machine.store') }}" method="POST">
            @csrf
            <span>Criar Máquina</span>
            <input type="text" value="{{ old('name') }}" name="name" placeholder="insira o nome">
            {{ $errors->has('name') ? $errors->first('name') : '' }}
        
            <input type="text" value="{{ old('function') }}" name="function" placeholder="insira a função">
            {{ $errors->has('function') ? $errors->first('function') : '' }}

            <input type="text" name="price" value="{{ old('price') }}" placeholder="insira o preço">
            {{ $errors->has('price') ? $errors->first('price') : '' }}
            
            <input type="text" name="duration" value="{{ old('duration') }}" placeholder="insira a duração">
            {{ $errors->has('duration') ? $errors->first('duration') : '' }}

            <button type="submit">Salvar</button>
        </form>
    </div>
@endsection
