@extends('layouts.master')

@section('titulo')

<a class="navbar-brand">Cadastro Itens Exame</a>

@endsection

@section('panel-header')

<div class="panel-header panel-header-sm">
</div>

@endsection

@section('content')
<div class="content">

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

                            <form action="/cadastroItensExame/search" method="get">

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

                                <button type="button" href="#addItem" class="btn btn-secondary" data-toggle="modal">Adicionar</button>
                                @csrf
                                @method('DELETE')
                                <button formaction="/ativarAllItensExames" type="submit" name="btnAtivarItemExame" class="btn btn-secondary">Ativar Item</button>
                                <button formaction="/desativarAllItensExames" type="submit" name="btnDesativarItemExame" class="btn btn-secondary">Desativar Item</button>


                        </div>

                    </div>


                    <div class="table-responsive">

                        <table class="table text-center">
                            <thead class=" text-primary">
                                <th scope="col"><input type="checkbox" class="selectall"></th>
                                <th scope="col">Item</th>
                                <th scope="col">Status</th>
                                <th scope="col">Opções</th>
                            </thead>
                            <tbody>

                                <tr>

                                    @foreach($itens as $itensExames)
                                    <td><input type="checkbox" name="ids[]" class="selectbox" value="{{ $itensExames->item_exame_id}}"></td>

                                    <th>{{$itensExames->descricao}}</th>
                                    <th>{{$status = ($itensExames->status == 0) ? "INATIVO"  : "ATIVO";}}</th>
                                    <th>
                                        <a href="" data-toggle="modal" data-target="#editItensExame{{$itensExames->item_exame_id}}"><i class="fas fa-edit fa-lg" title="Editar"></i></a>
                                        <a href="" data-toggle="modal" data-target='#visualizarItensExame{{$itensExames->item_exame_id}}'><i class="fas fa-eye fa-lg" title="Visualizar"></i></a>
                                        <a href="" data-toggle="modal" data-target="#apagarItensExame{{$itensExames->item_exame_id}}"><i class="fas fa-trash fa-lg" title="Apagar"></i></a>
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


                        <!-- Modal Para Adicionar Itens de Exame -->

                        <div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Adicionar Item de Exame</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">                                             

                                                    <form class="form-horizontal" action="cadastroItensExame/create" method="get">


                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Exame:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="exame" id="exame">
                                                                    <option value=""></option>

                                                                    @foreach($exame as $exames)
                                                                    @if(old('exame') == $exames->id)
                                                                    <option value="{{old('convenio')}}" selected>{{$exames->descricao}}</option>
                                                                    @endif
                                                                    @endforeach

                                                                    @foreach($exame as $exames)
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
                                                                <label class="control-label" style="position:relative; top:7px;">Descrição Reduzida:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="descricaoReduzida" id="descricaoReduzida" value="{{old('descricaoReduzida')}}">
                                                                @if ($errors->has('descricaoReduzida'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('descricaoReduzida') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Valor de Referência:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="valorReferencia" id="valorReferencia" value="{{old('valorReferencia')}}">
                                                                @if ($errors->has('valorReferencia'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('valorReferencia') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Valor Mínimo:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="valorMinimo" id="valorMinimo" value="{{old('valorMinimo')}}">
                                                                @if ($errors->has('valorMinimo'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('valorMinimo') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Valor Máximo:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="valorMaximo" id="valorMaximo" value="{{old('valorMaximo')}}">
                                                                @if ($errors->has('valorMaximo'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('valorMaximo') }}</strong>
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
                                        <button type="submit" name="addItem" id="addItem" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Cadastrar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- Modal Para Editar Item de Exame -->
                        @foreach($itens as $itensExames)

                        <div class="modal fade" id="editItensExame{{$itensExames->item_exame_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Editar Item de Exame</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroItensExame/{{$itensExames->item_exame_id}}/update" method="post">

                                                        {{method_field('PUT')}}

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Exame:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="exame" id="exame" required>
                                                                    @foreach($exame as $exames)

                                                                    @if ($exames->id == $itensExames->item_exame_id)
                                                                    <option value="{{$exames->id}}">{{$exames->descricao}}</option>
                                                                    @endif
                                                                    @endforeach

                                                                    @foreach($exame as $exames)
                                                                    @if ($exames->status == '1')
                                                                    <option value="{{$exames->id}}">{{$exames->descricao}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Descrição:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="descricao" id="descricao" value="{{$itensExames->descricao}}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Descrição Reduzida:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="descricaoReduzida" id="descricaoReduzida" value="{{$itensExames->descricao_reduzida}}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Valor de Referência:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="valorReferencia" id="valorReferencia" value="{{$itensExames->valor_referencia}}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Valor Mínimo:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="valorMinimo" id="valorMinimo" value="{{$itensExames->valor_minimo}}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Valor Máximo:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="valorMaximo" id="valorMaximo" value="{{$itensExames->valor_maximo}}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Status:<span style="color: red">*</span></label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="status" id="status" required>
                                                                <option value=""></option>
                                                                    <option value="1" @if ($itensExames->status =="1" ) {{ 'selected' }} @endif>ATIVO</option>
                                                                    <option value="0" @if ($itensExames->status=="0" ) {{ 'selected' }} @endif>INATIVO</option>
                                                                </select>

                                                            </div>
                                                        </div>



                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                        <button type="submit" name="addPlano" id="addPlano" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Atualizar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- Modal Para Visualizar Item  -->

                        @foreach($itens as $itensExames)
                        <div class="modal fade" id="visualizarItensExame{{$itensExames->item_exame_id}}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                    <form class="form-horizontal" action="cadastroPlanos/show" method="get">


                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Exame:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="exame" id="exame" readonly>
                                                                    @foreach($exame as $exames)
                                                                    @if ($exames->status == '1')
                                                                    <option value="{{$exames->id}}">{{$exames->descricao}}</option>
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
                                                                <input type="text" class="form-control" name="descricao" id="descricao" value="{{$itensExames->descricao}}" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Descrição Reduzida:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="descricaoReduzida" id="descricaoReduzida" value="{{$itensExames->descricao_reduzida}}" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Valor de Referência:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="valorReferencia" id="valorReferencia" value="{{$itensExames->valor_referencia}}" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Valor Mínimo:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="valorMinimo" id="valorMinimo" value="{{$itensExames->valor_minimo}}" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Valor Máximo:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="valorMaximo" id="valorMaximo" value="{{$itensExames->valor_maximo}}" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-sm-2">
                                                                <label class="control-label" style="position:relative; top:7px;">Status:</label>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="status" id="status" readonly>
                                                                    @foreach($exame as $exames)
                                                                    <option value="{{$exames->status}}">{{$status = ($itensExames->status == 0) ? "INATIVO"  : "ATIVO";}}</option>
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

                        <!-- Modal Para Apagar Item -->

                        @foreach($itens as $itensExames)
                        <div class="modal fade" id="apagarItensExame{{$itensExames->item_exame_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">

                                <!-- Conteúdo do modal-->
                                <div class="modal-content">

                                    <!-- Cabeçalho do modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Desativar Item de Exame</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Corpo do modal -->
                                    <div class="modal-body">

                                        <div clas="span10 offset1">
                                            <div class="card">

                                                <div class="card-body">
                                                    <form class="form-horizontal" action="cadastroItensExame/{{$itensExames->item_exame_id}}/delete" method="post">

                                                        @method('DELETE')

                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">


                                                        <p class="text-center">Tem certeza de que deseja desativar o Item {{$itensExames->descricao}}</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                        <button type="submit" name="apagarItem" id="apagarItem" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Confirmar</a>

                                            </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        @endforeach

                        @if ($itens->lastPage() > 1)
                        <ul class="pagination justify-content-end">
                            <li class=" {{ ($itens->currentPage() == 1) ? ' page-item disabled' : '' }}">
                                <a class="page-link" href="{{ $itens->url(1) }}">Anterior</a>
                            </li>
                            @for ($i = 1; $i <= $itens->lastPage(); $i++)
                                <li class="{{ ($itens->currentPage() == $i) ? ' page-item active' : '' }}">
                                    <a class="page-link" href="{{ $itens->url($i) }}">{{ $i }}</a>
                                </li>
                                @endfor
                                <li class="{{ ($itens->currentPage() == $itens->lastPage()) ? '  page-item disabled' : '' }}">
                                    <a class="page-link" href="{{ $itens->url($itens->currentPage()+1) }}">Proximo</a>
                                </li>
                        </ul>
                        @endif

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@if (count($errors) > 0)
@if ($errors->has('exame') || $errors->has('descricao') || $errors->has('descricaoReduzida') || $errors->has('valorReferencia') || $errors->has('valorMinimo') || $errors->has('valorMaximo') || $errors->has('status') )
<script type="text/javascript">
    $('#addItem').modal('show');
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