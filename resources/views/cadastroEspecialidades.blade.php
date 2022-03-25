@extends('layouts.master')

@section('titulo')

<a class="navbar-brand">@canany(['funcionario', 'admin'])Cadastro Especialidades @else Acesso negado! @endcanany</a>

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

                            <form action="/cadastroEspecialidades/search" method="get">

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

                                <button type="button" href="#addEspecialidade" class="btn btn-secondary" data-toggle="modal">Adicionar</button>
                                @csrf
                                @method('DELETE')
                                <button formaction="/ativarAllEspecialidades" type="submit" name="btnAtivarEspecialidade" class="btn btn-secondary">Ativar</button>
                                <button formaction="/desativarAllEspecialidades" type="submit" name="btnDesativarEspecialidade" class="btn btn-secondary">Desativar</button>


                        </div>

                    </div>


                    <div class="table-responsive">

                        <table class="table text-center">
                            <thead class=" text-primary">
                                <th scope="col"><input type="checkbox" class="selectall"></th>
                                <th scope="col">Especialidade</th>
                                <th scope="col">Status</th>
                                <th scope="col">Opções</th>
                            </thead>
                            <tbody>
                                <tr>
                                 @foreach($especialidade as $especialidades)
                                    <td><input type="checkbox" name="ids[]" class="selectbox" value="{{ $especialidades->id}}"></td>

                                    <th>{{$especialidades->descricao}}</th>
                                    <th>{{$status = ($especialidades->status == 0) ? "INATIVO"  : "ATIVO";}}</th>
                                    <th>
                                        <a href="" data-toggle="modal" data-target="#editEspecialidade{{$especialidades->id}}"><i class="fas fa-edit fa-lg" title="Editar"></i></a>
                                        <a href="" data-toggle="modal" data-target='#visualizarEspecialidade{{$especialidades->id}}'><i class="fas fa-eye fa-lg" title="Visualizar"></i></a>
                                        <a href="" data-toggle="modal" data-target="#apagarEspecialidade{{$especialidades->id}}"><i class="fas fa-trash fa-lg" title="Apagar"></i></a>
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


                        <!-- Modal Para Adicionar Especialidade -->

                        <div class="modal fade" id="addEspecialidade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Adicionar Especialidade</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroEspecialidades/create" method="post">

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Especialidade:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="especialidade" id="especialidade">
                                                                @if ($errors->has('especialidade'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('especialidade') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Status:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="status" id="status" >
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
                                        <button type="submit" name="addEspecialidade" id="addEspecialidade" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Cadastrar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- Modal Para Editar Especialidade -->

                        @foreach($especialidade as $especialidades)
                        <div class="modal fade" id="editEspecialidade{{$especialidades->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Editar Especialidade</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroEspecialidades/{{$especialidades->id}}/update" method="post">

                                                    {{method_field('PUT')}}

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Especialidade:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="especialidade" id="especialidade" value="{{$especialidades->descricao}}" required>
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Status:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="status" id="status" required>
                                                                @foreach($especialidade as $especialidades)
                                                                    <option value="{{$especialidades->status}}">{{$status = ($especialidades->status == 0) ? "INATIVO"  : "ATIVO";}}</option>
                                                                    @endforeach
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
                                        <button type="submit" name="editEspecialidade" id="editEspecialidade" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Atualizar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Modal Para Visualizar Especialidade -->
                        @foreach($especialidade as $especialidades)
                        <div class="modal fade" id="visualizarEspecialidade{{$especialidades->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Visualizar Especialidade</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroEspecialidades/{{$especialidades->id}}/show" method="get">


                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Especialidade:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="especialidade" id="especialidade"  value="{{$especialidades->descricao}}" readonly>
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Status:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="status" id="status" readonly>
                                                                @foreach($especialidade as $especialidades)
                                                                    <option value="{{$especialidades->status}}">{{$status = ($especialidades->status == 0) ? "INATIVO"  : "ATIVO";}}</option>
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
                        @foreach($especialidade as $especialidades)
                        <div class="modal fade" id="apagarEspecialidade{{$especialidades->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Desativar Especialidade</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroEspecialidades/{{$especialidades->id}}/delete" method="post">
                                                    {{method_field('PUT')}}

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <p class="text-center">Tem certeza de que deseja desativar a especialidade {{$especialidades->descricao}}?</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                        <button type="submit" name="desativarEspecialidade" id="desativarEspecialidade" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Confirmar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach

                        @if ($especialidade->lastPage() > 1)
                        <ul class="pagination justify-content-end">
                            <li class=" {{ ($especialidade->currentPage() == 1) ? ' page-item disabled' : '' }}">
                                <a class="page-link" href="{{ $especialidade->url(1) }}">Anterior</a>
                            </li>
                            @for ($i = 1; $i <= $especialidade->lastPage(); $i++)
                                <li class="{{ ($especialidade->currentPage() == $i) ? ' page-item active' : '' }}">
                                    <a class="page-link" href="{{ $especialidade->url($i) }}">{{ $i }}</a>
                                </li>
                                @endfor
                                <li class="{{ ($especialidade->currentPage() == $especialidade->lastPage()) ? '  page-item disabled' : '' }}">
                                    <a class="page-link" href="{{ $especialidade->url($especialidade->currentPage()+1) }}">Proximo</a>
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
@if ($errors->has('especialidade') || $errors->has('status'))
<script type="text/javascript">
    $('#addEspecialidade').modal('show');
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