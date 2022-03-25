<?php $nav_perfil = 'active'; ?>

@extends('layouts.master')



@section('titulo')

<a class="navbar-brand">@can('admin')Dashboard @else Acesso negado! @endcan</a>

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

                <h4><i class="fa fa-exclamation-circle fa-lg"></i> | Está página esta em construção</h4>
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