@extends('adminlte::page')

@section('title', 'Contatos')

@section('content_header')
<div class="container header">
    <div class="row">
        <div class="title-header">
            <h1>Atualizar Contato</h1>
        </div>
        <div class="button-header">
            <a href="{{route('person.index')}}" class="btn btn-danger icon-btn">
                <i class="fa fa-ban"></i> Cancelar
            </a>
        </div>
    </div>
</div>
@stop

@section('content')
    <section class="content">
        <div class="container">
            <form role="form" id="formCadastro">
                @method('PUT')
                <div class="box-body">
                    <div class="form-row">
                        <div class="form-group col-12 col-md-12">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Coloque o nome do contato" value="{{$Person['name']}}">
                        </div>
                        <div class="form-group col-12 col-md-9">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Coloque o email do contato" required value="{{$Person['email']}}">
                        </div>
                        <div class="form-group col-12 col-md-3">
                            <label for="category_id">Categoria</label>
                            <select name="category_id" class="form-control" required>
                                <option value="" style="display:none">Selecione uma categoria</option>
                                @foreach ($Categories as $Category)
                                    <option value="{{$Category['id']}}" {{$Person['category_id'] == $Category['id'] ? 'selected' : ''}} >{{$Category['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-12">
                            <button type="submit" id="salvar" class="btn btn-primary d-block mx-auto mt-4"><i class="fa fa-save"></i> Salvar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/all.css') }}">
@stop
@section('plugins.Sweetalert2', true)
@section('plugins.JqueryValidate', true)
@section('plugins.JqueryMask', true)
@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}" 
            }
        })
        $("#formCadastro").validate({
            errorClass: 'is-invalid',
            validClass: 'is-valid',
        })

        $("#formCadastro").submit(function(event){
            event.preventDefault();
                $('#salvar').html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i> SALVANDO...').attr('disabled', '');

                var formData = $(this).serialize()
                $.ajax({
                    type: 'POST',
                    url: "{{route('person.update', $Person['id'])}}",
                    data: formData,
                    success: function(data){
                        if(data == 'OK'){
                            Swal.fire({
                                title: 'Contato atualizado',
                                text: '',
                                type: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = "{{route('person.edit', $Person['id'])}}";   
                                }
                            })
                        }
                    },
                    error: function(data){
                        $('#salvar').html('<i class="fa fa-save fa-1x fa-fw"></i> Salvar').prop('disabled', false);

                        Swal.fire({
                            type: 'error',
                            title: 'Campos invalidos',
                            text: 'Os campos cadastrados, estão nulos ou invalidos'
                        })
                    }
                });
        })
            
        
    </script>
@stop