@extends('layouts.master')

@section('titulo')

<a class="navbar-brand">@canany(['funcionario', 'admin'])Cadastro Especialidades X Médicos @else Acesso negado! @endcanany</a>

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

                    <!-- <div class="row">
                        <div class="col-md-8"></div>

                        <div class="col-md-4">

                            <form action="/cadastroEspecialidadesXMedicos/search" method="get">

                                <div class="input-group">
                                    <input class="form-control" type="search" name="search" placeholder="Pesquisar" aria-label="Search" style="border-right: none;">
                                    <div class="input-group-append">
                                        <div class="input-group-text" style="background-color: #FFF"><i class="fas fa-search"></i></div>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div> -->

                    <div class="row">

                        <div class="col-md-6">

                            <form method="POST">

                                <button type="button" href="#addEspecialidadeXMedico" class="btn btn-secondary" data-toggle="modal">Adicionar</button>
                                @csrf
                                @method('DELETE')
                                <button formaction="/ativarAllEspecialidadesMedicos" type="submit" name="btnAtivarEspecialidadeXMedico" class="btn btn-secondary">Ativar</button>
                                <button formaction="/desativarAllEspecialidadesMedicos" type="submit" name="btnDesativarEspecialidadeXMedico" class="btn btn-secondary">Desativar</button>


                        </div>

                    </div>


                    <div class="table-responsive">

                        <table class="table text-center">
                            <thead class=" text-primary">
                                <th scope="col"><input type="checkbox" class="selectall"></th>
                                <th scope="col">Médico</th>
                                <th scope="col">Especialidade</th>
                                <th scope="col">Status</th>
                                <th scope="col">Opções</th>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($arracaoEspMedico as $arracaoEspMedicos)
                                    <td><input type="checkbox" name="ids[]" class="selectbox" value="{{ $arracaoEspMedicos->id}}"></td>

                                    @foreach($listaUsuarios as $usuarios)
                                    @if($arracaoEspMedicos->medico_id == $usuarios->id)
                                    <th>{{$usuarios->nome}} {{$usuarios->sobrenome}}</th>
                                    @endif
                                    @endforeach

                                    @foreach($especialidade as $especialidades)
                                    @if($arracaoEspMedicos->especialidade_id == $especialidades->id)
                                    <th>{{$especialidades->descricao}}</th>
                                    @endif
                                    @endforeach

                                    <th>{{$status = ($arracaoEspMedicos->status == 0) ? "INATIVO"  : "ATIVO";}}</th>
                                    <th>
                                        <a href="" data-toggle="modal" data-target="#editEspXMedico{{$arracaoEspMedicos->id}}"><i class="fas fa-edit fa-lg" title="Editar"></i></a>
                                        <a href="" data-toggle="modal" data-target='#visualizarEspXMedico{{$arracaoEspMedicos->id}}'><i class="fas fa-eye fa-lg" title="Visualizar"></i></a>
                                        <a href="" data-toggle="modal" data-target="#apagarEspXMedico{{$arracaoEspMedicos->id}}"><i class="fas fa-trash fa-lg" title="Apagar"></i></a>
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


                        <!-- Modal Para Adicionar Especialidade X Medico-->

                        <div class="modal fade" id="addEspecialidadeXMedico" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Adicionar Especialidade X Médico</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroEspecialidadesXMedicos/create" method="post">

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Médico:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="medico" id="medico">
                                                                    <option value=""></option>

                                                                    @foreach($listaUsuarios as $usuarios)
                                                                    <option value="{{$usuarios->id}}">{{$usuarios->nome}} {{$usuarios->sobrenome}}</option>
                                                                    @endforeach
                                                                </select>

                                                                @if ($errors->has('medico'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('medico') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Especialidade:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="especialidade" id="especialidade">
                                                                    <option value=""></option>
                                                                    @foreach($especialidade as $especialidades)
                                                                    @if ($especialidades->status == '1')
                                                                    <option value="{{$especialidades->id}}">{{$especialidades->descricao}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('especialidade'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('especialidade') }}</strong>
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
                                                                    <option value="1">ATIVO</option>
                                                                    <option value="0">INATIVO</option>
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
                                        <button type="submit" name="addEspecialidadeXMedico" id="addEspecialidadeXMedico" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Cadastrar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- Modal Para Editar Especialidade X Medico -->

                        @foreach($arracaoEspMedico as $arracaoEspMedicos)
                        <div class="modal fade" id="editEspXMedico{{$arracaoEspMedicos->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Editar Especialidade X Médico</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroEspecialidadesXMedicos/{{$arracaoEspMedicos->id}}/update" method="post">

                                                        {{method_field('PUT')}}

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Médico:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="medico" id="medico" required>
                                                                    @foreach($listaUsuarios as $usuarios)
                                                                    @if($arracaoEspMedicos->medico_id == $usuarios->id)
                                                                    <option value="{{$usuarios->id}}">{{$usuarios->nome}} {{$usuarios->sobrenome}}</option>
                                                                    @endif
                                                                    @endforeach

                                                                    @foreach($listaUsuarios as $usuarios)
                                                                    <option value="{{$usuarios->id}}">{{$usuarios->nome}} {{$usuarios->sobrenome}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Especialidade:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="especialidade" id="especialidade" required>
                                                                    @foreach($especialidade as $especialidades)
                                                                    @if($arracaoEspMedicos->especialidade_id == $especialidades->id)
                                                                    <option value="{{$especialidades->id}}">{{$especialidades->descricao}}</option>
                                                                    @endif
                                                                    @endforeach

                                                                    @foreach($especialidade as $especialidades)
                                                                    @if ($especialidades->status == '1')
                                                                    <option value="{{$especialidades->id}}">{{$especialidades->descricao}}</option>
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
                                                                    <option value="{{$arracaoEspMedicos->status}}">{{$status = ($arracaoEspMedicos->status == 0) ? "INATIVO"  : "ATIVO";}}</option>
                                                                    <option value="1">ATIVO</option>
                                                                    <option value="0">INATIVO</option>
                                                                </select>

                                                            </div>
                                                        </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                        <button type="submit" name="editEspecialidadeXMedico" id="editEspecialidadeXMedico" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Atualizar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Modal Para Visualizar Especialidade X Medico -->

                        @foreach($arracaoEspMedico as $arracaoEspMedicos)
                        <div class="modal fade" id="visualizarEspXMedico{{$arracaoEspMedicos->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Visualizar Especialidade X Médico</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroEspecialidadesXMedicos/{{$arracaoEspMedicos->id}}/show" method="get">


                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Médico:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="medico" id="medico" readonly>
                                                                    @foreach($listaUsuarios as $usuarios)
                                                                    @if($arracaoEspMedicos->medico_id == $usuarios->id)
                                                                    <option value="{{$usuarios->id}}">{{$usuarios->nome}} {{$usuarios->sobrenome}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Especialidade:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="especialidade" id="especialidade" readonly>
                                                                    @foreach($especialidade as $especialidades)
                                                                    @if($arracaoEspMedicos->especialidade_id == $especialidades->id)
                                                                    <option value="{{$especialidades->id}}">{{$especialidades->descricao}}</option>
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
                                                                    @foreach($especialidade as $especialidades)
                                                                    <option value="{{$arracaoEspMedicos->status}}">{{$status = ($arracaoEspMedicos->status == 0) ? "INATIVO"  : "ATIVO";}}</option>
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

                        <!-- Modal Para Apagar Especialidade -->
                        @foreach($arracaoEspMedico as $arracaoEspMedicos)
                        <div class="modal fade" id="apagarEspXMedico{{$arracaoEspMedicos->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Desativar Especialidade X Médico</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroEspecialidadesXMedicos/{{$arracaoEspMedicos->id}}/delete" method="post">

                                                        {{method_field('PUT')}}

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <p class="text-center">Tem certeza de que deseja desativar o cadastro?</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                        <button type="submit" name="desativarEspecialidadeXMedico" id="desativarEspecialidadeXMedico" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Confirmar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach

                        @if ($arracaoEspMedico->lastPage() > 1)
                        <ul class="pagination justify-content-end">
                            <li class=" {{ ($arracaoEspMedico->currentPage() == 1) ? ' page-item disabled' : '' }}">
                                <a class="page-link" href="{{ $arracaoEspMedico->url(1) }}">Anterior</a>
                            </li>
                            @for ($i = 1; $i <= $arracaoEspMedico->lastPage(); $i++)
                                <li class="{{ ($arracaoEspMedico->currentPage() == $i) ? ' page-item active' : '' }}">
                                    <a class="page-link" href="{{ $arracaoEspMedico->url($i) }}">{{ $i }}</a>
                                </li>
                                @endfor
                                <li class="{{ ($arracaoEspMedico->currentPage() == $arracaoEspMedico->lastPage()) ? '  page-item disabled' : '' }}">
                                    <a class="page-link" href="{{ $arracaoEspMedico->url($arracaoEspMedico->currentPage()+1) }}">Proximo</a>
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
@if ($errors->has('medico') || $errors->has('especialidade') || $errors->has('status'))
<script type="text/javascript">
    $('#addEspecialidadeXMedico').modal('show');
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