@extends('admin.app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina-admin">
        <div class="input-btn" style="justify-content: end">
            <a href="{{ route('admin.machine.index')}}">Voltar</a>
        </div>

        <form class="form" action="{{ route('admin.machine.update',$machine->id ) }}" method="POST">
            @csrf
            @method('PUT')
            <span>Editar Máquina</span>
            <input type="text" value="{{ $machine->name ?? old('name') }}" name="name" placeholder="insira o nome">
            {{ $errors->has('name') ? $errors->first('name') : '' }}
        
            <input type="text" value="{{ $machine->function ?? old('function') }}" name="function" placeholder="insira a função">
            {{ $errors->has('function') ? $errors->first('function') : '' }}

            <input type="text" name="price" value="{{ $machine->price ?? old('price') }}" placeholder="insira o preço">
            {{ $errors->has('price') ? $errors->first('price') : '' }}

            <input type="text" name="income" value="{{ $machine->income ?? old('income') }}" placeholder="insira o retorno diário">
            {{ $errors->has('income') ? $errors->first('income') : '' }}
            
            <input type="text" name="duration" value="{{ $machine->duration ?? old('duration') }}" placeholder="insira a duração">
            {{ $errors->has('duration') ? $errors->first('duration') : '' }}

            <button type="submit">Actualizar</button>
        </form>
    </div>
@endsection
