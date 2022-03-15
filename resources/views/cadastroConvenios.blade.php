@extends('layouts.master')

@section('titulo')

<a class="navbar-brand">@canany(['funcionario', 'admin']) Cadastro Convênios @else Acesso negado! @endcanany</a>

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

                    @if ($message = Session::get('msg'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    @endif

                    @if ($errors->has('ids'))
                    <script>
                        $.confirm({                            
                            title: 'Atenção!',
                            content: 'É necessário selecionar um ou mais itens',
                            type: 'red',
                            typeAnimated: true,
                            buttons: {                             
                                Fechar: function() {}
                            }
                        });
                    </script>


                    @endif

                    <div class="row">
                        <div class="col-md-8"></div>

                        <div class="col-md-4">

                            <form action="/cadastroConvenios/search" method="get">

                                <div class="input-group">
                                    <input class="form-control" type="search" name="search" placeholder="Pesquisar" aria-label="Search" style="border-right: none;">
                                    <div class="input-group-append">
                                        <div class="input-group-text" style="background-color: #FFF"><i class="fas fa-search"></i></div>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <form method="POST">

                                <button type="button" href="#addConvenio" class="btn btn-secondary" data-toggle="modal">Adicionar</button>

                                @csrf
                                @method('DELETE')
                                <button formaction="/ativarAll" type="submit" name="btnAtivarConvenio" class="btn btn-secondary">Ativar Convênio</button>
                                <button formaction="/desativarAll" type="submit" name="btnDesativarConvenio" class="btn btn-secondary">Desativar Convênio</button>


                        </div>

                    </div>

                    <div class="table-responsive">

                        <table class="table text-center">
                            <thead class=" text-primary">
                                <th scope="col"><input type="checkbox" class="selectall"></th>
                                <th scope="col">Nome</th>
                                <th scope="col">CNPJ</th>
                                <th scope="col">Situação</th>
                                <th scope="col">Opções</th>
                            </thead>
                            <tbody>
                                @foreach($convenio as $convenios)

                                <tr>
                                    <td><input type="checkbox" name="ids[]" class="selectbox" value="{{ $convenios->id}}"></td>
                                    <th>{{$convenios->nome_fantasia}}</th>
                                    <th>{{$convenios->cnpj}}</th>
                                    <th>{{$status = ($convenios->status == 0) ? "INATIVO"  : "ATIVO";}}</th>
                                    <th>
                                        <a href="" data-toggle="modal" data-target="#editConvenio{{$convenios->id}}"><i class="fas fa-edit fa-lg" title="Editar"></i></a>
                                        <a href="" data-toggle="modal" data-target='#visualizarConvenio{{$convenios->id}}'><i class="fas fa-eye fa-lg" title="Visualizar"></i></a>
                                        <a href="" data-toggle="modal" data-target="#apagarConvenio{{$convenios->id}}"><i class="fas fa-trash fa-lg" title="Apagar"></i></a>
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

                        @foreach($convenio as $convenios)
                        <!-- Modal Para Adicionar Novo Convênio -->

                        <div wire:ignore.self class="modal fade" id="addConvenio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Cadastrar Convênio</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">

                                                    <form class="form-horizontal" action="cadastroConvenios/create" method="post">

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Razão Social:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="razao_social" id="razao_social" value="{{old('razao_social')}}">
                                                                @if ($errors->has('razao_social'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('razao_social') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Nome Fantasia:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="nome_fantasia" id="nome_fantasia" value="{{old('nome_fantasia')}}">
                                                                @if ($errors->has('nome_fantasia'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('nome_fantasia') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">CNPJ:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="cnpj" id="cnpj" mask="00.000.000/0000-00" value="{{old('cnpj')}}">
                                                                @if ($errors->has('cnpj'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('cnpj') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Situação:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="situacao" id="situacao">
                                                                    <option value=""></option>
                                                                    <option value="1" @if (old('situacao')=="1" ) {{ 'selected' }} @endif>ATIVO</option>
                                                                    <option value="0" @if (old('situacao')=="0" ) {{ 'selected' }} @endif>INATIVO</option>
                                                                </select>
                                                                @if ($errors->has('situacao'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('situacao') }}</strong>
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
                                        <button type="submit" name="addConvenio" id="addConvenio" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Cadastrar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        @endforeach

                        @foreach($convenio as $convenios)
                        <!-- Modal Para Editar Convênio -->

                        <div class="modal fade" id="editConvenio{{$convenios->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Visualizar Convênio</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">

                                                    @if (count($errors) > 0)
                                                    <div id="msgValidacaoEditar" class="alert alert-danger">
                                                        <ul> @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif
                                                    <form id="editConvenioForm" class="form-horizontal" action="cadastroConvenios/{{$convenios->id}}/update" method="post">

                                                        {{method_field('PUT')}}

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Razão Social:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="razao_social" id="razao_social" value="{{$convenios->razao_social}}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Nome Fantasia:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="nome_fantasia" id="nome_fantasia" value="{{$convenios->nome_fantasia}}" required>
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">CNPJ:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="cnpj" id="cnpj" mask="00.000.000/0000-00" value="{{$convenios->cnpj}}" required>
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Situação:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="situacao" id="situacao" required>
                                                                    <option value="{{$convenios->status}}">{{$situacao = ($convenios->status == 0) ? "INATIVO"  : "ATIVO";}}</option>
                                                                    <option value="1" @if ($convenios->status =="1" ) {{ 'selected' }} @endif>ATIVO</option>
                                                                    <option value="0" @if ($convenios->status=="0" ) {{ 'selected' }} @endif>INATIVO</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                        <button type="submit" name="editConvenio" id="editConvenio" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Atualizar</a>


                                    </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                        @endforeach

                        @foreach($convenio as $convenios)
                        <!-- Modal Para Visualizar Convênio -->

                        <div wire:ignore.self class="modal fade" id="visualizarConvenio{{$convenios->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Visualizar Convênio</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroConvenios/{{$convenios->id}}/show" method="post">
                                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Razão Social:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="razao_social" id="razao_social" value="{{$convenios->razao_social}}" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Nome Fantasia:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="nome_fantasia" id="nome_fantasia" value="{{$convenios->nome_fantasia}}" readonly>
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">CNPJ:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="cnpj" id="cnpj" mask="00.000.000/0000-00" value="{{$convenios->cnpj}}" readonly>
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Situação:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="situacao" id="situacao" readonly>
                                                                    <option value="{{$convenios->status}}">{{$situacao = ($convenios->status == 1) ? "ATIVO"  : "INATIVO";}}</option>
                                                                    <option value="1" @if ($convenios->status =="1" ) {{ 'selected' }} @endif>ATIVO</option>
                                                                    <option value="0" @if ($convenios->status=="0" ) {{ 'selected' }} @endif>INATIVO</option>
                                                                </select>
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

                        @foreach($convenio as $convenios)
                        <!-- Modal Para Desativar um Convênio -->

                        <div wire:ignore.self class="modal fade" id="apagarConvenio{{$convenios->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Desativar um Convênio</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <form class="form-horizontal" action="cadastroConvenios/{{$convenios->id}}/delete" method="post">

                                            @method('DELETE')

                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <p class="text-center">Tem certeza de que deseja desativar o convenio {{$convenios->nome_fantasia}} ?</p>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>Fechar</button>
                                        <button type="submit" name="apagarConvenio" id="apagarConvenio" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Confirmar</a>
                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>


                        @endforeach


                        @if ($convenio->lastPage() > 1)
                        <ul class="pagination justify-content-end">
                            <li class=" {{ ($convenio->currentPage() == 1) ? ' page-item disabled' : '' }}">
                                <a class="page-link" href="{{ $convenio->url(1) }}">Anterior</a>
                            </li>
                            @for ($i = 1; $i <= $convenio->lastPage(); $i++)
                                <li class="{{ ($convenio->currentPage() == $i) ? ' page-item active' : '' }}">
                                    <a class="page-link" href="{{ $convenio->url($i) }}">{{ $i }}</a>
                                </li>
                                @endfor
                                <li class="{{ ($convenio->currentPage() == $convenio->lastPage()) ? '  page-item disabled' : '' }}">
                                    <a class="page-link" href="{{ $convenio->url($convenio->currentPage()+1) }}">Proximo</a>
                                </li>
                        </ul>
                        @endif

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
@if ($errors->has('razao_social') || $errors->has('nome_fantasia') || $errors->has('cnpj') || $errors->has('situacao') )
<script type="text/javascript">
    $('#addConvenio').modal('show');
</script>
@endif

@endif




<script type="text/javascript">
    $('.selectall').click(function() {
        $('.selectbox').prop('checked', $(this).prop('checked'));
        $('.selectall2').prop('checked', $(this).prop('checked'));
    })
    $('.selectall2').click(function() {
        $('.selectbox').prop('checked', $(this).prop('checked'));
        $('.selectall').prop('checked', $(this).prop('checked'));
    })
    $('.selectbox').change(function() {
        var total = $('.selectbox').length;
        var number = $('.selectbox:checked').length;
        if (total == number) {
            $('.selectall').prop('checked', true);
            $('.selectall2').prop('checked', true);
        } else {
            $('.selectall').prop('checked', false);
            $('.selectall2').prop('checked', false);
        }
    })
</script>



@endsection