<?php $nav_perfil = 'active'; ?>

@extends('layouts.master')



@section('titulo')

<a class="navbar-brand">@can('admin')Relatórios @else Acesso negado! @endcan</a>

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
                        <div class="col-md-12">

                            <h4>Cadastros</h4>
                            <hr>
                            <ul class="nav nav-tabs">
                                <li class="col-md-3 active">
                                    <a href="http://localhost:8000/cadastrarUsuarios/pdf" target="_blank">
                                        <div class="card-menu">
                                            <span class="card-icon"><i class="fas fa-user"></i></span>
                                            <span class="card-name">Usuários</span>
                                        </div>

                                    </a>
                                </li>


                                <li class="col-md-3">
                                    <a href="http://localhost:8000/relatorios/convenioPdf" target="_blank">
                                        <div class="card-menu">
                                            <span class="card-icon"><i class="fa fa-file" aria-hidden="true"></i></span>
                                            <span class="card-name">Convênios</span>
                                        </div>

                                    </a>
                                </li>

                                <li class="col-md-3">
                                    <a href="http://localhost:8000/relatorios/planosPdf" target="_blank">
                                        <div class="card-menu">
                                            <span class="card-icon"><i class="fas fa-solid fa-file-medical" aria-hidden="true"></i></span>
                                            <span class="card-name">Planos</span>
                                        </div>

                                    </a>
                                </li>

                                <li class="col-md-3">
                                    <a href="http://localhost:8000/relatorios/examesPdf" target="_blank">
                                        <div class="card-menu">
                                            <span class="card-icon"><i class="fas fa-clipboard-check"></i></span>
                                            <span class="card-name">Exames</span>
                                        </div>
                                    </a>
                                </li>

                            </ul>

                        </div>
                    </div>

                    <h4>Exames</h4>
                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs">
                                <li class="col-md-3 active">
                                    <a href="http://localhost:8000/relatorios/aguardandoColetaPdf" target="_blank">
                                        <div class="card-menu">
                                            <span class="card-icon"><i class="fas fa-syringe"></i></span>
                                            <span class="card-name">Aguardando Coleta</span>
                                        </div>

                                    </a>
                                </li>


                                <li class="col-md-3">
                                    <a href="http://localhost:8000/relatorios/aguardandoResultadoPdf" target="_blank">
                                        <div class="card-menu">
                                            <span class="card-icon"><i class="fas fa-notes-medical"></i></span>
                                            <span class="card-name">Resultado</span>
                                        </div>

                                    </a>
                                </li>

                                <li class="col-md-3">
                                    <a href="http://localhost:8000/relatorios/finalizadoPdf" target="_blank">
                                        <div class="card-menu">
                                            <span class="card-icon"><i class="fas fa-clipboard-check"></i></span>
                                            <span class="card-name">Finalizados</span>
                                        </div>

                                    </a>
                                </li>

                                <li class="col-md-3">
                                    <a href="http://localhost:8000/relatorios/canceladosPdf" target="_blank">
                                        <div class="card-menu">
                                            <span class="card-icon"><i class="far fa-window-close"></i></span>
                                            <span class="card-name">Cancelados</span>
                                        </div>
                                    </a>
                                </li>

                            </ul>

                        </div>
                    </div>

                    <h4>Exame - Por Período</h4>
                    <hr>

                    <form action="/relatorios/customizado" method="get">
                        <div class="row">

                            <div class="col-md-3">
                                <label>Data Inicial:</label>
                                <input type="date" class="form-control" name="data_inicial" id="data_inicial" value="" require>
                            </div>

                            <div class="col-md-3">
                                <label>Data Final:</label>
                                <input type="date" class="form-control" name="data_final" id="data_final" value="" require>
                            </div>

                            <div class="col-md-3">

                                <button type="submit" name="btnRelatorio" id="btnRelatorio" class="btn btn-secondary"><span class="glyphicon glyphicon-check"></span>Gerar Relatório</a>

                            </div>

                        </div>

                    </form>



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