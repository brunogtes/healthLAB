@extends('layouts.master')

@section('titulo')

<a class="navbar-brand">@canany(['funcionario', 'admin']) Cadastro Exames X Planos @else Acesso negado! @endcanany</a>

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

                            <form action="/cadastroExamesXPlanos/search" method="get">

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

                                <button type="button" href="#addExamePlano" class="btn btn-secondary" data-toggle="modal">Adicionar</button>
                                @csrf
                                @method('DELETE')
                                <button formaction="/ativarAllExameXPlano" type="submit" name="btnAtivarExamePlano" class="btn btn-secondary">Ativar</button>
                                <button formaction="/desativarAllExameXPlano" type="submit" name="btnDesativarExamePlano" class="btn btn-secondary">Desativar</button>


                        </div>

                    </div>


                    <div class="table-responsive">

                        <table class="table text-center">
                            <thead class=" text-primary">
                                <th scope="col"><input type="checkbox" class="selectall"></th>
                                <th scope="col">Exame</th>
                                <th scope="col">Convênio</th>
                                <th scope="col">Plano</th>
                                <th scope="col">Status</th>
                                <th scope="col">Opções</th>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($arracaoExamePlano as $arracaoExamePlanos)
                                    <td><input type="checkbox" name="ids[]" class="selectbox" value="{{ $arracaoExamePlanos->id}}"></td>

                                    @foreach($listaExames as $exames)
                                    @if($arracaoExamePlanos->exame_id == $exames->id)
                                    <th>{{$exames->descricao}}</th>
                                    @endif
                                    @endforeach



                                    @foreach($listaConvenios as $convenios)
                                    @if($arracaoExamePlanos->convenio_id == $convenios->id)
                                    <th>{{$convenios->nome_fantasia}}</th>
                                    @endif
                                    @endforeach

                                    @foreach($listaPlanos as $planos)
                                    @if($arracaoExamePlanos->plano_id == $planos->plano_id)
                                    <th>{{$planos->descricao}}</th>
                                    @endif
                                    @endforeach

                                    <th>{{$status = ($arracaoExamePlanos->status == 0) ? "INATIVO"  : "ATIVO";}}</th>
                                    <th>
                                        <a href="" data-toggle="modal" data-target="#editExameXPlano{{$arracaoExamePlanos->id}}"><i class="fas fa-edit fa-lg" title="Editar"></i></a>
                                        <a href="" data-toggle="modal" data-target='#visualizarExameXPlano{{$arracaoExamePlanos->id}}'><i class="fas fa-eye fa-lg" title="Visualizar"></i></a>
                                        <a href="" data-toggle="modal" data-target="#apagarExameXPlano{{$arracaoExamePlanos->id}}"><i class="fas fa-trash fa-lg" title="Apagar"></i></a>
                                    </th>
                                </tr>
                                @endforeach
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col"><input type="checkbox" class="selectall2" style="display:none"></th>

                                </tr>

                            </tfoot>

                        </table>

                        </form>


                        <!-- Modal Para Adicionar Exame X Plano -->

                        <div class="modal fade" id="addExamePlano" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Adicionar Exame X Plano</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">

                                                    <form class="form-horizontal" action="/cadastroExamesXPlanos/create" method="post">

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Convênio:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="convenio" id="convenio">
                                                                    <option value=""></option>

                                                                    @foreach($listaConvenios as $convenios)
                                                                    @if(old('convenio') == $convenios->id)
                                                                    <option value="{{old('convenio')}}" selected>{{$convenios->nome_fantasia}}</option>
                                                                    @endif
                                                                    @endforeach

                                                                    @foreach($listaConvenios as $convenios)
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
                                                                <label class="control-label" style="position:relative; top:7px;">Plano:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="plano" id="plano">
                                                                    <option value=""></option>

                                                                    @foreach($listaPlanos as $planos)
                                                                    @if(old('plano') == $planos->plano_id)
                                                                    <option value="{{old('plano')}}" selected>{{$planos->descricao}}</option>
                                                                    @endif
                                                                    @endforeach

                                                                    @foreach($listaPlanos as $planos)
                                                                    @if ($planos->status == '1')
                                                                    <option value="{{$planos->plano_id}}">{{$planos->descricao}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('plano'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('plano') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Exame:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="exame" id="exame">
                                                                    <option value=""></option>

                                                                    @foreach($listaExames as $exames)
                                                                    @if(old('exame') == $exames->id)
                                                                    <option value="{{old('exame')}}" selected>{{$exames->descricao}}</option>
                                                                    @endif
                                                                    @endforeach

                                                                    @foreach($listaExames as $exames)
                                                                    @if ($exames->status == '1')
                                                                    <option value="{{$exames->id}}">{{$exames->descricao}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('exame'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('exame') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Status:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="status" id="status">
                                                                    <option value=""></option>
                                                                    <option value="1" @if (old('status')=="1" ) {{ 'selected' }} @endif>ATIVO</option>
                                                                    <option value="0" @if (old('status')=="0" ) {{ 'selected' }} @endif>INATIVO</option>
                                                                </select>
                                                                @if ($errors->has('status'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('status') }}</strong>
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
                                        <button type="submit" name="addExamePlano" id="addExamePlano" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Cadastrar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- Modal Para Editar Exame X Plano -->

                        @foreach($arracaoExamePlano as $arracaoExamePlanos)
                        <div class="modal fade" id="editExameXPlano{{$arracaoExamePlanos->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Editar Exame X Plano</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroExamesXPlanos/{{$arracaoExamePlanos->id}}/update" method="post">

                                                        {{method_field('PUT')}}

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Convênio:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="convenio" id="convenio" required>

                                                                    @foreach($listaConvenios as $convenios)
                                                                    @if($arracaoExamePlanos->convenio_id == $convenios->id)
                                                                    <option value="{{$convenios->id}}" selected>{{$convenios->nome_fantasia}}</option>
                                                                    @endif
                                                                    @endforeach

                                                                    @foreach($listaConvenios as $convenios)
                                                                    @if ($convenios->status == '1')
                                                                    <option value="{{$convenios->id}}">{{$convenios->nome_fantasia}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Plano:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="plano" id="plano" required>

                                                                    @foreach($listaPlanos as $planos)
                                                                    @if($arracaoExamePlanos->plano_id == $planos->plano_id)
                                                                    <option value="{{$planos->plano_id}}">{{$planos->descricao}}</option>
                                                                    @endif
                                                                    @endforeach

                                                                    @foreach($listaPlanos as $planos)
                                                                    @if ($planos->status == '1')
                                                                    <option value="{{$planos->plano_id}}">{{$planos->descricao}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Exame:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="exame" id="exame" required>
                                                                    @foreach($listaExames as $exames)
                                                                    @if($arracaoExamePlanos->exame_id == $exames->id)
                                                                    <option value="{{$exames->id}}">{{$exames->descricao}}</option>
                                                                    @endif
                                                                    @endforeach

                                                                    @foreach($listaExames as $exames)
                                                                    @if ($exames->status == '1')
                                                                    <option value="{{$exames->id}}">{{$exames->descricao}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Status:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="status" id="status" required>
                                                                    <option value="1" @if ($arracaoExamePlanos->status =="1" ) {{ 'selected' }} @endif>ATIVO</option>
                                                                    <option value="0" @if ($arracaoExamePlanos->status=="0" ) {{ 'selected' }} @endif>INATIVO</option>
                                                                </select>

                                                            </div>
                                                        </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                        <button type="submit" name="editExamePlano" id="editExamePlano" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Atualizar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Modal Para Visualizar Exame X Plano -->

                        @foreach($arracaoExamePlano as $arracaoExamePlanos)
                        <div class="modal fade" id="visualizarExameXPlano{{$arracaoExamePlanos->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Visualizar Item de Exame</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroExamesXPlanos/show" method="get">

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Convênio:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="convenio" id="convenio" readonly>
                                                                    @foreach($listaConvenios as $convenios)
                                                                    @if($arracaoExamePlanos->convenio_id == $convenios->id)
                                                                    <th>{{$convenios->nome_fantasia}}</th>
                                                                    <option value="{{$convenios->id}}">{{$convenios->nome_fantasia}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Plano:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="plano" id="plano" readonly>
                                                                    @foreach($listaPlanos as $planos)
                                                                    @if($arracaoExamePlanos->plano_id == $planos->plano_id)
                                                                    <option value="{{$planos->plano_id}}">{{$planos->descricao}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Exame:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="exame" id="exame" readonly>
                                                                    @foreach($listaExames as $exames)
                                                                    @if($arracaoExamePlanos->exame_id == $exames->id)
                                                                    <option value="{{$exames->id}}">{{$exames->descricao}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Status:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="status" id="status" readonly>
                                                                    @foreach($arracaoExamePlano as $arracaoExamePlanos)
                                                                    <option value="{{$arracaoExamePlanos->status}}">{{$status = ($arracaoExamePlanos->status == 0) ? "INATIVO"  : "ATIVO";}}</option>
                                                                    @endforeach
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

                        <!-- Modal Para Apagar Exame X Plano -->

                        @foreach($arracaoExamePlano as $arracaoExamePlanos)
                        <div class="modal fade" id="apagarExameXPlano{{$arracaoExamePlanos->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Desativar Exame X Plano</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroExamesXPlanos/{{$arracaoExamePlanos->id}}/delete" method="post">

                                                        @method('DELETE')

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        @foreach($listaExames as $exames)

                                                        @if($arracaoExamePlanos->exame_id == $exames->id)

                                                        <p class="text-center">Tem certeza de que deseja desativar o {{$exames->descricao}} X {{$planos->descricao}}?</p>
                                                        @endif
                                                        @endforeach






                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                        <button type="submit" name="desativarExamePlano" id="desativarExamePlano" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Confirmar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach

                        @if ($arracaoExamePlano->lastPage() > 1)
                        <ul class="pagination justify-content-end">
                            <li class=" {{ ($arracaoExamePlano->currentPage() == 1) ? ' page-item disabled' : '' }}">
                                <a class="page-link" href="{{ $arracaoExamePlano->url(1) }}">Anterior</a>
                            </li>
                            @for ($i = 1; $i <= $arracaoExamePlano->lastPage(); $i++)
                                <li class="{{ ($arracaoExamePlano->currentPage() == $i) ? ' page-item active' : '' }}">
                                    <a class="page-link" href="{{ $arracaoExamePlano->url($i) }}">{{ $i }}</a>
                                </li>
                                @endfor
                                <li class="{{ ($arracaoExamePlano->currentPage() == $arracaoExamePlano->lastPage()) ? '  page-item disabled' : '' }}">
                                    <a class="page-link" href="{{ $arracaoExamePlano->url($arracaoExamePlano->currentPage()+1) }}">Proximo</a>
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
@if ($errors->has('convenio') || $errors->has('plano') || $errors->has('exame') || $errors->has('status'))
<script type="text/javascript">
    $('#addExamePlano').modal('show');
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