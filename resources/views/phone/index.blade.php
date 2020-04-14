@extends('adminlte::page')

@section('title', 'Telefone')

@section('content_header')
<div class="container">
    <div class="header">
        <div class="row">
            <div class="title-header">
                <h1>Telefones</h1>
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
                <div class="form-group col-12 col-md-4">
                    @csrf
                    <input type="text" class="form-control mask-telefone" name="phone" id="phone" placeholder="Coloque um telefone do contato" required>
                    <input type="hidden" name="id" value="{{$id}}">
                </div>
                <div class="form-group col-12 col-md-4">
                    <button type="submit" id="salvar" class="btn btn-primary"><i class="fa fa-plus"></i> Adicionar</button>
                </div>
            </div>
        </div>
    </form>
</div>
@stop

@section('content')
<div class="container">
    <section class="content">
        <table id="dateTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Telefone</th>
                    <th width="15%">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Phones as $Phone)
                    <tr>
                        <td>{{$Phone['phone']}}</td>
                        <td style="text-align: center">
                            <button onclick="updateModal({{$Phone['id']}})" data-toggle="modal" data-target="#modal" class="btn btn-primary" title="Editar"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger" title="Excluir" onclick="destroy({{$Phone['id']}})"><i class="fa fa-trash"></i></button>
                            <form id="delete_{{$Phone['id']}}" action="{{route('phone.destroy', $Phone['id'])}}" method="POST">
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
                <h4 class="modal-title">Atualizar Telefone</h4>
            </div>
            <form id="updateForm" action="{{route('phone.update')}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <label for="phone">Telefone</label>
                    <input type="text" name="modalPhone" id="modalPhone" class="form-control mask-telefone" required>
                    <input type="hidden" name="modalId" id="modalId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
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

        $("#formCadastro").validate({
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            rules : { 
                phone:{ 
                    required:true 
                }
            },
            messages:{
                phone:{ 
                    required: "O campo telefone é requirido" 
                }
            }
        });

        $("#updateForm").validate({
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            rules : { 
                modalPhone:{ 
                    required:true 
                }
            },
            messages:{
                modalPhone:{ 
                    required: "O campo telefone é requirido" 
                }
            }
        });

        $("#formCadastro").submit(function(event){
            
            event.preventDefault();
            $('#salvar').html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i> SALVANDO...').attr('disabled', '');

            var formData = $(this).serialize()
            $.ajax({
                type: 'POST',
                url: "{{route('phone.store')}}",
                data: formData,
                success: function(data){
                    if(data == 'OK'){
                        Swal.fire({
                            title: 'Telefone cadastrado',
                            text: '',
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = "{{route('phone.index', $id)}}";   
                            }
                        })
                    }
                },
                error: function(data){
                    $('#salvar').html('<i class="fa fa-plus fa-1x fa-fw"></i> Adicionar').prop('disabled', false);

                    Swal.fire({
                        type: 'error',
                        title: 'Campo invalidos',
                        text: 'Os campo cadastrado, está nulo ou invalido'
                    })
                }
            });
            
        });

        function updateModal(id){
            $.ajax({
                type: 'GET',
                url: "{{asset('/phone/edit')}}/"+ id,
                data: {id: id}
            }).done(function(response){
                $('#modalPhone').val(response.phone)
                $('#modalId').val(response.id)
                $('#modal').modal();
            })
        }


    function destroy(id){
        Swal.fire({
            title: 'Deletar este telefone?',
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