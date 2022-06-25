@extends('layouts.master')

@section('titulo')

<a class="navbar-brand">@canany(['medico', 'admin'])  Painel Médico @else Acesso negado! @endcanany </a>

@endsection

@section('panel-header')

<div class="panel-header panel-header-sm">
</div>

@endsection

@section('content')
<div class="content">

@canany(['medico', 'admin'])  

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">

                            <!-- <select class="form-control" name="filtro_pedidos" id="filtro_pedidos">
                                <option value="">Filtrar</option>
                                <option value="Aguardando Agendamento">Aguardando Agendamento</option>
                                <option value="Aguardando Coleta">Aguardando Coleta</option>
                                <option value="Aguardando Resultado">Aguardando Resultado</option>
                                <option value="Finalizado">Finalizado</option>
                                <option value="Cancelado">Cancelados</option>
                            </select> -->

                        </div>

                        <!-- <div class="col-md-4">

                            <form action="/painelMedico/search" method="get">

                                <div class="input-group">
                                    <input class="form-control" type="search" name="search" placeholder="Pesquisar" aria-label="Search" style="border-right: none;">
                                    <div class="input-group-append">
                                        <div class="input-group-text" style="background-color: #FFF"><i class="fas fa-search"></i></div>
                                    </div>
                                </div>

                            </form>
                        </div> -->

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <form method="POST">

                                <button type="button" href="#addPedidoMedico" class="btn btn-secondary" data-toggle="modal">Adicionar</button>

                        </div>


                    </div>


                    <div class="table-responsive">

                        <table class="table text-center">
                            <thead class=" text-primary">                                
                                <th scope="col">Paciente</th>
                                <th scope="col">Exame</th>
                                <th scope="col">Etapa</th>
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


                                    <!-- <th>{{$status = ($pedidosMedicos->status == 0) ? "INATIVO"  : "ATIVO";}}</th> -->
                                    <th>
                                        <a href="" data-toggle="modal" data-target='#visualizarPedidoMedico{{ $pedidosMedicos->resultado_exame_id}}'><i class="fas fa-eye fa-lg" title="Visualizar"></i></a>
                                        <!-- <a href="" data-toggle="modal" data-target="#apagarPedidoMedico{{ $pedidosMedicos->resultado_exame_id}}"><i class="fas fa-trash fa-lg" title="Cancelar Exame"></i></a> -->
                                    </th>
                                </tr>

                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col"><input type="checkbox" class="selectall2" style="display:none"></th>

                                </tr>

                            </tfoot>

                        </table>

                        </form>


                        <!-- Modal Para Adicionar Pedido Médico-->

                        <div class="modal fade" id="addPedidoMedico" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Cadastrar Pedido Médico</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form" action="painelMedico/create" method="post">

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row">

                                                            <div class="col-sm-12">
                                                                <label class="control-label" style="position:relative; top:7px;">Paciente:</label>
                                                                <select class="form-control" name="lista_paciente" id="lista_paciente">
                                                                    <option value="" selected></option>

                                                                    @foreach($listaUsuarios as $usuarios)

                                                                    <option value="{{$usuarios->id}}">{{$usuarios->nome}} {{$usuarios->sobrenome}}</option>

                                                                    @endforeach


                                                                </select>
                                                                @if ($errors->has('lista_paciente'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('lista_paciente') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-sm-6">
                                                                <label class="control-label" style="position:relative; top:7px;">CPF:</label>
                                                                <input type="text" class="form-control" name="cpf" id="cpf" value="" readonly>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <label class="control-label" style="position:relative; top:7px;">Data de Nascimento:</label>
                                                                <input type="text" class="form-control" name="data_nascimento" id="data_nascimento" value="" readonly>
                                                            </div>

                                                        </div>


                                                        <input type="hidden" class="form-control" name="convenio" id="convenio" value="">
                                                        <input type="hidden" class="form-control" name="plano" id="plano" value="">
                                                        <input type="hidden" class="form-control" name="medico" id="medico" value="{{Auth::guard('usuarios')->user()->id}}">


                                                        <div class="row">

                                                            <div class="col-sm-12">
                                                                <label class="control-label" style="position:relative; top:7px;">Exame:</label>
                                                                <select class="form-control" name="exame" id="exame" value="">
                                                                    <option value=""></option>
                                                                    @foreach($listaExames as $exames)

                                                                    <option value="{{$exames->id}}">{{$exames->descricao}}</option>

                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('exame'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('exame') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>

                                                        </div>



                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                        <button type="submit" name="addPedidoMedico" id="addResulExames" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Cadastrar</a>


                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- Modal Para Visualizar Especialidade X Medico -->
                        @foreach($listaPedidoMedicos as $pedidosMedicos)
                        <div class="modal fade" id="visualizarPedidoMedico{{$pedidosMedicos->resultado_exame_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Visualizar Pedido Médico</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form" action="painelMedico/{$pedidosMedicos->resultado_exame_id}/show" method="get">

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <br>
                                                        <h8>Histórico do Exame</h8>
                                                        <hr>

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row">

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Data Pedido Médico:</label>
                                                                <input type="date" class="form-control" name="dataPedidoMedico" id="data_exame" value="{{$pedidosMedicos->data_pedido_exame}}" readonly>
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
                                                                <input type="text" class="form-control" name="horaPedidoMedico" id="hora_exame" value="{{$pedidosMedicos->hora_pedido_exame}}" readonly>

                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Hora Coleta:</label>
                                                                <input type="text" class="form-control" name="horaAgendamentoColeta" id="hora_exame" value="" readonly>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Hora Resultado:</label>
                                                                <input type="text" class="form-control" name="horaResultado" id="hora_exame" value="" readonly>
                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Médico:</label>
                                                                @foreach($listaUsuarios as $usuarios)
                                                                @if($pedidosMedicos->medico == $usuarios->id)
                                                                <input type="text" name="nomeMedicoPedido" id="nomePedidoMedico" class="form-control" value="{{$usuarios->nome}} {{$usuarios->sobrenome}}" readonly>
                                                                @endif
                                                                @endforeach
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Bioquimico Coleta:</label>
                                                                <input type="text" class="form-control" name="bioquimicoColeta" id="bioquimicoColeta" readonly>

                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label class="control-label" style="position:relative; top:7px;">Bioquimico Resultado:</label>
                                                                <input type="text" class="form-control" name="bioquimicoResultado" id="bioquimicoResultado" readonly>

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
                                                                <input type="text" class="form-control" name="data_nascimento" id="cpdata_nascimento" value="{{$usuarios->data_nascimento}}" readonly>
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


                        <!-- Modal Para Apagar Pedido Médico -->
                        @foreach($listaPedidoMedicos as $pedidosMedicos)

                        <div class="modal fade" id="apagarPedidoMedico{{ $pedidosMedicos->resultado_exame_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Cancelar Pedido Médico</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroPlanos/create" method="get">


                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">


                                                        <p class="text-center">Tem certeza de que deseja cancelar o Pedido Médico?</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                        <button type="submit" name="desativarPedidoMedico" id="desativarPedidoMedico" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Confirmar</a>

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
@if ($errors->has('lista_paciente') || $errors->has('exame') )
<script type="text/javascript">
  $('#addPedidoMedico').modal('show');
</script>
@endif
@endif



@endsection