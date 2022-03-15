<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/styles_createUser.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/now-ui-dashboard.css') }}" rel="stylesheet">

    
    <!-- Fonts and icons     -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/v4-shims.css">

    <!--   Core JS Files   -->
    <script src="{{ asset('js/core/custom_page_public.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <title>healthLAB</title>


</head>

<body>

    <div class="wrapper">
        <div class="inner">
            <div class="image-holder">
                <img src="img/registration-form-6.jpg" alt="">
            </div>
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
                        <button type="submit" name="add" class="btnCadastrar">Cadastrar</a>

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


</body>

</html>