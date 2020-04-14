@extends('adminlte::page')

@section('title', 'Endereço')

@section('content_header')
<div class="container">
    <div class="header">
        <div class="row">
            <div class="title-header">
                <h1>Endereços</h1>
            </div>
            <div class="button-header">
                <a href="{{route('person.index')}}" class="btn btn-secondary icon-btn">
                    <i class="fa fa-reply"></i> Voltar
                </a>
            </div>
        </div>
    </div>
    <hr>
    <form role="form" id="formCadastro">
        @csrf
        <div class="box-body">
            <div class="form-row">
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
                <input type="hidden" name="id" value="{{$id}}">
                <div class="form-group col-12 col-md-12">
                    <button type="submit" id="salvar" class="btn btn-primary d-block mx-auto mt-4"><i class="fa fa-plus"></i> Adicionar</button>
                </div>
            </div>
        </div>
    </form>
</div>
<hr>
@stop

@section('content')
<div class="container">
    <section class="content">
        <table id="dateTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>CEP</th>
                    <th>Bairro</th>
                    <th>Rua</th>
                    <th>Numero</th>
                    <th>Cidade/UF</th>
                    <th width="15%">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Adresses as $Address)
                    <tr>
                        <td>{{$Address['cep']}}</td>
                        <td>{{$Address['neighborhood']}}</td>
                        <td>{{$Address['street']}}</td>
                        <td>{{$Address['number']}}</td>
                        <td>{{$Address['city']}}/{{$Address['state']}}</td>
                        <td style="text-align: center">
                            <button onclick="updateModal({{$Address['id']}})" data-toggle="modal" data-target="#modal" class="btn btn-primary" title="Editar"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger" title="Excluir" onclick="destroy({{$Address['id']}})"><i class="fa fa-trash"></i></button>
                            <form id="delete_{{$Address['id']}}" action="{{route('address.destroy', $Address['id'])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</div>
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <h4 class="modal-title">Atualizar Endereço</h4>
            </div>
            <form id="updateForm" action="{{route('address.update')}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group col-12">
                    <label for="modalCep">CEP</label>
                    <input type="text" class="form-control mask-cep" name="modalCep" id="modalCep" required>
                </div>
                <div class="form-group col-12">
                    <label for="modalStreet">Rua</label>
                    <input type="text" class="form-control" name="modalStreet" id="modalStreet" required>
                </div>
                <div class="form-group col-12">
                    <label for="modalNeighborhood">Bairro</label>
                    <input type="text" class="form-control" name="modalNeighborhood" id="modalNeighborhood" required>
                </div>
                <div class="form-group col-12">
                    <label for="modalCity">Cidade</label>
                    <input type="text" class="form-control" name="modalCity" id="modalCity" required>
                </div>
                <div class="form-group col-12">
                    <label for="modalState">Estado</label>
                    <input type="text" class="form-control" name="modalState" id="modalState" required>
                </div>
                <div class="form-group col-12">
                    <label for="modalNumber">Numero</label>
                    <input type="number" class="form-control" name="modalNumber" id="modalNumber" required>
                </div>
                <input type="hidden" name="modalId" id="modalId">
                <div class="form-group col-12">
                    <button type="submit" class="btn btn-primary d-block mx-auto mt-4"><i class="fa fa-save"></i> Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/all.css') }}">
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.JqueryValidate', true)
@section('plugins.JqueryMask', true)
@section('js')
    <script>
        $(document).ready(function() {
            $('#dateTable').DataTable({
                "paging": true,  
                responsive: true,         
                "language": {
                    "lengthMenu": "_MENU_ Categorias por paginas",
                    "zeroRecords": "Nada encontrado",
                    "info": "Pagina _PAGE_ de _PAGES_",
                    "infoEmpty": "Pagina 0 de 0",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Pesquisa:",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Ultimo",
                        "next":       "Proximo",
                        "previous":   "Anterior"
                    }
                }
            });
        });

        $("#formCadastro").validate({
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            rules : { 
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

        $("#updateForm").validate({
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            rules : { 
                modalCep:{
                    required:true
                },
                modalStreet:{
                    required:true
                },
                modalNeighborhood:{
                    required:true
                },
                modalCity:{
                    required:true
                },
                modalState:{
                    required:true
                },
                modalNumber:{
                    required:true
                }
            },
            messages:{
                modalCep:{
                    required: "O campo CEP é requirido"
                },
                modalStreet:{
                    required: "O campo rua é requirido"
                },
                modalNeighborhood:{
                    required: "O campo bairro é requirido"
                },
                modalCity:{
                    required: "O campo cidade é requirido"
                },
                modalState:{
                    required: "O campo estado é requirido"
                },
                modalNumber:{
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
                url: "{{route('address.store')}}",
                data: formData,
                success: function(data){
                    if(data == 'OK'){
                        Swal.fire({
                            title: 'Endereço cadastrado',
                            text: '',
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = "{{route('address.index', $id)}}";   
                            }
                        })
                    }
                },
                error: function(data){
                    $('#salvar').html('<i class="fa fa-plus fa-1x fa-fw"></i> Adicionar').prop('disabled', false);

                    Swal.fire({
                        type: 'error',
                        title: 'Campos invalidos',
                        text: 'Os campos cadastrados, estão nulos ou invalidos'
                    })
                }
            });
            
        });

        function updateModal(id){
            $.ajax({
                type: 'GET',
                url: "{{asset('/address/edit')}}/"+ id,
                data: {id: id},
                processData: false,
                contentType: false
            }).done(function(response){
                $('#modalId').val(response.id);
                $('#modalCep').val(response.cep);
                $('#modalStreet').val(response.street);
                $('#modalNeighborhood').val(response.neighborhood);
                $('#modalCity').val(response.city);
                $('#modalState').val(response.state);
                $('#modalNumber').val(response.number);
                $('#modal').modal();
            })
        }
        // *************************************** CEP ********************************************
        function verificaCep(cep, type){
            $.ajax({
                type: 'GET',
                url: "https://viacep.com.br/ws/"+ cep +"/json/",
                processData: false,
                contentType: false
            }).done(function(response){
                if(type == 'insert'){
                    $('#street').val(response.logradouro);
                    $('#neighborhood').val(response.bairro);
                    $('#city').val(response.localidade);
                    $('#state').val(response.uf);
                    $('#number').focus();
                } else if (type == 'update'){
                    $('#modalStreet').val(response.logradouro);
                    $('#modalNeighborhood').val(response.bairro);
                    $('#modalCity').val(response.localidade);
                    $('#modalState').val(response.uf);
                    $('#modalNumber').focus();
                }
            });
        };

        $('#cep').change(function(){
            const cep = $('#cep').val();
            verificaCep(cep, 'insert');
        });

        $('#modalCep').change(function(){
            const cep = $('#modalCep').val();
            verificaCep(cep, 'update');
        });
        // ****************************************************************************************


    function destroy(id){
        Swal.fire({
            title: 'Deletar este endereço?',
            text: '',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não'
        }).then((result) => {
            if (result.value) {
                document.forms["delete_"+id].submit();  
            }
        })
    }
    </script>
@stop