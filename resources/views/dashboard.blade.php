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
 
<!-- Usuarios -->
<input type="hidden" name="usuariosAtivos" id="usuariosAtivos" value="{{$usuariosAtivos}}" >
<input type="hidden" name="usuariosInativos" id="usuariosInativos" value="{{$usuariosInativos}}" >
<input type="hidden" name="testeBruno" id="testeBruno" value="10,40" >

<!-- Exames -->

<input type="hidden" name="ExamesAtivos" id="ExamesAtivos" value="{{$ExamesAtivos}}" >
<input type="hidden" name="ExamesInativos" id="ExamesInativos" value="{{$ExamesInativos}}" >

<!-- Convenios -->

<input type="hidden" name="ConveniosAtivo" id="ConveniosAtivo" value="{{$ConveniosAtivo}}" >
<input type="hidden" name="ConveniosInativos" id="ConveniosInativos" value="{{$ConveniosInativos}}" >

<!-- Status Exames -->

<input type="hidden" name="aguardandoColeta" id="aguardandoColeta" value="{{$aguardandoColeta}}" >
<input type="hidden" name="aguardandoResultado" id="aguardandoResultado" value="{{$aguardandoResultado}}" >
<input type="hidden" name="exameFinalizado" id="exameFinalizado" value="{{$exameFinalizado}}" >
<input type="hidden" name="exameCancelado" id="exameCancelado" value="{{$exameCancelado}}" >

<!-- Quantidade de Exames - Mensal -->

<input type="hidden" name="qtdMes1" id="qtdMes1" value="{{$qtdMes1}}" >
<input type="hidden" name="qtdMes2" id="qtdMes2" value="{{$qtdMes2}}" >
<input type="hidden" name="qtdMes3" id="qtdMes3" value="{{$qtdMes3}}" >
<input type="hidden" name="qtdMes4" id="qtdMes4" value="{{$qtdMes4}}" >
<input type="hidden" name="qtdMes5" id="qtdMes5" value="{{$qtdMes5}}" >
<input type="hidden" name="qtdMes6" id="qtdMes6" value="{{$qtdMes6}}" >
<input type="hidden" name="qtdMes7" id="qtdMes7" value="{{$qtdMes7}}" >
<input type="hidden" name="qtdMes8" id="qtdMes8" value="{{$qtdMes8}}" >
<input type="hidden" name="qtdMes9" id="qtdMes9" value="{{$qtdMes9}}" >
<input type="hidden" name="qtdMes10" id="qtdMes10" value="{{$qtdMes10}}" >
<input type="hidden" name="qtdMes11" id="qtdMes11" value="{{$qtdMes11}}" >
<input type="hidden" name="qtdMes12" id="qtdMes12" value="{{$qtdMes12}}" >

<input type="hidden" name="teste" id="teste" value="{{$teste}}" >

<!-- Quantidade de Coletas - Mensal-->

<input type="hidden" name="qtdColetaMes1" id="qtdColetaMes1" value="{{$qtdColetaMes1}}" >
<input type="hidden" name="qtdColetaMes2" id="qtdColetaMes2" value="{{$qtdColetaMes2}}" >
<input type="hidden" name="qtdColetaMes3" id="qtdColetaMes3" value="{{$qtdColetaMes3}}" >
<input type="hidden" name="qtdColetaMes4" id="qtdColetaMes4" value="{{$qtdColetaMes4}}" >
<input type="hidden" name="qtdColetaMes5" id="qtdColetaMes5" value="{{$qtdColetaMes5}}" >
<input type="hidden" name="qtdColetaMes6" id="qtdColetaMes6" value="{{$qtdColetaMes6}}" >
<input type="hidden" name="qtdColetaMes7" id="qtdColetaMes7" value="{{$qtdColetaMes7}}" >
<input type="hidden" name="qtdColetaMes8" id="qtdColetaMes8" value="{{$qtdColetaMes8}}" >
<input type="hidden" name="qtdColetaMes9" id="qtdColetaMes9" value="{{$qtdColetaMes9}}" >
<input type="hidden" name="qtdColetaMes10" id="qtdColetaMes10" value="{{$qtdColetaMes10}}" >
<input type="hidden" name="qtdColetaMes11" id="qtdColetaMes11" value="{{$qtdColetaMes11}}" >
<input type="hidden" name="qtdColetaMes12" id="qtdColetaMes12" value="{{$qtdColetaMes12}}" >



    <div class="row">
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Usuários</h4>

                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="doughnutChart" style="max-width: 100%;"></canvas>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Exames</h4>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="doughnutChartExames" style="max-width: 100%;"></canvas>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Convênios</h4>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="doughnutChartConvenios" style="max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card  card-tasks">
                <div class="card-header ">
                    <h5 class="card-title">Quantidade de Exames - Mensal</h5>
                </div>
                <div class="card-body ">
                    <div class="chart-area">
                        <canvas id="barChart"></canvas>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Status de Exames</h5>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="pieChart" style="max-width: 500px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Quantidade de Coletas -  Mensal</h5>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                    <canvas id="horizontalBar"></canvas>
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

