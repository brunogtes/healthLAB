<?php $nav_perfil = 'active'; ?>

@extends('layouts.master')



@section('titulo')

<a class="navbar-brand">@canany(['paciente', 'admin'])Resultado de Exames @else Acesso negado! @endcanany</a>

@endsection

@section('panel-header')

<div class="panel-header panel-header-sm">
</div>

@endsection

@section('content')

<div class="content">

@canany(['paciente', 'admin'])  

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <h5 class="title">Consultar Exames</h5>

                    <div class="row">

                    </div>

                    <div class="table-responsive">

                        <table class="table text-center">
                            <thead class=" text-primary">
                                <th>Paciente</th>
                                <th>Exame</th>
                                <th>Status</th>
                                <th>Opções</th>
                            </thead>
                            <tbody>

                                @foreach($exameFinalizado as $resultadoExame)
                                @if(Auth::guard('usuarios')->user()->id == $resultadoExame->paciente_id)
                                <tr>

                                    @foreach($listaUsuarios as $usuarios)
                                    @if($resultadoExame->paciente_id == $usuarios->id)
                                    <th>{{$usuarios->nome}} {{$usuarios->sobrenome}}</th>
                                    @endif
                                    @endforeach

                                    @foreach($listaExames as $exames)
                                    @if($resultadoExame->exame_id == $exames->id)
                                    <th>{{$exames->descricao}}</th>
                                    @endif
                                    @endforeach


                                    <th>{{$resultadoExame->etapa}}</th>

                                    <th>
                                        @if($resultadoExame->etapa == "Finalizado")
                                        <a href="{{ url('cadastroResulExames/gerarExame', $resultadoExame->resultado_exame_id) }}" target="_blank"><i class="fas fa-download fa-lg" title="Visualizar Exame"></i></a>
                                        @else

                                       

                                        @endif

                                    </th>
                                </tr>
                                @endif
                                @endforeach

                            </tbody>
                        </table>
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


@endcanany 
</div>

@endsection