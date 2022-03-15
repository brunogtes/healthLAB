<?php $nav_perfil = 'active'; ?>

@extends('layouts.master')



@section('titulo')

<a class="navbar-brand">@can('admin')Relatórios@else Acesso negado! @endcan</a>

@endsection

@section('panel-header')

<div class="panel-header panel-header-sm">
</div>

@endsection

@section('content')
@can('admin')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <!-- Botão que irá abrir o modal -->
                        <h3> </h3>
                        
                        <p style="padding: .375rem .75rem;">
                            <a href="#addConvenio" class="btn btn-primary" data-toggle="modal">Relatorio 1</a>
                        </p>
                        <p style="padding: .375rem .75rem;">
                            <a href="#addConvenio" class="btn btn-primary" data-toggle="modal">Relatorio 2</a>
                        </p>
                        <p style="padding: .375rem .75rem;">
                            <a href="#addConvenio" class="btn btn-primary" data-toggle="modal">Relatorio 3</a>
                        </p>
                        <p style="padding: .375rem .75rem;">
                            <a href="#addConvenio" class="btn btn-primary" data-toggle="modal">Relatorio 4</a>
                        </p>
                        <p style="padding: .375rem .75rem;">
                            <a href="#addConvenio" class="btn btn-primary" data-toggle="modal">Relatorio 5</a>
                        </p>

                    </div>

                    
                </div>
            </div>



        </div>
    </div>

    @else

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                <h4><i class="fa fa-exclamation-circle fa-lg"></i> | Você não tem permissão de acesso.</h4>
                </div>
            </div>
        </div>
    </div> 
  

    @endcan
</div>

@endsection