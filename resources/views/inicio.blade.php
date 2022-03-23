@extends('layouts.master')

<?php $nav_inicio = 'active'; ?>

@section('titulo')

<a class="navbar-brand">Inicio</a>


@endsection

@section('panel-header')

<div class="panel-header panel-header-lg">
    <img src="img/logo_principal.png" height="80%" width="70%" style="margin-left:auto; margin-right:auto; width:auto;  display: block;">
    <p style="color:white; size:4; text-align: center;">Olá, {{Auth::guard('usuarios')->user()->nome}}</p>
  </div>

@endsection


@section('content')

<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="card card-chart">
            <div class="card-header">
                <h5 class="card-category">Resultados</h5>
                <h4 class="card-title">Exames</h4>
            </div>
            <div class="card-body">
                <div class="chart-area">
                @can('paciente')
                    <p style="text-align: left; padding: 10px;"><a href="../exames" target="_blank">Clique Aqui </a>para consultar seus exames</p>
                @else
                <p style="text-align: left; padding: 10px;">Realizamos toda a gestão dos exames de nossos pacientes</p>
                @endcan
                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card card-chart">
            <div class="card-header">
                <h5 class="card-category">COVID</h5>
                <h4 class="card-title">Corona Virus</h4>
            </div>
            <div class="card-body">
                <div class="chart-area">

                    <p style="text-align: left; padding: 20px;">RT-PCR - Resultado em até 48hs.<br>Antígeno - Resultado em até 1 hora.<br>Sorologia - Resultado em até 24hs.</p>

                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card card-chart">
            <div class="card-header">
                <h5 class="card-category">Ajuda</h5>
                <h4 class="card-title">Precisa de Ajuda?</h4>
            </div>
            <div class="card-body">
                <div class="chart-area">

                    <p style="text-align: left; padding: 20px;">Fale Conosco<br>Contato: (11) XXXX-XXXX<br>Horário de atendimento:<br>Segunda a sexta:das 06h às 22h<br>Sábados e Feriados:das 06h às 18:00h</p>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection