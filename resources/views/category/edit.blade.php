@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
<div class="container header">
    <div class="row">
        <div class="title-header">
            <h1>Atualizar Categoria</h1>
        </div>
        <div class="button-header">
            <a href="{{route('category.index')}}" class="btn btn-danger icon-btn">
                <i class="fa fa-ban"></i> Cancelar
            </a>
        </div>
    </div>
</div>
@stop

@section('content')
    <section class="content">
        <div class="container">
            <form role="form" action="{{route('category.update', $Category['id'])}}" method="POST">
                @csrf
                @method("PUT")
                <div class="box-body">
                    <div class="form-row">
                        <div class="form-group col-12 col-md-12">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Coloque o nome da categoria" value="{{$Category['name']}}">
                        </div>
                        <div class="form-group col-12 col-md-12">
                            <button type="submit" class="btn btn-primary d-block mx-auto mt-4"><i class="fa fa-save"></i> Salvar</button>
                        </div>
                    </div>
                </div>
            </form>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{$error}}
                    </div>
                @endforeach
            @endif
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/all.css')}}">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop