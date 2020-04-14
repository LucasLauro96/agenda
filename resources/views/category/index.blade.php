@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
<div class="container header">
    <div class="row">
        <div class="title-header">
            <h1>Categorias</h1>
        </div>
        <div class="button-header">
            <a href="{{route('category.create')}}" class="btn btn-primary icon-btn">
                <i class="fa fa-plus"></i> Nova Categoria
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
                    <th>Nome</th>
                    <th width="15%">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Categories as $Category)
                    <tr>
                        <td>{{$Category['id']}}</td>
                        <td>{{$Category['name']}}</td>
                        <td style="text-align: center">
                            <a href="{{route('category.edit', $Category['id'])}}" class="btn btn-primary" title="Editar"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-danger" title="Excluir" onclick="destroy({{$Category['id']}})"><i class="fa fa-trash"></i></button>
                            <form id="delete_{{$Category['id']}}" action="{{route('category.destroy', $Category['id'])}}" method="POST">
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
            "order": [[ 0, "desc" ]],   
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
            title: 'Deletar esta categoria?',
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