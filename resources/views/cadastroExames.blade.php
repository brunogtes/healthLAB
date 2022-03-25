<?php $nav_perfil = 'active'; ?>

@extends('layouts.master')



@section('titulo')

<a class="navbar-brand">@canany(['funcionario', 'admin']) Cadastro Exames @else Acesso negado! @endcanany</a>

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

                            <form action="/cadastroExames/search" method="get">

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

                                <button type="button" href="#addExame" class="btn btn-secondary" data-toggle="modal">Adicionar</button>

                                @csrf
                                @method('DELETE')
                                <button formaction="/ativarAllExames" type="submit" name="btnAtivarExame" class="btn btn-secondary">Ativar Exame</button>
                                <button formaction="/desativarAllExames" type="submit" name="btnDesativarExame" class="btn btn-secondary">Desativar Exame</button>


                        </div>

                    </div>

                    <div class="table-responsive">

                        <table class="table text-center">
                            <thead class=" text-primary">
                                <th scope="col"><input type="checkbox" class="selectall"></th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Class. Sexo</th>
                                <th scope="col">Situação</th>
                                <th scope="col">Opções</th>
                            </thead>
                            <tbody>
                                @foreach($exame as $exames)

                                <tr>
                                    <td><input type="checkbox" name="ids[]" class="selectbox" value="{{ $exames->id}}"></td>
                                    <th>{{$exames->descricao}}</th>
                                    <th>{{$class_sexo = ($exames->class_sexo == 'F' ? 'FEMENINO' : ($exames->class_sexo == 'M' ? 'MASCULINO' : ($exames->class_sexo == 'A' ? 'AMBOS' : 'teste')));}}</th>
                                    <th>{{$status = ($exames->status == 0) ? "INATIVO"  : "ATIVO";}}</th>
                                    <th>
                                        <a href="" data-toggle="modal" data-target="#editExame{{$exames->id}}"><i class="fas fa-edit fa-lg" title="Editar"></i></a>
                                        <a href="" data-toggle="modal" data-target='#visualizarExame{{$exames->id}}'><i class="fas fa-eye fa-lg" title="Visualizar"></i></a>
                                        <a href="" data-toggle="modal" data-target="#apagarExame{{$exames->id}}"><i class="fas fa-trash fa-lg" title="Apagar"></i></a>
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


                        <!-- Modal Para Adicionar Exame -->

                        <div class="modal fade" id="addExame" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Cadastrar Exame</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">

                                                 
                                                    <form class="form-horizontal" action="cadastroExames/create" method="get">

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Descrição:</label>
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
                                                                <label class="control-label" style="position:relative; top:7px;">Clssificação por Sexo:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="class_sexo" id="class_sexo">
                                                                    <option value=""></option>
                                                                    <option value="F" @if (old('class_sexo')=="F" ) {{ 'selected' }} @endif>Feminino</option>
                                                                    <option value="M" @if (old('class_sexo')=="M" ) {{ 'selected' }} @endif>Masculino</option>
                                                                    <option value="A" @if (old('class_sexo')=="A" ) {{ 'selected' }} @endif>Ambos</option>
                                                                </select>
                                                                @if ($errors->has('class_sexo'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('class_sexo') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Situação:</label>
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
                                        <button type="submit" name="addExames" id="addExames" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Cadastrar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>


                        @foreach($exame as $exames)
                        <!-- Modal Para Editar Exame -->

                        <div class="modal fade" id="editExame{{$exames->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Editar Convênio</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">

                                                    <form id="editExameForm" class="form-horizontal" action="cadastroExames/{{$exames->id}}/update" method="post">

                                                        {{method_field('PUT')}}

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Descrição:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="descricao" id="descricao" value="{{$exames->descricao}}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Classificação por Sexo:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="class_sexo" id="class_sexo" required>
                                                                    <option value=""></option>
                                                                    <option value="F" @if ($exames->class_sexo=="F" ) {{ 'selected' }} @endif>Feminino</option>
                                                                    <option value="M" @if ($exames->class_sexo=="M" ) {{ 'selected' }} @endif>Masculino</option>
                                                                    <option value="A" @if ($exames->class_sexo=="A" ) {{ 'selected' }} @endif>Ambos</option>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Situação:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="status" id="status" required>
                                                                    <option value="{{$exames->status}}">{{$status = ($exames->status == 0) ? "INATIVO"  : "ATIVO";}}</option>
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
                                        <button type="submit" name="editExame" id="editExame" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Atualizar</a>


                                    </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                        @endforeach

                        @foreach($exame as $exames)
                        <!-- Modal Para Visualizar Exame -->

                        <div class="modal fade" id="visualizarExame{{$exames->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Visualizar Exame</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroExames/{{$exames->id}}/show" method="post">
                                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Descrição:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="descricao" id="descricao" value="{{$exames->descricao}}" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Classificação por Sexo:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="class_sexo" id="class_sexo" readonly>
                                                                    <option value="{{$exames->class_sexo}}">{{$class_sexo = ($exames->class_sexo == 'F' ? 'Femenino' : ($exames->class_sexo == 'M' ? 'Masculino' : ($exames->class_sexo == 'A' ? 'Ambos' : 'teste')));}}</option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Situação:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="status" id="status" readonly>
                                                                    <option value="{{$exames->status}}">{{$status = ($exames->status == 0) ? "INATIVO"  : "ATIVO";}}</option>

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

                        @foreach($exame as $exames)
                        <!-- Modal Para Desativar Exame -->

                        <div class="modal fade" id="apagarExame{{$exames->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Desativar um Exame</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <form class="form-horizontal" action="cadastroExames/{{$exames->id}}/delete" method="post">

                                        @method('DELETE')

                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <p class="text-center">Tem certeza de que deseja desativar o exame {{$exames->descricao}} ?</p>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>Fechar</button>
                                        <button type="submit" name="apagarExame" id="apagarExame" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Confirmar</a>
                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>


                        @endforeach


                        @if ($exame->lastPage() > 1)
                        <ul class="pagination justify-content-end">
                            <li class=" {{ ($exame->currentPage() == 1) ? ' page-item disabled' : '' }}">
                                <a class="page-link" href="{{ $exame->url(1) }}">Anterior</a>
                            </li>
                            @for ($i = 1; $i <= $exame->lastPage(); $i++)
                                <li class="{{ ($exame->currentPage() == $i) ? ' page-item active' : '' }}">
                                    <a class="page-link" href="{{ $exame->url($i) }}">{{ $i }}</a>
                                </li>
                                @endfor
                                <li class="{{ ($exame->currentPage() == $exame->lastPage()) ? '  page-item disabled' : '' }}">
                                    <a class="page-link" href="{{ $exame->url($exame->currentPage()+1) }}">Proximo</a>
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
@if ($errors->has('descricao') || $errors->has('class_sexo') || $errors->has('status') )
<script type="text/javascript">
    $('#addExame').modal('show');
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