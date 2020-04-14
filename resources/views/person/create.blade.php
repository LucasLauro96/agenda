@extends('adminlte::page')

@section('title', 'Contatos')

@section('content_header')
<div class="container header">
    <div class="row">
        <div class="title-header">
            <h1>Cadastro de Contato</h1>
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
                @csrf
                <div class="box-body">
                    <div class="form-row">
                        <div class="form-group col-12 col-md-8">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Coloque o nome do contato" required>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="phone">Telefone</label>
                            <input type="text" class="form-control mask-telefone" name="phone" id="phone" placeholder="Coloque um telefone do contato" required>
                        </div>
                        <div class="form-group col-12 col-md-9">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Coloque o email do contato" required>
                        </div>
                        <div class="form-group col-12 col-md-3">
                            <label for="category_id">Categoria</label>
                            <select name="category_id" class="form-control" required>
                                <option value="" style="display:none">Selecione uma categoria</option>
                                @foreach ($Categories as $Category)
                                    <option value="{{$Category['id']}}">{{$Category['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <div class="form-group col-12 col-md-2">
                            <label for="cep">CEP</label>
                            <input type="text" class="form-control mask-cep" name="cep" id="cep" required>
                        </div>
                        <div class="form-group col-12 col-md-3">
                            <label for="street">Rua</label>
                            <input type="text" class="form-control" name="street" id="street" required>
                        </div>
                        <div class="form-group col-12 col-md-2">
                            <label for="neighborhood">Bairro</label>
                            <input type="text" class="form-control" name="neighborhood" id="neighborhood" required>
                        </div>
                        <div class="form-group col-12 col-md-2">
                            <label for="city">Cidade</label>
                            <input type="text" class="form-control" name="city" id="city" required>
                        </div>
                        <div class="form-group col-12 col-md-1">
                            <label for="state">Estado</label>
                            <input type="text" class="form-control" name="state" id="state" required>
                        </div>
                        <div class="form-group col-12 col-md-2">
                            <label for="number">Numero</label>
                            <input type="number" class="form-control" name="number" id="number" required>
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

        $("#formCadastro").validate({
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            rules : { 
                name:{ 
                    required:true 
                },
                phone:{ 
                    required:true 
                },
                email:{ 
                    required:true 
                },
                category_id:{
                    required:true
                },
                cep:{
                    required:true
                },
                street:{
                    required:true
                },
                neighborhood:{
                    required:true
                },
                city:{
                    required:true
                },
                state:{
                    required:true
                },
                number:{
                    required:true
                }
            },
            messages:{
                name:{ 
                    required: "O campo nome é requirido" 
                },
                phone:{ 
                    required: "O campo telefone é requirido" 
                },
                email:{ 
                    required: "O campo email é requirido" 
                },
                category_id:{
                    required: "O campo categoria é requirido"
                },
                cep:{
                    required: "O campo CEP é requirido"
                },
                street:{
                    required: "O campo rua é requirido"
                },
                neighborhood:{
                    required: "O campo bairro é requirido"
                },
                city:{
                    required: "O campo cidade é requirido"
                },
                state:{
                    required: "O campo estado é requirido"
                },
                number:{
                    required: "O campo numero é requirido"
                }
            }
        });
        $("#formCadastro").submit(function(event){
            
            event.preventDefault();
            $('#salvar').html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i> SALVANDO...').attr('disabled', '');

            var formData = $(this).serialize()
            $.ajax({
                type: 'POST',
                url: "{{route('person.store')}}",
                data: formData,
                success: function(data){
                    if(data == 'OK'){
                        Swal.fire({
                            title: 'Contato cadastrado',
                            text: '',
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = "{{route('person.create')}}";   
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
            
        });

        $('#cep').change(function(){
            const cep = $('#cep').val();
            $.ajax({
                type: 'GET',
                url: "https://viacep.com.br/ws/"+ cep +"/json/",
                processData: false,
                contentType: false
            }).done(function(response){
                $('#street').val(response.logradouro);
                $('#neighborhood').val(response.bairro);
                $('#city').val(response.localidade);
                $('#state').val(response.uf);
                $('#number').focus();
                
            });
        });
    </script>
@stop