<!--

=========================================================
* Now UI Dashboard - v1.5.0
=========================================================

* Product Page: https://www.creative-tim.com/product/now-ui-dashboard
* Copyright 2019 Creative Tim (http://www.creative-tim.com)

* Designed by www.invisionapp.com Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../img/apple-icon.png">
    <link rel="icon" type="image/png" href="../img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Registra-se
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link href="../css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
</head>

<body class="user-profile">
    <div class="wrapper ">
        <div class="panel-header panel-header-sm">
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">Registra-se</h5>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="cadastro/create" method="post">

                                <input type="hidden" name="_token" value="{{csrf_token()}}">

                                <div class="row">
                                    <div class="col-md-5 pr-1">
                                        <div class="form-group">
                                            <label>CPF<span style="color: red">*</span></label>
                                            <p><input type="text" id="cpf" name="cpf" class="form-control" onkeyup="cpfCheck(this)" maxlength="14" onkeydown="javascript: fMasc( this, mCPF );" value="{{old('cpf')}}"> <span id="cpfResponse"></span></p>
                                            @if ($errors->has('cpf'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('cpf') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-7 pl-1">
                                        <div class="form-group">
                                            <label for="email">E-mail:<span style="color: red">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}" require>
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
                                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="{{old('nome')}}" require>
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
                                            <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome" value="{{old('sobrenome')}}" require>
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
                                        <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" onkeyup="mascara_data(this, this.value)" maxlength="10" placeholder="00/00/0000" value="{{old('data_nascimento')}}" require>
                                        @if ($errors->has('data_nascimento'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('data_nascimento') }}</strong>
                                        </span>
                                        @endif

                                    </div>

                                    <div class="col-md-4">

                                        <label>Telefone 1:<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" id="telefone1" name="telefone1" placeholder="(00)00000-0000" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);" value="{{old('telefone1')}}" require>
                                        @if ($errors->has('telefone1'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('telefone1') }}</strong>
                                        </span>
                                        @endif

                                    </div>

                                    <div class="col-md-4">

                                        <label>Telefone 2:</label>
                                        <input type="text" class="form-control" id="telefone2" name="telefone2" placeholder="(00)00000-0000" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);" value="{{old('telefone2')}}" require>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-4">

                                        <label>CEP:<span style="color: red">*</span></label>
                                        <p><input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" size="10" maxlength="9" onblur="pesquisacep(this.value);" value="{{old('cep')}}" require><span id="CEPResponse"></span></p>
                                        @if ($errors->has('cep'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cep') }}</strong>
                                        </span>
                                        @endif

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Rua:<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Rua" value="{{old('endereco')}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Número:<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" id="numero" name="numero" placeholder="Nº" value="{{old('numero')}}" require>
                                            @if ($errors->has('numero'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('numero') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Bairro:<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="{{old('bairro')}}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Cidade:<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="{{old('cidade')}}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Estado:<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="uf" id="uf" placeholder="UF" value="{{old('uf')}}" readonly>

                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        <label>Senha:<span style="color: red">* </span><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="A senha deve contér no mínimo 8 caracteres."></i></label>
                                        <input type="password" class="form-control" name="senha" id="senha" />
                                        @if ($errors->has('senha'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('senha') }}</strong>
                                        </span>
                                        @endif

                                    </div>

                                    <div class="col-md-3">
                                        <label>Confirmar Senha:<span style="color: red">*</span></label>
                                        <input type="password" class="form-control" name="confirmarSenha" id="confirmarSenha" />
                                        @if ($errors->has('confirmarSenha'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('confirmarSenha') }}</strong>
                                        </span>
                                        @endif

                                    </div>

                                    <div class="col-md-3">
                                        <label>Convênio:<span style="color: red">*</span></label>
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


                                    <div class="col-md-3">
                                        <label>Plano:<span style="color: red">*</span></label>
                                        <select class="form-control" name="plano" id="plano">
                                            <option value=""></option>
                                            @foreach($listaPlanos as $planos)
                                            @if(old('plano') == $planos->plano_id)
                                            <option value="{{old('plano')}}" selected>{{$planos->descricao}}</option>
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

                                    <div class="col-lg-12">                                       
                                        <button type="submit" class="btn btn-secondary btn-lg btn-block">Cadastrar</button>

                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-lg-12" style="text-align: center;">
                                        <p>Já possui conta? <a href="login">Login</a></p>

                                    </div>

                                </div>


                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="panel-header panel-header-sm">
        </div>

    </div>
    </div>
    <!--   Core JS Files   -->
    <script src="../js/core/jquery.min.js"></script>
    <script src="../js/core/popper.min.js"></script>
    <script src="../js/core/bootstrap.min.js"></script>
    <script src="../js/core/custom_page_public.js"></script>
    <script src="../js/plugins/perfect-scrollbar.jquery.min.js"></script>    
    <!-- Chart JS -->
    <script src="../js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
    
</body>

</html>