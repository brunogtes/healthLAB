<?php $nav_perfil = 'active'; ?>

@extends('layouts.master')



@section('titulo')

<a class="navbar-brand">Perfil</a>

@endsection

@section('panel-header')

<div class="panel-header panel-header-sm">
</div>

@endsection

@section('content')

<div class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Editar Perfil</h5>
        </div>
        <div class="card-body">

          <form class="form-horizontal" action="perfil/{{Auth::guard('usuarios')->user()->id}}" method="post" enctype="multipart/form-data">

            {{method_field('PUT')}}

            <input type="hidden" name="_token" value="{{csrf_token()}}">

            <div class="row">
              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label>CPF<span style="color: red">*</span></label>
                  <p><input type="text" id="cpf" name="cpf" class="form-control" onkeyup="cpfCheck(this)" maxlength="14" onkeydown="javascript: fMasc( this, mCPF );" value="{{Auth::guard('usuarios')->user()->cpf}}" readonly> <span id="cpfResponse"></span></p>
                </div>
              </div>
              <div class="col-md-7 pl-1">
                <div class="form-group">
                  <label for="email">E-mail:<span style="color: red">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{Auth::guard('usuarios')->user()->email}}" require>
                  @if ($errors->has('email'))
                  <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                  @endif

                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label>Nome:<span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="{{Auth::guard('usuarios')->user()->nome}}" require>
                  @if ($errors->has('nome'))
                  <span class="help-block">
                    <strong>{{ $errors->first('nome') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
              <div class="col-md-6 pl-1">
                <div class="form-group">
                  <label>Sobrenome:<span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome" value="{{Auth::guard('usuarios')->user()->sobrenome}}" require>
                  @if ($errors->has('sobrenome'))
                  <span class="help-block">
                    <strong>{{ $errors->first('sobrenome') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
            </div>
            <div class="row">

              <div class="col-md-4">

                <label>Data de Nascimento:<span style="color: red">*</span></label>
                <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" onkeyup="mascara_data(this, this.value)" maxlength="10" placeholder="00/00/0000" value="{{Auth::guard('usuarios')->user()->data_nascimento}}" require>
                @if ($errors->has('data_nascimento'))
                <span class="help-block">
                  <strong>{{ $errors->first('data_nascimento') }}</strong>
                </span>
                @endif

              </div>

              <div class="col-md-4">

                <label>Telefone 1:<span style="color: red">*</span></label>
                <input type="text" class="form-control" id="telefone1" name="telefone1" placeholder="(00)00000-0000" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);" value="{{Auth::guard('usuarios')->user()->telefone1}}" require>
                @if ($errors->has('telefone1'))
                <span class="help-block">
                  <strong>{{ $errors->first('telefone1') }}</strong>
                </span>
                @endif

              </div>

              <div class="col-md-4">

                <label>Telefone 2:</label>
                <input type="text" class="form-control" id="telefone2" name="telefone2" placeholder="(00)00000-0000" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);" value="{{Auth::guard('usuarios')->user()->telefon2}}" require>

              </div>

            </div>


            <div class="row">

              <div class="col-md-4">

                <label>CEP:<span style="color: red">*</span></label>
                <p><input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" size="10" maxlength="9" onblur="pesquisacep(this.value);" value="{{Auth::guard('usuarios')->user()->CEP}}" require><span id="CEPResponse"></span></p>
                @if ($errors->has('CEP'))
                <span class="help-block">
                  <strong>{{ $errors->first('CEP') }}</strong>
                </span>
                @endif

              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Rua:<span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Rua" value="{{Auth::guard('usuarios')->user()->endereco}}" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Número:<span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="numero" name="numero" placeholder="Nº" value="{{Auth::guard('usuarios')->user()->numero}}" require>
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-md-4">
                <div class="form-group">
                  <label>Bairro:<span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="{{Auth::guard('usuarios')->user()->bairro}}" readonly>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label>Cidade:<span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="{{Auth::guard('usuarios')->user()->cidade}}" readonly>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label>Estado:<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="uf" id="uf" placeholder="UF" value="{{Auth::guard('usuarios')->user()->UF}}" readonly>

                </div>
              </div>

            </div>

            <br>

            <p>Dados do Convênio</p>

            <br>


            <div class="row">


              <div class="col-md-4">
                <label>Convênio:<span style="color: red">*</span></label>
                <select class="form-control" name="convenio" id="convenio">
                  <option value=""></option>

                  @foreach($listaConvenios as $convenios)
                  @if(Auth::guard('usuarios')->user()->convenio_id == $convenios->id)
                  <option value="{{Auth::guard('usuarios')->user()->convenio_id}}" selected>{{$convenios->nome_fantasia}}</option>
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

              <div class="col-md-4">
                <label>Plano:<span style="color: red">*</span></label>
                <select class="form-control" name="plano" id="plano">
                  <option value=""></option>

                  @foreach($listaPlanos as $planos)
                  @if(Auth::guard('usuarios')->user()->plano_id == $planos->plano_id)
                  <option value="{{Auth::guard('usuarios')->user()->plano_id}}" selected>{{$planos->descricao}}</option>
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


            <div class="row">

              <div class="col-lg-12" style="text-align: right;">
                <button type="submit" name="add" class="btn btn-primary" data-toggle="modal"><span class="glyphicon glyphicon-floppy-disk"></span> Salvar</a>

              </div>



            </div>


          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-user">
        <div class="image">
          <img src="../img/bg5.jpg" alt="...">-->
        </div>
        <div class="card-body">
          <div class="author">

            <form name="form_uploadPicture" action="perfil_img/{{Auth::guard('usuarios')->user()->id}}" method="post" enctype="multipart/form-data">

              {{method_field('PUT')}}

              <input type="hidden" name="_token" value="{{csrf_token()}}">

              <div class="personal-image">
                <label class="label">
                  <input type="file" name="image" id="image" accept="image/*" />
                  <figure class="personal-figure">
                    @if(Auth::guard('usuarios')->user()->image != null)
                    <img class="avatar border-gray" src="{{url('storage/'.Auth::guard('usuarios')->user()->image)}}">
                    @else
                    <img class="avatar border-gray" src="../img/default-avatar.png" alt="...">

                    @endif
                    <figcaption class="personal-figcaption">
                      <img src="https://raw.githubusercontent.com/ThiagoLuizNunes/angular-boilerplate/master/src/assets/imgs/camera-white.png">
                    </figcaption>
                  </figure>
                </label>
              </div>

              <button type="submit" name="btn_upload_img" id="btn_upload_img" class="btn btn-primary" style="display: none;"> Salvar

            </form>

            <br>

          </div>
          <h5 class="title text-center">{{Auth::guard('usuarios')->user()->nome}} {{Auth::guard('usuarios')->user()->sobrenome}}</h5>
          <p class="description text-center" href="#alterarSenha" data-toggle="modal" style="cursor: pointer;">Alterar Senha</p>
        </div>


      </div>
    </div>
  </div>

  <div class="modal fade" id="alterarSenha" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">

      <!-- Conteúdo do modal-->
      <div class="modal-content">

        <!-- Cabeçalho do modal -->
        <div class="modal-header">
          <h4 class="modal-title">Alterar Senha</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Corpo do modal -->
        <div class="modal-body">

          <div clas="span10 offset1">
            <div class="card">

              <div class="card-body">

                <div id="erroSenha"></div>

                <form class="form-horizontal" action="perfil/alterarSenha/{{Auth::guard('usuarios')->user()->id}}" method="post">

                  {{method_field('PUT')}}

                  <input type="hidden" name="_token" value="{{csrf_token()}}">

                  <div class="row form-group">
                    <div class="col-sm-3">
                      <label class="control-label" style="position:relative; top:7px;">Senha:<span style="color: red">* </span><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Senha de no mínimo 8 caracteres."></i></label>
                    </div>
                    <div class="col-sm-9 {{ $errors->has('senha') ? ' has-error' : '' }}">
                      <input type="password" class="form-control" name="senha" id="senha" value="">
                      @if ($errors->has('senha'))
                      <span class="help-block">
                        <strong>{{ $errors->first('senha') }}</strong>
                      </span>
                      @endif
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-sm-3">
                      <label class="control-label" style="position:relative; top:7px;">Confirmar Senha:<span style="color: red">*</span></label>
                    </div>
                    <div class="col-sm-9 {{ $errors->has('confirmarSenha') ? ' has-error' : '' }}">
                      <input type="password" class="form-control" name="confirmarSenha" id="confirmarSenha" value="">
                      @if ($errors->has('confirmarSenha'))
                      <span class="help-block">
                        <strong>{{ $errors->first('confirmarSenha') }}</strong>
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
          <button type="submit" name="btn_atualizarSenha" id="btn_atualizarSenha" class="btn btn-success" onclick="return validarSenha()"><span class="glyphicon glyphicon-check"></span>Atualizar</a>

            </form>
        </div>

      </div>
    </div>
  </div>


</div>


@if (count($errors) > 0)
@if ($errors->has('senha') || $errors->has('confirmarSenha') )
<script type="text/javascript">
  $('#alterarSenha').modal('show');
</script>
@endif
@endif



@endsection