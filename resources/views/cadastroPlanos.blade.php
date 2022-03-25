@extends('layouts.master')

@section('titulo')

<a class="navbar-brand">@canany(['funcionario', 'admin']) Cadastro Planos @else Acesso negado! @endcanany</a>

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

                    <div class="row">
                        <div class="col-md-8"></div>

                        <div class="col-md-4">

                            <form action="/cadastroPlanos/search" method="get">

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

                                <button type="button" href="#addPlano" class="btn btn-secondary" data-toggle="modal">Adicionar</button>
                                @csrf
                                @method('DELETE')
                                <button formaction="/ativarAllPlanos" type="submit" name="btnAtivarPlano" class="btn btn-secondary">Ativar Plano</button>
                                <button formaction="/desativarAllPlanos" type="submit" name="btnDesativarPlano" class="btn btn-secondary">Desativar Plano</button>


                        </div>

                    </div>


                    <div class="table-responsive">

                        <table class="table text-center">
                            <thead class=" text-primary">
                                <th scope="col"><input type="checkbox" class="selectall"></th>
                                <th scope="col">Plano</th>
                                <th scope="col">Status</th>
                                <th scope="col">Opções</th>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($plano as $planos)

                                    <td><input type="checkbox" name="ids[]" class="selectbox" value="{{ $planos->plano_id}}"></td>
                                    <th>{{$planos->descricao}}</th>
                                    <th>{{$status = ($planos->status == 0) ? "INATIVO"  : "ATIVO";}}</th>
                                    <th>
                                        <a href="" data-toggle="modal" data-target="#editPlano{{$planos->plano_id}}"><i class="fas fa-edit fa-lg" title="Editar"></i></a>
                                        <a href="" data-toggle="modal" data-target='#visualizarPlano{{$planos->plano_id}}'><i class="fas fa-eye fa-lg" title="Visualizar"></i></a>
                                        <a href="" data-toggle="modal" data-target="#apagarPlano{{$planos->plano_id}}"><i class="fas fa-trash fa-lg" title="Apagar"></i></a>
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


                        <!-- Modal Para Adicionar Plano -->

                        <div class="modal fade" id="addPlano" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Adicionar Plano</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">

                                                    <form class="form-horizontal" action="cadastroPlanos/create" method="post">


                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Convênio:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">

                                                                <select class="form-control" name="convenio" id="convenio">
                                                                    <option value=""></option>
                                                                    @foreach($convenio as $convenios)
                                                                    @if(old('convenio') == $convenios->id)
                                                                    <option value="{{old('convenio')}}" selected>{{$convenios->nome_fantasia}}</option>
                                                                    @endif
                                                                    @endforeach


                                                                    @foreach($convenio as $convenios)
                                                                    @if ($convenios->status == '1')
                                                                    <option value="{{$convenios->id}}">{{$convenios->nome_fantasia}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('convenio'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('convenio') }}</strong>
                                                                </span>
                                                                @endif

                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Descrição:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="descricao" id="descricao" value="{{old('descricao')}}">
                                                                @if ($errors->has('descricao'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('descricao') }}</strong>
                                                                </span>
                                                                @endif

                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Status:<span style="color: red">*</span></label>
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
                                        <button type="submit" name="addPlano" id="addPlano" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Cadastrar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Modal Para Editar Plano -->
                        @foreach($plano as $planos)
                        <div class="modal fade" id="editPlano{{$planos->plano_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Editar Plano</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">

                                                    <form class="form-horizontal" action="cadastroPlanos/{{$planos->plano_id}}/update" method="post">

                                                        {{method_field('PUT')}}

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Convênio:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="convenio" id="convenio" required>
                                                                    @foreach($convenio as $convenios)
                                                                    @if ($convenios->id == $planos->convenio_id)
                                                                    <option value="{{$convenios->id}}">{{$convenios->nome_fantasia}}</option>
                                                                    @endif
                                                                    @endforeach

                                                                    @foreach($convenio as $convenios)
                                                                    @if ($convenios->status == '1')
                                                                    <option value="{{$convenios->id}}">{{$convenios->nome_fantasia}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Descrição:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="descricao" id="descricao" value="{{$planos->descricao}}" required>
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Status:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="status" id="status" required>
                                                                    <option value=""></option>
                                                                    <option value="1" @if ($planos->status =="1" ) {{ 'selected' }} @endif>ATIVO</option>
                                                                    <option value="0" @if ($planos->status=="0" ) {{ 'selected' }} @endif>INATIVO</option>
                                                                </select>

                                                            </div>
                                                        </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                        <button type="submit" name="btneditPlano" id="btneditPlano" class="btn btn-success" onclick="validar()"><span class="glyphicon glyphicon-check"></span>Atualizar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Modal Para Visualizar Plano -->
                        @foreach($plano as $planos)
                        <div class="modal fade" id="visualizarPlano{{$planos->plano_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Visualizar Plano</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="/cadastroPlanos/{{$planos->plano_id}}/show" method="post">

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Convênio:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="convenio" id="convenio" readonly>
                                                                    @foreach($convenio as $convenios)
                                                                    @if ($convenios->id == $planos->convenio_id)
                                                                    <option value="{{$convenios->id}}">{{$convenios->nome_fantasia}}</option>
                                                                    @endif
                                                                    @endforeach


                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Descrição:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="descricao" id="descricao" value="{{$planos->descricao}}" readonly>
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Status:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="status" id="status" readonly>
                                                                    <option value="{{$planos->status}}">{{$status = ($planos->status == 0) ? "INATIVO"  : "ATIVO";}}</option>
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

                        <!-- Modal Para Apagar Plano -->
                        @foreach($plano as $planos)
                        <div class="modal fade" id="apagarPlano{{$planos->plano_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Desativar Plano</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroPlanos/{{$planos->plano_id}}/delete" method="post">

                                                        {{method_field('PUT')}}

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">


                                                        <p class="text-center">Tem certeza de que deseja desativar o plano {{$planos->descricao}} ?</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                        <button type="submit" name="apagarPlano" id="apagarPlano" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Confirmar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>


                        @endforeach

                        @if ($plano->lastPage() > 1)
                        <ul class="pagination justify-content-end">
                            <li class=" {{ ($plano->currentPage() == 1) ? ' page-item disabled' : '' }}">
                                <a class="page-link" href="{{ $plano->url(1) }}">Anterior</a>
                            </li>
                            @for ($i = 1; $i <= $plano->lastPage(); $i++)
                                <li class="{{ ($plano->currentPage() == $i) ? ' page-item active' : '' }}">
                                    <a class="page-link" href="{{ $plano->url($i) }}">{{ $i }}</a>
                                </li>
                                @endfor
                                <li class="{{ ($plano->currentPage() == $plano->lastPage()) ? '  page-item disabled' : '' }}">
                                    <a class="page-link" href="{{ $plano->url($plano->currentPage()+1) }}">Proximo</a>
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

@if(count($errors) > 0 )
@if ($errors->has('convenio') || $errors->has('descricao') || $errors->has('situacao') )
<script type="text/javascript">
    $('#addPlano').modal('show');
</script>
@endif
@endif

<style>
    label.error {
        color: #dc3545;
        font-size: 14px;
    }
</style>


@endsection