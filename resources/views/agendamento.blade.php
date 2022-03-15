@extends('layouts.master')

@section('titulo')

<a class="navbar-brand">@canany(['funcionario', 'admin']) Agendamento @else Acesso negado! @endcanany</a>

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

                                @foreach($listaPedidoMedicos as $pedidosMedicos)

                                <tr>

                                    @foreach($listaUsuarios as $usuarios)
                                    @if($pedidosMedicos->paciente_id == $usuarios->id)
                                    <th>{{$usuarios->nome}} {{$usuarios->sobrenome}}</th>
                                    @endif
                                    @endforeach


                                    @foreach($listaExames as $exames)
                                    @if($pedidosMedicos->exame_id == $exames->id)
                                    <th>{{$exames->descricao}}</th>
                                    @endif
                                    @endforeach

                                    <th>{{$pedidosMedicos->etapa}}</th>

                                    @if($pedidosMedicos->data_coleta_exame == "")

                                    <th></th>

                                    @else

                                    <th>{{ date( 'd/m/Y' , strtotime($pedidosMedicos->data_coleta_exame))}} - {{$pedidosMedicos->hora_coleta_exame}}</th>
                                    @endif

                                    <!-- <th>{{$status = ($pedidosMedicos->status == 0) ? "INATIVO"  : "ATIVO";}}</th> -->
                                    <th>
                                        @if($pedidosMedicos->etapa != 'Cancelado')
                                        <a href="" data-toggle="modal" data-target="#agendarColeta{{$pedidosMedicos->resultado_exame_id}}"><i class="fas fa-clock fa-lg" title="Agendar Coleta"></i></a>
                                        <a href="" data-toggle="modal" data-target="#cancelarColeta"><i class="fas fa-window-close fa-lg" title="Cancelar Agendamento"></i></a>
                                        @else
                                        <a href="" data-toggle="modal" data-target='#visualizarAgendamento{{$pedidosMedicos->resultado_exame_id}}'><i class="fas fa-eye fa-lg" title="Visualizar"></i></a>

                                        @endif
                                    </th>
                                </tr>

                                @endforeach



                            </tbody>

                        </table>

                        </form>


                        <!-- Modal Para Agendar Exame -->
                        @foreach($listaPedidoMedicos as $pedidosMedicos)

                        <div class="modal fade" id="agendarColeta{{$pedidosMedicos->resultado_exame_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Agendar Coleta</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">

                                                    <form class="form" action="agendamento/{{$pedidosMedicos->resultado_exame_id}}/update" method="post">

                                                        {{method_field('PUT')}}

                                                        <br>
                                                        <h8>Dados do Pedido</h8>
                                                        <hr>

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row">

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Data Pedido Médico:</label>
                                                                <input type="date" class="form-control" name="dataPedidoMedico" id="data_exame" value="{{$pedidosMedicos->data_pedido_exame}}" readonly>
                                                            </div>


                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Hora do Pedido Médico:</label>
                                                                <input type="text" class="form-control" name="horaPedidoMedico" id="hora_exame" value="{{$pedidosMedicos->hora_pedido_exame}}" readonly>
                                                            </div>


                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Médico:</label>
                                                                @foreach($listaUsuarios as $usuarios)
                                                                @if($pedidosMedicos->medico == $usuarios->id)
                                                                <input type="text" name="nomeMedicoPedido" id="nomePedidoMedico" class="form-control" value="{{$usuarios->nome}} {{$usuarios->sobrenome}}" readonly>
                                                                @endif
                                                                @endforeach
                                                            </div>


                                                        </div>

                                                        <div class="row">

                                                            <div class="col-sm-12">
                                                                <label class="control-label" style="position:relative; top:7px;">Exame:</label>
                                                                @foreach($listaExames as $exame)
                                                                @if($pedidosMedicos->exame_id == $exame->id)
                                                                <input type="text" class="form-control" name="exame" id="exame" value="{{$exame->descricao}}" readonly>
                                                                @endif
                                                                @endforeach
                                                            </div>

                                                        </div>

                                                        <br>
                                                        <h8>Agendamento</h8>
                                                        <hr>

                                                        <div class="row">

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Data Coleta:</label>
                                                                <input type="date" class="form-control" name="dataAgendamentoColeta" id="data_coleta" value="">
                                                                @if ($errors->has('dataAgendamentoColeta'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('dataAgendamentoColeta') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>


                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Hora Coleta:</label>
                                                                <input type="time" class="form-control" name="horaAgendamentoColeta" id="hora_coleta" value="">
                                                                @if ($errors->has('horaAgendamentoColeta'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('horaAgendamentoColeta') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Agendado Por:</label>
                                                                <input type="text" class="form-control" name="nomeFuncionario" id="nomeFuncionario" value="{{Auth::guard('usuarios')->user()->nome}} {{Auth::guard('usuarios')->user()->sobrenome}} " readonly>


                                                                </select>
                                                            </div>


                                                        </div>


                                                        <br>
                                                        <h8>Dados do Paciente</h8>
                                                        <hr>

                                                        <div class="row">

                                                            <div class="col-sm-12">
                                                                <label class="control-label" style="position:relative; top:7px;">Paciente:</label>
                                                                @foreach($listaUsuarios as $usuarios)
                                                                @if($pedidosMedicos->paciente_id == $usuarios->id)
                                                                <input type="text" class="form-control" name="paciente" id="paciente" value="{{$usuarios->nome}} {{$usuarios->sobrenome}}" readonly>
                                                                @endif
                                                                @endforeach
                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-sm-6">
                                                                <label class="control-label" style="position:relative; top:7px;">CPF:</label>
                                                                @foreach($listaUsuarios as $usuarios)
                                                                @if($pedidosMedicos->paciente_id == $usuarios->id)
                                                                <input type="text" class="form-control" name="cpf" id="cpf" value="{{$usuarios->cpf}}" readonly>
                                                                @endif
                                                                @endforeach
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <label class="control-label" style="position:relative; top:7px;">Data de Nascimento:</label>
                                                                @foreach($listaUsuarios as $usuarios)
                                                                @if($pedidosMedicos->paciente_id == $usuarios->id)
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

                        <!-- Modal Para Cancelar Agendamento -->
                        @foreach($listaPedidoMedicos as $pedidosMedicos)
                        <div class="modal fade" id="visualizarAgendamento{{$pedidosMedicos->resultado_exame_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Visualizar Agendamento</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form" action="agendamento/{{$pedidosMedicos->resultado_exame_id}}/show" method="get">

                                                        
                                                        <br>
                                                        <h8>Dados do Pedido</h8>
                                                        <hr>

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row">

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Data Pedido Médico:</label>
                                                                <input type="date" class="form-control" name="dataPedidoMedico" id="data_exame" value="{{$pedidosMedicos->data_pedido_exame}}" readonly>
                                                            </div>


                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Hora do Pedido Médico:</label>
                                                                <input type="time" class="form-control" name="horaPedidoMedico" id="hora_exame" value="{{$pedidosMedicos->hora_pedido_exame}}" readonly>
                                                            </div>


                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Médico:</label>
                                                                @foreach($listaUsuarios as $usuarios)
                                                                @if($pedidosMedicos->medico == $usuarios->id)
                                                                <input type="text" name="nomeMedicoPedido" id="nomePedidoMedico" class="form-control" value="{{$usuarios->nome}} {{$usuarios->sobrenome}}" readonly>
                                                                @endif
                                                                @endforeach
                                                            </div>


                                                        </div>

                                                        <div class="row">

                                                            <div class="col-sm-12">
                                                                <label class="control-label" style="position:relative; top:7px;">Exame:</label>
                                                                @foreach($listaExames as $exame)
                                                                @if($pedidosMedicos->exame_id == $exame->id)
                                                                <input type="text" class="form-control" name="exame" id="exame" value="{{$exame->descricao}}" readonly>
                                                                @endif
                                                                @endforeach
                                                            </div>

                                                        </div>

                                                        <br>
                                                        <h8>Cancelamento</h8>
                                                        <hr>

                                                        <div class="row">

                                                            <div class="col-sm-12">
                                                                <label class="control-label" style="position:relative; top:7px;">Motivo do Cancelamento:</label>
                                                                <textarea name="motivoCancelamento" id="motivoCancelamento" class="form-control" value="{{$pedidosMedicos->motivo_cancelamento}}" readonly></textarea>
                                                              
                                                            </div>


                                                        </div>

                                                        <br>
                                                        <h8>Agendamento</h8>
                                                        <hr>

                                                        <div class="row">

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Data Coleta:</label>
                                                                <input type="text" class="form-control" name="dataAgendamentoColeta" id="data_exame" value="{{ date( 'd/m/Y' , strtotime($pedidosMedicos->data_coleta_exame))}}" readonly>
                                                            </div>


                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Hora Coleta:</label>
                                                                <input type="text" class="form-control" name="horaAgendamentoColeta" id="hora_exame" value="{{$pedidosMedicos->hora_coleta_exame}}" readonly>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Agendado Por:</label>
                                                                <input type="text" class="form-control" name="nomeFuncionario" id="nomeFuncionario" value="{{$pedidosMedicos->atendente}}" readonly>

                                                            </div>


                                                        </div>




                                                        <br>
                                                        <h8>Dados do Paciente</h8>
                                                        <hr>

                                                        <div class="row">

                                                            <div class="col-sm-12">
                                                                <label class="control-label" style="position:relative; top:7px;">Paciente:</label>
                                                                @foreach($listaUsuarios as $usuarios)
                                                                @if($pedidosMedicos->paciente_id == $usuarios->id)
                                                                <input type="text" class="form-control" name="paciente" id="paciente" value="{{$usuarios->nome}} {{$usuarios->sobrenome}}" readonly>
                                                                @endif
                                                                @endforeach
                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-sm-6">
                                                                <label class="control-label" style="position:relative; top:7px;">CPF:</label>
                                                                @foreach($listaUsuarios as $usuarios)
                                                                @if($pedidosMedicos->paciente_id == $usuarios->id)
                                                                <input type="text" class="form-control" name="cpf" id="cpf" value="{{$usuarios->cpf}}" readonly>
                                                                @endif
                                                                @endforeach
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <label class="control-label" style="position:relative; top:7px;">Data de Nascimento:</label>
                                                                @foreach($listaUsuarios as $usuarios)
                                                                @if($pedidosMedicos->paciente_id == $usuarios->id)
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
                        @endforeach


                        <!-- Modal Para Cancelar Agendamento -->
                        @foreach($listaPedidoMedicos as $pedidosMedicos)
                        <div class="modal fade" id="cancelarColeta" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Cancelar Agendamento</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form" action="agendamento/{{$pedidosMedicos->resultado_exame_id}}/cancelamento" method="post">

                                                        {{method_field('PUT')}}

                                                        <br>
                                                        <h8>Dados do Pedido</h8>
                                                        <hr>

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row">

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Data Pedido Médico:</label>
                                                                <input type="date" class="form-control" name="dataPedidoMedico" id="data_exame" value="{{$pedidosMedicos->data_pedido_exame}}" readonly>
                                                            </div>


                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Hora do Pedido Médico:</label>
                                                                <input type="time" class="form-control" name="horaPedidoMedico" id="hora_exame" value="{{$pedidosMedicos->hora_pedido_exame}}" readonly>
                                                            </div>


                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Médico:</label>
                                                                @foreach($listaUsuarios as $usuarios)
                                                                @if($pedidosMedicos->medico == $usuarios->id)
                                                                <input type="text" name="nomeMedicoPedido" id="nomePedidoMedico" class="form-control" value="{{$usuarios->nome}} {{$usuarios->sobrenome}}" readonly>
                                                                @endif
                                                                @endforeach
                                                            </div>


                                                        </div>

                                                        <div class="row">

                                                            <div class="col-sm-12">
                                                                <label class="control-label" style="position:relative; top:7px;">Exame:</label>
                                                                @foreach($listaExames as $exame)
                                                                @if($pedidosMedicos->exame_id == $exame->id)
                                                                <input type="text" class="form-control" name="exame" id="exame" value="{{$exame->descricao}}" readonly>
                                                                @endif
                                                                @endforeach
                                                            </div>

                                                        </div>

                                                        <br>
                                                        <h8>Cancelamento</h8>
                                                        <hr>

                                                        <div class="row">

                                                            <div class="col-sm-12">
                                                                <label class="control-label" style="position:relative; top:7px;">Motivo do Cancelamento:</label>
                                                                <textarea name="motivoCancelamento" id="motivoCancelamento" class="form-control"></textarea>
                                                                @if ($errors->has('motivoCancelamento'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('motivoCancelamento') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>


                                                        </div>

                                                        <br>
                                                        <h8>Agendamento</h8>
                                                        <hr>

                                                        <div class="row">

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Data Coleta:</label>
                                                                <input type="text" class="form-control" name="dataAgendamentoColeta" id="data_exame" value="{{ date( 'd/m/Y' , strtotime($pedidosMedicos->data_coleta_exame))}}" readonly>
                                                            </div>


                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Hora Coleta:</label>
                                                                <input type="text" class="form-control" name="horaAgendamentoColeta" id="hora_exame" value="{{$pedidosMedicos->hora_coleta_exame}}" readonly>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Agendado Por:</label>
                                                                <input type="text" class="form-control" name="nomeFuncionario" id="nomeFuncionario" value="{{$pedidosMedicos->atendente}}" readonly>

                                                            </div>


                                                        </div>




                                                        <br>
                                                        <h8>Dados do Paciente</h8>
                                                        <hr>

                                                        <div class="row">

                                                            <div class="col-sm-12">
                                                                <label class="control-label" style="position:relative; top:7px;">Paciente:</label>
                                                                @foreach($listaUsuarios as $usuarios)
                                                                @if($pedidosMedicos->paciente_id == $usuarios->id)
                                                                <input type="text" class="form-control" name="paciente" id="paciente" value="{{$usuarios->nome}} {{$usuarios->sobrenome}}" readonly>
                                                                @endif
                                                                @endforeach
                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-sm-6">
                                                                <label class="control-label" style="position:relative; top:7px;">CPF:</label>
                                                                @foreach($listaUsuarios as $usuarios)
                                                                @if($pedidosMedicos->paciente_id == $usuarios->id)
                                                                <input type="text" class="form-control" name="cpf" id="cpf" value="{{$usuarios->cpf}}" readonly>
                                                                @endif
                                                                @endforeach
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <label class="control-label" style="position:relative; top:7px;">Data de Nascimento:</label>
                                                                @foreach($listaUsuarios as $usuarios)
                                                                @if($pedidosMedicos->paciente_id == $usuarios->id)
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
                                        <button type="submit" name="addCancelarAgendamento" id="addCancelarAgendamento" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Cancelar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach


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


@if (count($errors) > 0)
@if ($errors->has('motivoCancelamento') )
<script type="text/javascript">
    $('#cancelarColeta').modal('show');
</script>
@endif
@endif

@if (count($errors) > 0)
@if ($errors->has('dataAgendamentoColeta') || $errors->has('horaAgendamentoColeta'))
<script type="text/javascript">
    $('#agendarColeta{{$pedidosMedicos->resultado_exame_id}}').modal('show');
</script>
@endif
@endif


@endsection