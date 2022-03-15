@extends('layouts.master')


@section('titulo')

<a class="navbar-brand">@canany(['funcionario', 'admin'])Gestão de Exames @else Acesso negado! @endcanany</a>

@endsection

@section('panel-header')

<div class="panel-header panel-header-sm">
</div>

@endsection


@section('content')
<div class="content">
@canany(['funcionario', 'admin'])  

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs">
                                <li class="col-md-3 active">
                                    <a data-toggle="tab" href="#aguardandoColeta">
                                        <div class="card-menu">
                                            <span class="card-icon"><i class="fas fa-syringe"></i></span>
                                            <span class="card-name">Aguardando Coleta</span>
                                        </div>

                                    </a>
                                </li>


                                <li class="col-md-3">
                                    <a data-toggle="tab" href="#aguardandoResultado">
                                        <div class="card-menu">
                                            <span class="card-icon"><i class="fas fa-notes-medical"></i></span>
                                            <span class="card-name">Resultado</span>
                                        </div>

                                    </a>
                                </li>

                                <li class="col-md-3">
                                    <a data-toggle="tab" href="#Finalizados">
                                        <div class="card-menu">
                                            <span class="card-icon"><i class="fas fa-clipboard-check"></i></span>
                                            <span class="card-name">Finalizados</span>
                                        </div>

                                    </a>
                                </li>

                                <li class="col-md-3">
                                    <a data-toggle="tab" href="#Cancelados">
                                        <div class="card-menu">
                                            <span class="card-icon"><i class="far fa-window-close"></i></span>
                                            <span class="card-name">Cancelados</span>
                                        </div>
                                    </a>
                                </li>

                            </ul>

                        </div>
                    </div>

                    <br>

                    <div class="tab-content">
                        <div id="aguardandoColeta" class="tab-pane active">

                            <div class="text-center">
                                <h5>Aguardando Coleta</h5>
                                <hr>
                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    <form action="/search" method="get">

                                        <div class="input-group">
                                            <input class="form-control" type="search" name="search" placeholder="Pesquisar" aria-label="Search" style="border-right: none;">
                                            <div class="input-group-append">
                                                <div class="input-group-text" style="background-color: #FFF"><i class="fas fa-search"></i></div>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                            </div>

                            <div class="table-responsive">

                                <table class="table text-center">
                                    <thead class=" text-primary">
                                        <th scope="col">Paciente</th>
                                        <th scope="col">Exame</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Data e Hora Agendamento</th>
                                        <th scope="col">Opções</th>
                                    </thead>
                                    <tbody>

                                        @foreach($resulExame as $resultadoExame)
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

                                            @if($resultadoExame->data_coleta_exame == "")

                                            <th></th>

                                            @else

                                            <th>{{ date( 'd/m/Y' , strtotime($resultadoExame->data_coleta_exame))}} - {{$resultadoExame->hora_coleta_exame}}</th>
                                            @endif

                                            <th>
                                                <a href="" data-toggle="modal" data-target="#addColetaExame{{$resultadoExame->resultado_exame_id}}"><i class="fas fa-plus fa-lg" title="Confirmar Coleta"></i></a>

                                            </th>
                                        </tr>

                                        @endforeach


                                    </tbody>

                                </table>

                                </form>


                                <!-- Modal Para Adicionar Coleta Exame -->
                                @foreach($resulExame as $resultadoExame)
                                <div class="modal fade" id="addColetaExame{{$resultadoExame->resultado_exame_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">

                                        <!-- Conteúdo do modal-->
                                        <div class="modal-content">

                                            <!-- Cabeçalho do modal -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmar Coleta </h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Corpo do modal -->
                                            <div class="modal-body">

                                                <div clas="span10 offset1">
                                                    <div class="card">

                                                        <div class="card-body">
                                                            <form class="form" action="cadastroResulExames/{{$resultadoExame->resultado_exame_id}}/confirmarColeta" method="post">

                                                                {{method_field('PUT')}}

                                                                <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                                <br>
                                                                <h8>Dados do Exame</h8>
                                                                <hr>

                                                                <div class="row">

                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" style="position:relative; top:7px;">Data Agendada para Coleta:</label>
                                                                        <input type="text" class="form-control" name="dataAgendamentoColeta" id="dataAgendamentoColeta" value="{{ date( 'd/m/Y' , strtotime($resultadoExame->data_coleta_exame))}}" readonly>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" style="position:relative; top:7px;">Hora Agendada para Coleta:</label>
                                                                        <input type="text" class="form-control" name="horaAgendamentoColeta" id="horaAgendamentoColeta" value="{{$resultadoExame->hora_pedido_exame}}" readonly>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" style="position:relative; top:7px;">Status:</label>
                                                                        <input type="text" class="form-control" name="status" id="status" value="{{$resultadoExame->etapa}}" readonly>
                                                                    </div>

                                                                </div>

                                                                <br>
                                                                <h8>Histórico do Exame</h8>
                                                                <hr>

                                                                <div class="row">

                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" style="position:relative; top:7px;">Data Pedido Médico:</label>
                                                                        <input type="date" class="form-control" name="dataPedidoMedico" id="data_exame" value="{{$resultadoExame->data_pedido_exame}}" readonly>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" style="position:relative; top:7px;">Data Coleta:<span style="color: red">*</span></label>
                                                                        <input type="date" class="form-control" name="dataAgendamentoColeta" id="dataAgendamentoColeta" value="" required>
                                                                        @if ($errors->has('dataAgendamentoColeta'))
                                                                        <span class="help-block">
                                                                            <strong>{{ $errors->first('dataAgendamentoColeta') }}</strong>
                                                                        </span>
                                                                        @endif
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" style="position:relative; top:7px;">Data Resultado Exame:</label>
                                                                        <input type="date" class="form-control" name="dataResultadoExame" id="data_exame" value="" readonly>
                                                                    </div>

                                                                </div>
                                                                <div class="row">

                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" style="position:relative; top:7px;">Hora do Pedido Médico:</label>
                                                                        <input type="time" class="form-control" name="horaPedidoMedico" id="hora_exame" value="{{$resultadoExame->hora_pedido_exame}}" readonly>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" style="position:relative; top:7px;">Hora Coleta:<span style="color: red">*</span></label>
                                                                        <input type="time" class="form-control" name="horaAgendamentoColeta" id="horaAgendamentoColeta" value="" required>
                                                                        @if ($errors->has('hora_exame'))
                                                                        <span class="help-block">
                                                                            <strong>{{ $errors->first('hora_exame') }}</strong>
                                                                        </span>
                                                                        @endif
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" style="position:relative; top:7px;">Hora Resultado:</label>
                                                                        <input type="time" class="form-control" name="horaResultado" id="hora_exame" value="" readonly>
                                                                    </div>

                                                                </div>

                                                                <div class="row">

                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" style="position:relative; top:7px;">Médico:</label>
                                                                        @foreach($listaUsuarios as $usuarios)
                                                                        @if($resultadoExame->medico == $usuarios->id)
                                                                        <input type="text" name="nomeMedicoPedido" id="nomePedidoMedico" class="form-control" value="{{$usuarios->nome}} {{$usuarios->sobrenome}}" readonly>
                                                                        @endif
                                                                        @endforeach
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" style="position:relative; top:7px;">Bioquimico Coleta:</label>
                                                                        <input type="text" class="form-control" name="bioquimicoColeta" id="bioquimicoColeta" value="{{Auth::guard('usuarios')->user()->nome}} {{Auth::guard('usuarios')->user()->sobrenome}}" readonly>

                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" style="position:relative; top:7px;">Bioquimico Resultado:</label>
                                                                        <select class="form-control" name="bioquimicoResultado" id="bioquimicoResultado" readonly>
                                                                            <option value=""></option>
                                                                            <option value="Feminino">Bioquimico 1</option>
                                                                            <option value="Masculino">Bioquimico 2</option>
                                                                            <option value="Ambos">Bioquimico 3</option>
                                                                        </select>
                                                                    </div>

                                                                </div>


                                                                <br>
                                                                <h8>Dados do Paciente</h8>
                                                                <hr>

                                                                <div class="row">

                                                                    <div class="col-sm-12">
                                                                        <label class="control-label" style="position:relative; top:7px;">Exame:</label>
                                                                        @foreach($listaExames as $exame)
                                                                        @if($resultadoExame->exame_id == $exame->id)
                                                                        <input type="text" class="form-control" name="exame" id="exame" value="{{$exame->descricao}}" readonly>
                                                                        @endif
                                                                        @endforeach
                                                                    </div>

                                                                </div>

                                                                <div class="row">

                                                                    <div class="col-sm-12">
                                                                        <label class="control-label" style="position:relative; top:7px;">Paciente:</label>
                                                                        @foreach($listaUsuarios as $usuarios)
                                                                        @if($resultadoExame->paciente_id == $usuarios->id)
                                                                        <input type="text" class="form-control" name="paciente" id="paciente" value="{{$usuarios->nome}} {{$usuarios->sobrenome}}" readonly>
                                                                        @endif
                                                                        @endforeach
                                                                    </div>

                                                                </div>

                                                                <div class="row">

                                                                    <div class="col-sm-6">
                                                                        <label class="control-label" style="position:relative; top:7px;">CPF:</label>
                                                                        @foreach($listaUsuarios as $usuarios)
                                                                        @if($resultadoExame->paciente_id == $usuarios->id)
                                                                        <input type="text" class="form-control" name="cpf" id="cpf" value="{{$usuarios->cpf}}" readonly>
                                                                        @endif
                                                                        @endforeach
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <label class="control-label" style="position:relative; top:7px;">Data de Nascimento:</label>
                                                                        @foreach($listaUsuarios as $usuarios)
                                                                        @if($resultadoExame->paciente_id == $usuarios->id)
                                                                        <input type="text" class="form-control" name="data_nascimento" id="data_nascimento" value="{{$usuarios->data_nascimento}}" readonly>
                                                                        @endif
                                                                        @endforeach
                                                                    </div>

                                                                </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                                <button type="submit" name="addResulExames" id="addResulExames" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Cadastrar</a>

                                                    </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endforeach


                                @if ($resulExame->lastPage() > 1)
                                <ul class="pagination justify-content-end">
                                    <li class=" {{ ($resulExame->currentPage() == 1) ? ' page-item disabled' : '' }}">
                                        <a class="page-link" href="{{ $resulExame->url(1) }}">Anterior</a>
                                    </li>
                                    @for ($i = 1; $i <= $resulExame->lastPage(); $i++)
                                        <li class="{{ ($resulExame->currentPage() == $i) ? ' page-item active' : '' }}">
                                            <a class="page-link" href="{{ $resulExame->url($i) }}">{{ $i }}</a>
                                        </li>
                                        @endfor
                                        <li class="{{ ($resulExame->currentPage() == $resulExame->lastPage()) ? '  page-item disabled' : '' }}">
                                            <a class="page-link" href="{{ $resulExame->url($resulExame->currentPage()+1) }}">Proximo</a>
                                        </li>
                                </ul>
                                @endif

                            </div>


                        </div> <!-- end tab aguardandoColeta -->

                        <div id="aguardandoResultado" class="tab-pane fade">

                            <div class="text-center">
                                <h5>Aguardando Resultado</h5>
                                <hr>
                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    <form action="/search" method="get">

                                        <div class="input-group">
                                            <input class="form-control" type="search" name="search" placeholder="Pesquisar" aria-label="Search" style="border-right: none;">
                                            <div class="input-group-append">
                                                <div class="input-group-text" style="background-color: #FFF"><i class="fas fa-search"></i></div>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                            </div>

                            <div class="table-responsive">

                                <table class="table text-center">
                                    <thead class=" text-primary">
                                        <th scope="col">Paciente</th>
                                        <th scope="col">Exame</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Dia e Hora da Coleta</th>
                                        <th scope="col">Opções</th>
                                    </thead>
                                    <tbody>
                                        @foreach($aguardandoResultado as $resultadoExame)
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

                                            @if($resultadoExame->data_coleta_exame == "")

                                            <th></th>

                                            @else

                                            <th>{{ date( 'd/m/Y' , strtotime($resultadoExame->data_coleta_exame))}} - {{$resultadoExame->hora_coleta_exame}}</th>
                                            @endif

                                            <th>
                                                <a href="" data-toggle="modal" data-target="#editResulExame{{$resultadoExame->resultado_exame_id}}"><i class="fas fa-check-circle fa-lg" title="Concluir Exame"></i></a>
                                            </th>
                                        </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                                </form>

                            </div>

                            <!-- Modal Para Adicionar Novo Resultado Exame -->
                            @foreach($aguardandoResultado as $resultadoExame)
                            <div class="modal fade" id="editResulExame{{$resultadoExame->resultado_exame_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">

                                    <!-- Conteúdo do modal-->
                                    <div class="modal-content">

                                        <!-- Cabeçalho do modal -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Cadastrar Resultado Exame</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Corpo do modal -->
                                        <div class="modal-body">

                                            <div clas="span10 offset1">
                                                <div class="card">

                                                    <div class="card-body">
                                                        <form class="form" action="cadastroResulExames/inserirResultado/{{$resultadoExame->resultado_exame_id}}" method="post">

                                                            {{method_field('PUT')}}

                                                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                            <br>
                                                            <h8>Dados do Exame</h8>
                                                            <hr>

                                                            <div class="row">

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Data Agendada para Coleta:</label>
                                                                    <input type="text" class="form-control" name="dataAgendamentoColeta" id="dataAgendamentoColeta" value="{{ date( 'd/m/Y' , strtotime($resultadoExame->data_coleta_exame))}}" readonly>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Hora Agendada para Coleta:</label>
                                                                    <input type="text" class="form-control" name="horaAgendamentoColeta" id="horaAgendamentoColeta" value="{{$resultadoExame->hora_pedido_exame}}" readonly>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Status:</label>
                                                                    <input type="text" class="form-control" name="status" id="status" value="{{$resultadoExame->etapa}}" readonly>
                                                                </div>

                                                            </div>

                                                            <br>
                                                            <h8>Histórico do Exame</h8>
                                                            <hr>

                                                            <div class="row">

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Data Pedido Médico:</label>
                                                                    <input type="date" class="form-control" name="dataPedidoMedico" id="data_exame" value="{{$resultadoExame->data_pedido_exame}}" readonly>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Data Coleta:</label>
                                                                    <input type="date" class="form-control" name="dataAgendamentoColeta" id="dataAgendamentoColeta" value="{{$resultadoExame->data_coleta_exame}}" readonly>

                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Data Resultado Exame:<span style="color: red">*</span></label>
                                                                    <input type="date" class="form-control" name="dataResultadoExame" id="data_exame" value="" required>
                                                                    @if ($errors->has('dataResultadoExame'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('dataResultadoExame') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                            <div class="row">

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Hora do Pedido Médico:</label>
                                                                    <input type="time" class="form-control" name="horaPedidoMedico" id="hora_exame" value="{{$resultadoExame->hora_pedido_exame}}" readonly>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Hora Coleta:</label>
                                                                    <input type="time" class="form-control" name="horaAgendamentoColeta" id="horaAgendamentoColeta" value="{{$resultadoExame->hora_coleta_exame}}" readonly>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Hora Resultado:<span style="color: red">*</span></label>
                                                                    <input type="time" class="form-control" name="horaResultado" id="horaResultado" value="" required>
                                                                    @if ($errors->has('horaResultado'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('horaResultado') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Médico:</label>
                                                                    @foreach($listaUsuarios as $usuarios)
                                                                    @if($resultadoExame->medico == $usuarios->id)
                                                                    <input type="text" name="nomeMedicoPedido" id="nomePedidoMedico" class="form-control" value="{{$usuarios->nome}} {{$usuarios->sobrenome}}" readonly>
                                                                    @endif
                                                                    @endforeach
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Bioquimico Coleta:</label>
                                                                    <input type="text" class="form-control" name="bioquimicoColeta" id="bioquimicoColeta" value="{{$resultadoExame->bioquimico_coleta}}" readonly>

                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Bioquimico Resultado:</label>
                                                                    <input type="text" class="form-control" name="bioquimicoResultado" id="bioquimicoResultado" value="{{Auth::guard('usuarios')->user()->nome}} {{Auth::guard('usuarios')->user()->sobrenome}}" readonly>

                                                                </div>

                                                            </div>


                                                            <br>
                                                            <h8>Dados do Paciente</h8>
                                                            <hr>

                                                            <div class="row">

                                                                <div class="col-sm-12">
                                                                    <label class="control-label" style="position:relative; top:7px;">Exame:</label>
                                                                    @foreach($listaExames as $exame)
                                                                    @if($resultadoExame->exame_id == $exame->id)
                                                                    <input type="text" class="form-control" name="exame" id="exame" value="{{$exame->descricao}}" readonly>
                                                                    @endif
                                                                    @endforeach
                                                                </div>

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-sm-12">
                                                                    <label class="control-label" style="position:relative; top:7px;">Paciente:</label>
                                                                    @foreach($listaUsuarios as $usuarios)
                                                                    @if($resultadoExame->paciente_id == $usuarios->id)
                                                                    <input type="text" class="form-control" name="paciente" id="paciente" value="{{$usuarios->nome}} {{$usuarios->sobrenome}}" readonly>
                                                                    @endif
                                                                    @endforeach
                                                                </div>

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-sm-6">
                                                                    <label class="control-label" style="position:relative; top:7px;">CPF:</label>
                                                                    @foreach($listaUsuarios as $usuarios)
                                                                    @if($resultadoExame->paciente_id == $usuarios->id)
                                                                    <input type="text" class="form-control" name="cpf" id="cpf" value="{{$usuarios->cpf}}" readonly>
                                                                    @endif
                                                                    @endforeach
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <label class="control-label" style="position:relative; top:7px;">Data de Nascimento:</label>
                                                                    @foreach($listaUsuarios as $usuarios)
                                                                    @if($resultadoExame->paciente_id == $usuarios->id)
                                                                    <input type="text" class="form-control" name="data_nascimento" id="data_nascimento" value="{{$usuarios->data_nascimento}}" readonly>
                                                                    @endif
                                                                    @endforeach
                                                                </div>

                                                            </div>


                                                            <br>
                                                            <h6>Itens:</h6>
                                                            <hr>

                                                            <div class="row">

                                                                <div class="col-sm-12">

                                                                    <table class="table text-center">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="font-size: 14px;">Item</th>
                                                                                <th style="font-size: 14px;">Resultado</th>
                                                                                <th style="font-size: 14px;">Observações</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $count = 1; ?>
                                                                            @foreach($itensResultadoExame as $itensdoExame)
                                                                            @if($itensdoExame->id_pedido_medico == $resultadoExame->resultado_exame_id ) <tr>
                                                                                <th>{{$itensdoExame->descricao_item}}</th>
                                                                                <td><input type="text" class="form-control" name="resultado_{{   $count}}" id="resultado_{{   $count}}" required></td>
                                                                                <td><input type="text" class="form-control" name="observacoes_{{   $count}}" id="observacoes_{{ $count}}"></td>
                                                                                <td style="display: none;"><input type="hidden" class="form-control" name="id_{{$count}}" id="id_{{$count}}" value="{{$itensdoExame->id_item_exame}}"></td>

                                                                            </tr>
                                                                            <?php $count++; ?>
                                                                            @endif
                                                                            @endforeach


                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                            <button type="submit" name="addResulExames" id="addResulExames" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Cadastrar</a>

                                                </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endforeach


                        </div> <!-- end tab aguardandoResultado -->

                        <div id="Finalizados" class="tab-pane fade">

                            <div class="text-center">
                                <h5>Finalizados</h5>
                                <hr>
                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    <form action="/search" method="get">

                                        <div class="input-group">
                                            <input class="form-control" type="search" name="search" placeholder="Pesquisar" aria-label="Search" style="border-right: none;">
                                            <div class="input-group-append">
                                                <div class="input-group-text" style="background-color: #FFF"><i class="fas fa-search"></i></div>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                            </div>

                            <div class="table-responsive">

                                <table class="table text-center">
                                    <thead class=" text-primary">
                                        <th scope="col">Paciente</th>
                                        <th scope="col">Exame</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Dia e Hora do Resultado</th>
                                        <th scope="col">Opções</th>
                                    </thead>
                                    <tbody>
                                        @foreach($exameFinalizado as $resultadoExame)
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

                                            @if($resultadoExame->data_coleta_exame == "")

                                            <th></th>

                                            @else

                                            <th>{{ date( 'd/m/Y' , strtotime($resultadoExame->data_coleta_exame))}} - {{$resultadoExame->hora_coleta_exame}}</th>
                                            @endif

                                            <th>
                                                <a href="{{ url('cadastroResulExames/gerarExame', $resultadoExame->resultado_exame_id) }}" target="_blank"><i class="fas fa-download fa-lg" title="Visualizar Exame"></i></a>
                                                
                                            </th>
                                        </tr>

                                        @endforeach


                                    </tbody>

                                </table>

                                </form>

                            </div>

                            <!-- Modal Para Visualizar Resultado Exame -->

                            <div class="modal fade" id="visualizarResulExame" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">

                                    <!-- Conteúdo do modal-->
                                    <div class="modal-content">

                                        <!-- Cabeçalho do modal -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Cadastrar Resultado Exame</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Corpo do modal -->
                                        <div class="modal-body">

                                            <div clas="span10 offset1">
                                                <div class="card">

                                                    <div class="card-body">
                                                        <form class="form" action="cadastroResulExames/create" method="get">

                                                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                            <br>
                                                            <h8>Dados do Exame</h8>
                                                            <hr>

                                                            <div class="row">

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Data Agendada para Coleta:</label>
                                                                    <input type="date" class="form-control" name="dataAgendamentoColeta" id="dataAgendamentoColeta" value="" readonly>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Hora Agendada para Coleta:</label>
                                                                    <input type="date" class="form-control" name="horaAgendamentoColeta" id="horaAgendamentoColeta" value="" readonly>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Status:</label>
                                                                    <input type="text" class="form-control" name="status" id="status" value="Finalizado" readonly>
                                                                </div>

                                                            </div>

                                                            <br>
                                                            <h8>Histórico do Exame</h8>
                                                            <hr>

                                                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                            <div class="row">

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Data Pedido Médico:</label>
                                                                    <input type="date" class="form-control" name="dataPedidoMedico" id="data_exame" value="" readonly>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Data Coleta:</label>
                                                                    <input type="date" class="form-control" name="dataAgendamentoColeta" id="data_exame" value="" readonly>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Data Resultado Exame:</label>
                                                                    <input type="date" class="form-control" name="dataResultadoExame" id="data_exame" value="" readonly>
                                                                </div>

                                                            </div>
                                                            <div class="row">

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Hora do Pedido Médico:</label>
                                                                    <input type="time" class="form-control" name="horaPedidoMedico" id="hora_exame" value="" readonly>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Hora Coleta:</label>
                                                                    <input type="time" class="form-control" name="horaAgendamentoColeta" id="hora_exame" value="" readonly>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Hora Resultado:</label>
                                                                    <input type="time" class="form-control" name="horaResultado" id="hora_exame" value="" readonly>
                                                                </div>

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Médico:</label>
                                                                    <input type="text" name="nomeMedicoPedido" id="nomePedidoMedico" class="form-control" readonly>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Bioquimico Coleta:</label>
                                                                    <select class="form-control" name="bioquimicoColeta" id="bioquimicoColeta" readonly>
                                                                        <option value=""></option>
                                                                        <option value="Feminino">Bioquimico 1</option>
                                                                        <option value="Masculino">Bioquimico 2</option>
                                                                        <option value="Ambos">Bioquimico 3</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Bioquimico Resultado:</label>
                                                                    <select class="form-control" name="bioquimicoResultado" id="bioquimicoResultado" readonly>
                                                                        <option value=""></option>
                                                                        <option value="Feminino">Bioquimico 1</option>
                                                                        <option value="Masculino">Bioquimico 2</option>
                                                                        <option value="Ambos">Bioquimico 3</option>
                                                                    </select>
                                                                </div>

                                                            </div>


                                                            <br>
                                                            <h8>Dados do Paciente</h8>
                                                            <hr>


                                                            <div class="row">

                                                                <div class="col-sm-8">
                                                                    <label class="control-label" style="position:relative; top:7px;">Paciente:</label>
                                                                    <input type="text" class="form-control" name="paciente" id="paciente" value="" readonly>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">CPF:</label>
                                                                    <input type="text" class="form-control" name="cpf" id="cpf" value="" readonly>
                                                                </div>

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-sm-6">
                                                                    <label class="control-label" style="position:relative; top:7px;">Convênio:</label>
                                                                    <input type="text" class="form-control" name="convenio" id="convenio" value="" readonly>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <label class="control-label" style="position:relative; top:7px;">Plano:</label>
                                                                    <input type="text" class="form-control" name="plano" id="plano" value="" readonly>
                                                                </div>

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-sm-12">
                                                                    <label class="control-label" style="position:relative; top:7px;">Exame:</label>
                                                                    <input type="text" class="form-control" name="exame" id="exame" value="" readonly>
                                                                </div>

                                                            </div>


                                                            <br>
                                                            <h6>Itens:</h6>
                                                            <hr>

                                                            <div class="row">

                                                                <div class="col-sm-12">

                                                                    <table class="table text-center">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="font-size: 14px;">Código</th>
                                                                                <th style="font-size: 14px;">Item</th>
                                                                                <th style="font-size: 14px;">Valor de Referência</th>
                                                                                <th style="font-size: 14px;">Resultado</th>
                                                                                <th style="font-size: 14px;">Observações</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <th>1</th>
                                                                                <td>Item</td>
                                                                                <td>Valor</td>
                                                                                <td><input type="text" class="form-control" name="resultado" id="resultado" readonly></td>
                                                                                <td><input type="text" class="form-control" name="observacoes" id="observacoes" readonly></td>
                                                                            </tr>

                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>Fechar</button>


                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>




                        </div> <!-- end tab Finalizados -->

                        <div id="Cancelados" class="tab-pane fade">

                            <div class="text-center">
                                <h5>Cancelados</h5>
                                <hr>
                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    <form action="/search" method="get">

                                        <div class="input-group">
                                            <input class="form-control" type="search" name="search" placeholder="Pesquisar" aria-label="Search" style="border-right: none;">
                                            <div class="input-group-append">
                                                <div class="input-group-text" style="background-color: #FFF"><i class="fas fa-search"></i></div>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                            </div>

                            <div class="table-responsive">

                                <table class="table text-center">
                                    <thead class=" text-primary">
                                        <th scope="col">Paciente</th>
                                        <th scope="col">Exame</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Data Cancelamento</th>
                                        <th scope="col">Opções</th>
                                    </thead>
                                    <tbody>
                                    @foreach($exameFinalizado as $resultadoExame)
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

                                            @if($resultadoExame->data_coleta_exame == "")

                                            <th></th>

                                            @else

                                            <th>{{ date( 'd/m/Y' , strtotime($resultadoExame->data_coleta_exame))}} - {{$resultadoExame->hora_coleta_exame}}</th>
                                            @endif

                                            <th>
                                                
                                                <a href="" data-toggle="modal" data-target="#visualizarCancelamento{{$resultadoExame->resultado_exame_id}}"><i class="fas fa-eye fa-lg" title="Visualizar Motivo do Cancelamento"></i></a>
                                                
                                            </th>
                                        </tr>

                                        @endforeach

                                         
                                                
                                     


                                    </tbody>

                                </table>

                                </form>

                            </div>

                            <!-- Modal Para Visualizar Cancelamento do Exame -->

                            <div class="modal fade" id="visualizarCancelamento{{$resultadoExame->resultado_exame_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">

                                    <!-- Conteúdo do modal-->
                                    <div class="modal-content">

                                        <!-- Cabeçalho do modal -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Motivo do Cancelamento</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Corpo do modal -->
                                        <div class="modal-body">

                                            <div clas="span10 offset1">
                                                <div class="card">

                                                    <div class="card-body">
                                                        <form class="form" action="cadastroResulExames/show" method="get">

                                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                            <div class="row">

                                                                <div class="col-sm-12">
                                                                    <label class="control-label" style="position:relative; top:7px;">Motivo do Cancelamento:</label>
                                                                    <p>{{$resultadoExame->motivo_cancelamento}}</p>
                                                                </div>
                                                            </div>

                                                            <br>
                                                            <h8>Histórico do Exame</h8>
                                                            <hr>

                                                            <div class="row">

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Data Pedido Médico:</label>
                                                                    <input type="date" class="form-control" name="dataPedidoMedico" id="data_exame" value="{{$resultadoExame->data_pedido_exame}}" readonly>
                                                                </div>

                                                               

                                                            </div>
                                                            <div class="row">

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Hora do Pedido Médico:</label>
                                                                    <input type="time" class="form-control" name="horaPedidoMedico" id="hora_exame" value="{{$resultadoExame->hora_pedido_exame}}" readonly>
                                                                </div>
                                                                

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-sm-4">
                                                                    <label class="control-label" style="position:relative; top:7px;">Médico:</label>
                                                                    @foreach($listaUsuarios as $usuarios)
                                                                    @if($resultadoExame->medico == $usuarios->id)
                                                                    <input type="text" name="nomeMedicoPedido" id="nomePedidoMedico" class="form-control" value="{{$usuarios->nome}} {{$usuarios->sobrenome}}" readonly>
                                                                    @endif
                                                                    @endforeach
                                                                </div>

                                                               
                                                            </div>


                                                            <br>
                                                            <h8>Dados do Paciente</h8>
                                                            <hr>

                                                            <div class="row">

                                                                <div class="col-sm-12">
                                                                    <label class="control-label" style="position:relative; top:7px;">Exame:</label>
                                                                    @foreach($listaExames as $exame)
                                                                    @if($resultadoExame->exame_id == $exame->id)
                                                                    <input type="text" class="form-control" name="exame" id="exame" value="{{$exame->descricao}}" readonly>
                                                                    @endif
                                                                    @endforeach
                                                                </div>

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-sm-12">
                                                                    <label class="control-label" style="position:relative; top:7px;">Paciente:</label>
                                                                    @foreach($listaUsuarios as $usuarios)
                                                                    @if($resultadoExame->paciente_id == $usuarios->id)
                                                                    <input type="text" class="form-control" name="paciente" id="paciente" value="{{$usuarios->nome}} {{$usuarios->sobrenome}}" readonly>
                                                                    @endif
                                                                    @endforeach
                                                                </div>

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-sm-6">
                                                                    <label class="control-label" style="position:relative; top:7px;">CPF:</label>
                                                                    @foreach($listaUsuarios as $usuarios)
                                                                    @if($resultadoExame->paciente_id == $usuarios->id)
                                                                    <input type="text" class="form-control" name="cpf" id="cpf" value="{{$usuarios->cpf}}" readonly>
                                                                    @endif
                                                                    @endforeach
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <label class="control-label" style="position:relative; top:7px;">Data de Nascimento:</label>
                                                                    @foreach($listaUsuarios as $usuarios)
                                                                    @if($resultadoExame->paciente_id == $usuarios->id)
                                                                    <input type="text" class="form-control" name="data_nascimento" id="data_nascimento" value="{{$usuarios->data_nascimento}}" readonly>
                                                                    @endif
                                                                    @endforeach
                                                                </div>

                                                            </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>Fechar</button>


                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div> <!-- end tab Cancelados -->
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