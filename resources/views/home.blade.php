@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-list"></i></span>
            
                        <div class="info-box-content">
                            <span class="info-box-text">Categorias</span>
                            <span class="info-box-number">{{$Categories}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
            
                        <div class="info-box-content">
                            <span class="info-box-text">Contatos</span>
                            <span class="info-box-number">{{$Persons}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-phone"></i></span>
            
                        <div class="info-box-content">
                            <span class="info-box-text">Telefones</span>
                            <span class="info-box-number">{{$Phones[0]->qtde}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-home"></i></span>
            
                        <div class="info-box-content">
                            <span class="info-box-text">Endereços</span>
                            <span class="info-box-number">{{$Addresses[0]->qtde}}</span>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/all.css') }}">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop