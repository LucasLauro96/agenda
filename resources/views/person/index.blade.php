@extends('adminlte::page')

@section('title', 'Contato')

@section('content_header')
<div class="container header">
    <div class="row">
        <div class="title-header">
            <h1>Contatos</h1>
        </div>
        <div class="button-header">
            <a href="{{route('person.create')}}" class="btn btn-primary icon-btn">
                <i class="fa fa-plus"></i> Novo Contato
            </a>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="container">
    <section class="content">
        <table id="dateTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Contato</th>
                    <th>Categoria</th>
                    <th>Email</th>
                    <th width="20%">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Persons as $Person)
                    <tr>
                        <td>{{$Person->id}}</td>
                        <td>{{$Person->name}}</td>
                        <td>{{$Person->cat}}</td>
                        <td>{{$Person->email}}</td>
                        <td style="text-align: center">
                            <a href="{{route('address.index', $Person->id)}}" class="btn btn-warning" title="Editar"><i class="fa fa-home"></i></a>
                            <a href="{{route('phone.index', $Person->id)}}" class="btn btn-warning" title="Telefones"><i class="fa fa-phone"></i></a>
                            <a href="{{route('person.edit', $Person->id)}}" class="btn btn-primary" title="Editar"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-danger" title="Excluir" onclick="destroy({{$Person->id}})"><i class="fa fa-trash"></i></button>
                            <form id="delete_{{$Person->id}}" action="{{route('person.destroy', $Person->id)}}" method="POST">
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
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/all.css')}}">
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        $('#dateTable').DataTable({
            "paging": true,
            "order": [[ 1, "asc" ]],   
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

    function destroy(id){
        Swal.fire({
            title: 'Deletar este contato?',
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