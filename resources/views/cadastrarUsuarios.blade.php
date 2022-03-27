@extends('layouts.master')

@section('titulo')

<a class="navbar-brand">@can('admin')Cadastrar Usuários @else Acesso negado! @endcan</a>

@endsection

@section('panel-header')

<div class="panel-header panel-header-sm">
</div>

@endsection

@section('content')
@can('admin')

<div class="content">

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">

          <div class="row">


            <div class="col-md-4">
              <div class="card-menu">
                <span class="card-number"> {{$totalUsuarios}}</span>
                <span class="card-name">Total de Usuários</span>
              </div>

            </div>

            <div class="col-md-4">
              <div class="card-menu">

                <span class="card-number">{{$usuariosAtivos}}</span>
                <span class="card-name">Ativos</span>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card-menu">
                <span class="card-number">{{$usuariosInativos}}</span>
                <span class="card-name">Inativos</span>
              </div>
            </div>

          </div>

          <br>

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

              <form action="/cadastrarUsuarios/search" method="get">

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

                <button type="button" href="#addUsuario" class="btn btn-secondary" data-toggle="modal">Adicionar</button>
                @csrf
                @method('DELETE')
                <button formaction="/ativarAllUsuarios" type="submit" name="btnAtivarUsuario" class="btn btn-secondary">Ativar</button>
                <button formaction="/desativarAllUsuarios" type="submit" name="btnDesativarUsuario" class="btn btn-secondary">Desativar</button>


                <div class="btn-group">
                  <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Exportar&nbsp&nbsp&nbsp
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ url('cadastrarUsuarios/pdf') }}" target="_blank">PDF</a>
                    <a class="dropdown-item" href="cadastrarUsuarios/excel" id="export" onclick="exportTasks(event.target);">Excel</a>

                  </div>
                </div>

            </div>


            <div class="table-responsive">

              <table class="table text-center">
                <thead class=" text-primary">
                  <th scope="col"><input type="checkbox" class="selectall"></th>
                  <th scope="col">Nome</th>
                  <th scope="col">E-mail</th>
                  <th scope="col">Status</th>
                  <th scope="col">Opções</th>
                </thead>
                <tbody>

                  @foreach($listaUsuarios as $usuarios)
                  <tr>
                    <td><input type="checkbox" name="ids[]" class="selectbox" value="{{$usuarios->usuario_id}}"></td>
                    <th>{{$usuarios->nome}} {{$usuarios->sobrenome}}</th>
                    <th>{{$usuarios->email}}</th>
                    <th>{{$status = ($usuarios->status == 0) ? "INATIVO"  : "ATIVO";}}</th>
                    <th>
                      <a href="" data-toggle="modal" data-target="#editUsuario{{$usuarios->id}}"><i class="fas fa-edit fa-lg" title="Editar"></i></a>
                      <a href="" data-toggle="modal" data-target='#visualizarUsuario{{$usuarios->id}}'><i class="fas fa-eye fa-lg" title="Visualizar"></i></a>
                      <a href="" data-toggle="modal" data-target="#apagarUsuario{{$usuarios->id}}"><i class="fas fa-trash fa-lg" title="Apagar"></i></a>
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


              <!-- Modal Para Adicionar Novo Usuario -->
              <!-- Add New -->
              <div class="modal fade" id="addUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">

                  <!-- Conteúdo do modal-->
                  <div class="modal-content">

                    <!-- Cabeçalho do modal -->
                    <div class="modal-header">
                      <h4 class="modal-title">Adicionar Usuário </h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Corpo do modal -->
                    <div class="modal-body">

                      <div clas="span10 offset1">
                        <div class="card">

                          <div class="card-body">

                            @if (count($errors) > 0)
                            <div id="msgValidacaoAdicionar" class="alert alert-danger">
                              <ul> @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                              </ul>
                            </div>
                            @endif

                            <form class="form-horizontal" action="cadastrarUsuarios/create" method="post" data-target="product">

                              <input type="hidden" name="_token" value="{{csrf_token()}}">

                              <div class="row">
                                <div class="col-md-5 pr-1">
                                  <div class="form-group">
                                    <label>CPF<span style="color: red">*</span></label>
                                    <p><input type="text" id="cpf" name="cpf" class="form-control" onkeyup="cpfCheck(this)" maxlength="14" onkeydown="javascript: fMasc( this, mCPF );" value="{{old('cpf')}}"> <span id="cpfResponse"></span></p>
                                  </div>
                                </div>
                                <div class="col-md-7 pl-1">
                                  <div class="form-group">
                                    <label for="email">E-mail:<span style="color: red">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}" require>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6 pr-1">
                                  <div class="form-group">
                                    <label>Nome:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="{{old('nome')}}" require>
                                  </div>
                                </div>
                                <div class="col-md-6 pl-1">
                                  <div class="form-group">
                                    <label>Sobrenome:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome" value="{{old('sobrenome')}}" require>
                                  </div>
                                </div>
                              </div>
                              <div class="row">

                                <div class="col-md-4">

                                  <label>Data de Nascimento:<span style="color: red">*</span></label>
                                  <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" onkeyup="mascara_data(this, this.value)" maxlength="10" placeholder="00/00/0000" value="{{old('data_nascimento')}}" require>

                                </div>

                                <div class="col-md-4">

                                  <label>Telefone 1:<span style="color: red">*</span></label>
                                  <input type="text" class="form-control" id="telefone1" name="telefone1" placeholder="(00)00000-0000" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);" value="{{old('telefone1')}}" require>

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

                                <div class="col-md-4">
                                  <label>Senha:<span style="color: red">* </span><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Senha de no mínimo 8 caracteres."></i></label>
                                  <input type="password" class="form-control" name="senha" id="senha" value="" require>
                                </div>

                                <div class="col-md-4">
                                  <label>Confirmar Senha:<span style="color: red">*</span></label>
                                  <input type="password" class="form-control" name="confirmarSenha" id="confirmarSenha" require>
                                </div>

                                <div class="col-md-4">
                                  <label>Status:<span style="color: red">*</span></label>
                                  <select class="form-control" name="status" id="status" require>
                                    <option value=""></option>
                                    <option value="1" @if (old('status')=="1" ) {{ 'selected' }} @endif>ATIVO</option>
                                    <option value="0" @if (old('status')=="0" ) {{ 'selected' }} @endif>INATIVO</option>

                                  </select>
                                </div>

                              </div>

                              <br>
                              <h6>Perfil</h6>
                              <br>

                              <div class="row">

                                <div class="col-md-4">
                                  <label>Perfil:<span style="color: red">*</span></label>
                                  <select class="form-control" name="perfil" id="perfil" onchange="verificaPerfil(this.value)" require>

                                    <option value=""></option>
                                    <option value="P" @if (old('perfil')=="P" ) {{ 'selected' }} @endif>Paciente</option>
                                    <option value="M" @if (old('perfil')=="M" ) {{ 'selected' }} @endif>Médico</option>
                                    <option value="F" @if (old('perfil')=="F" ) {{ 'selected' }} @endif>Funcionário</option>
                                    <option value="A" @if (old('perfil')=="A" ) {{ 'selected' }} @endif>Administrador</option>

                                  </select>
                                </div>

                                <div class="col-md-4">
                                  <label>Função:<span style="color: red">*</span></label>
                                  <select class="form-control" name="funcao" id="funcao" @if (old('perfil')=="F" ) {{ '' }} @else {{ 'disabled' }} @endif>
                                    <option value=""></option>
                                    <option value="A" @if (old('funcao')=="A" ) {{ 'selected' }} @endif>Atendente</option>
                                    <option value="B" @if (old('funcao')=="B" ) {{ 'selected' }} @endif>Bioquimico</option>

                                  </select>
                                </div>

                                <div class="col-md-4">
                                  <label>Médico - CRM:<span style="color: red">*</span></label>
                                  <input type="text" class="form-control" name="crm" id="crm" value="{{old('crm')}}" @if (old('perfil')=="M" ) {{ '' }} @else {{ 'disabled' }} @endif>
                                </div>

                              </div>

                              <div class="row">

                                <div class="col-md-4">

                                </div>

                                <div class="col-md-4">
                                  <label>Convênio:<span style="color: red">*</span></label>
                                  <select class="form-control" name="convenio" id="convenio" @if (old('perfil')=="P" ) {{ '' }} @else {{ 'disabled' }} @endif>
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
                                </div>

                                <div class="col-md-4">
                                  <label>Plano:<span style="color: red">*</span></label>
                                  <select class="form-control" name="plano" id="plano" @if (old('perfil')=="P" ) {{ '' }} @else {{ 'disabled' }} @endif>
                                    <option value=""></option>
                                    @foreach($listaPlanos as $planos)
                                    @if(old('plano') == $planos->plano_id)
                                    <option value="{{old('plano')}}" selected>{{$planos->descricao}}</option>
                                    @endif
                                    @endforeach



                                  </select>
                                </div>

                              </div>




                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                      <button type="submit" name="add" class="btn btn-primary" data-toggle="modal"><span class="glyphicon glyphicon-floppy-disk"></span> Salvar</a>
                        </form>
                    </div>

                  </div>
                </div>
              </div>

              <!-- Modal Para editar Novo Usuario -->

              @foreach($listaUsuarios as $usuarios)
              <div class="modal fade" id="editUsuario{{$usuarios->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">

                  <!-- Conteúdo do modal-->
                  <div class="modal-content">

                    <!-- Cabeçalho do modal -->
                    <div class="modal-header">
                      <h4 class="modal-title">Editar Usuário </h4>
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

                            <form class="form-horizontal" action="cadastrarUsuarios/{{$usuarios->usuario_id}}/update" method="post">

                              {{method_field('PUT')}}

                              <input type="hidden" name="_token" value="{{csrf_token()}}">

                              <div class="row">
                                <div class="col-md-5 pr-1">
                                  <div class="form-group">
                                    <label>CPF<span style="color: red">*</span></label>
                                    <p><input type="text" id="cpf" name="cpf" class="form-control" onkeyup="cpfCheck(this)" maxlength="14" onkeydown="javascript: fMasc( this, mCPF );" value="{{$usuarios->cpf}}" readonly> <span id="cpfResponse"></span></p>
                                  </div>
                                </div>
                                <div class="col-md-7 pl-1">
                                  <div class="form-group">
                                    <label for="email">E-mail:<span style="color: red">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$usuarios->email}}" require>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6 pr-1">
                                  <div class="form-group">
                                    <label>Nome:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="{{$usuarios->nome}}" require>
                                  </div>
                                </div>
                                <div class="col-md-6 pl-1">
                                  <div class="form-group">
                                    <label>Sobrenome:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome" value="{{$usuarios->sobrenome}}" require>
                                  </div>
                                </div>
                              </div>
                              <div class="row">

                                <div class="col-md-4">

                                  <label>Data de Nascimento:<span style="color: red">*</span></label>
                                  <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" onkeyup="mascara_data(this, this.value)" maxlength="10" placeholder="00/00/0000" value="{{$usuarios->data_nascimento}}" require>

                                </div>

                                <div class="col-md-4">

                                  <label>Telefone 1:<span style="color: red">*</span></label>
                                  <input type="text" class="form-control" id="telefone1" name="telefone1" placeholder="(00)00000-0000" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);" value="{{$usuarios->telefone1}}" require>

                                </div>

                                <div class="col-md-4">

                                  <label>Telefone 2:</label>
                                  <input type="text" class="form-control" id="telefone2" name="telefone2" placeholder="(00)00000-0000" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);" value="{{$usuarios->telefone2}}" require>

                                </div>

                              </div>


                              <div class="row">

                                <div class="col-md-4">

                                  <label>CEP:<span style="color: red">*</span></label>
                                  <p><input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" size="10" maxlength="9" onblur="pesquisacep(this.value);" value="{{$usuarios->CEP}}" require><span id="CEPResponse"></span></p>

                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Rua:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Rua" value="{{$usuarios->endereco}}" readonly>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label>Número:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Nº" value="{{$usuarios->numero}}" require>
                                  </div>
                                </div>
                              </div>

                              <div class="row">

                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Bairro:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="{{$usuarios->bairro}}" readonly>
                                  </div>
                                </div>

                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Cidade:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="{{$usuarios->cidade}}" readonly>
                                  </div>
                                </div>

                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Estado:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="uf" id="uf" placeholder="UF" value="{{$usuarios->UF}}" readonly>

                                  </div>
                                </div>

                              </div>
                              <div class="row">

                                <div class="col-md-4">
                                  <label>Senha:<span style="color: red">* </span><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Senha de no mínimo 8 caracteres."></i></label>
                                  <input type="password" class="form-control" name="senha" id="senha" value="" require>
                                </div>

                                <div class="col-md-4">
                                  <label>Confirmar Senha:<span style="color: red">*</span></label>
                                  <input type="password" class="form-control" name="confirmarSenha" id="confirmarSenha" require>
                                </div>

                                <div class="col-md-4">
                                  <label>Status:<span style="color: red">*</span></label>
                                  <select class="form-control" name="status" id="status" require>
                                    <option value=""></option>
                                    <option value="1" @if ($usuarios->status =="1" ) {{ 'selected' }} @endif>ATIVO</option>
                                    <option value="0" @if ($usuarios->status=="0" ) {{ 'selected' }} @endif>INATIVO</option>

                                  </select>
                                </div>

                              </div>

                              <br>
                              <h6>Perfil</h6>
                              <br>

                              <div class="row">

                                <div class="col-md-4">
                                  <label>Perfil:<span style="color: red">*</span></label>
                                  <select class="form-control" name="perfil" id="perfil" onchange="verificaPerfil(this.value)" readonly>

                                    <option value=""></option>
                                    <option value="P" @if ($usuarios->perfil=="P" ) {{ 'selected' }} @endif>Paciente</option>
                                    <option value="M" @if ($usuarios->perfil=="M" ) {{ 'selected' }} @endif>Médico</option>
                                    <option value="F" @if ($usuarios->perfil=="F" ) {{ 'selected' }} @endif>Funcionário</option>

                                  </select>
                                </div>

                                <div class="col-md-4">
                                  <label>Função:<span style="color: red">*</span></label>
                                  <select class="form-control" name="funcao" id="funcao" @if ($usuarios->funcao=="F" ) {{ '' }} @else {{ 'disabled' }} @endif>
                                    <option value=""></option>
                                    <option value="A" @if ($usuarios->funcao=="A" ) {{ 'selected' }} @endif>Atendente</option>
                                    <option value="B" @if ($usuarios->funcao=="B" ) {{ 'selected' }} @endif>Bioquimico</option>

                                  </select>
                                </div>

                                <div class="col-md-4">
                                  <label>Médico - CRM:<span style="color: red">*</span></label>
                                  <input type="text" class="form-control" name="crm" id="crm" value="{{$usuarios->crm}}" @if ($usuarios->perfil=="M" ) {{ '' }} @else {{ 'disabled' }} @endif >
                                </div>

                              </div>

                              <div class="row">

                                <div class="col-md-4">

                                </div>

                                <div class="col-md-4">
                                  <label>Convênio:<span style="color: red">*</span></label>
                                  <select class="form-control" name="convenio" id="convenio" @if ($usuarios->perfil=="P" ) {{ '' }} @else {{ 'disabled' }} @endif>
                                    @foreach($listaConvenios as $convenios)
                                    @if($usuarios->convenio_id == $convenios->id)
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

                                <div class="col-md-4">
                                  <label>Plano:<span style="color: red">*</span></label>
                                  <select class="form-control" name="plano" id="plano" @if ($usuarios->perfil=="P" ) {{ '' }} @else {{ 'disabled' }} @endif>
                                    @foreach($listaPlanos as $planos)
                                    @if($usuarios->plano_id == $planos->plano_id)
                                    <option value="{{$planos->plano_id}}" selected>{{$planos->descricao}}</option>
                                    @endif
                                    @endforeach



                                  </select>
                                </div>

                              </div>



                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                      <button type="submit" name="add" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Salvar</a>
                        </form>
                    </div>

                  </div>
                </div>
              </div>

              @endforeach

              <!-- Modal Para Visualizar Novo Usuario -->

              @foreach($listaUsuarios as $usuarios)
              <div class="modal fade" id="visualizarUsuario{{$usuarios->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">

                  <!-- Conteúdo do modal-->
                  <div class="modal-content">

                    <!-- Cabeçalho do modal -->
                    <div class="modal-header">
                      <h4 class="modal-title">Visualizar Usuário </h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Corpo do modal -->
                    <div class="modal-body">

                      <div clas="span10 offset1">
                        <div class="card">

                          <div class="card-body">
                            <form class="form-horizontal" action="cadastrarUsuarios/{usuario_id}/show" method="post">
                              <div class="row">
                                <div class="col-md-5 pr-1">
                                  <div class="form-group">
                                    <label>CPF<span style="color: red">*</span></label>
                                    <p><input type="text" id="cpf" name="cpf" class="form-control" maxlength="14" " value=" {{$usuarios->cpf}}" readonly> <span id="cpfResponse"></span></p>
                                  </div>
                                </div>
                                <div class="col-md-7 pl-1">
                                  <div class="form-group">
                                    <label for="email">E-mail:<span style="color: red">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$usuarios->email}}" readonly>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6 pr-1">
                                  <div class="form-group">
                                    <label>Nome:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="{{$usuarios->nome}}" readonly>
                                  </div>
                                </div>
                                <div class="col-md-6 pl-1">
                                  <div class="form-group">
                                    <label>Sobrenome:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome" value="{{$usuarios->sobrenome}}" readonly>
                                  </div>
                                </div>
                              </div>
                              <div class="row">

                                <div class="col-md-4">

                                  <label>Data de Nascimento:<span style="color: red">*</span></label>
                                  <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" maxlength="10" placeholder="00/00/0000" value="{{$usuarios->data_nascimento}}" readonly>

                                </div>

                                <div class="col-md-4">

                                  <label>Telefone 1:<span style="color: red">*</span></label>
                                  <input type="text" class="form-control" id="telefone1" name="telefone1" placeholder="(00)00000-0000" value="{{$usuarios->telefone1}}" readonly>

                                </div>

                                <div class="col-md-4">

                                  <label>Telefone 2:</label>
                                  <input type="text" class="form-control" id="telefone2" name="telefone2" placeholder="(00)00000-0000" value="{{$usuarios->telefone2}}" readonly>

                                </div>

                              </div>


                              <div class="row">

                                <div class="col-md-4">

                                  <label>CEP:<span style="color: red">*</span></label>
                                  <p><input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" size="10" maxlength="9" value="{{$usuarios->CEP}}" readonly><span id="CEPResponse"></span></p>

                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Rua:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Rua" value="{{$usuarios->endereco}}" readonly>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group">
                                    <label>Número:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Nº" value="{{$usuarios->numero}}" readonly>
                                  </div>
                                </div>
                              </div>

                              <div class="row">

                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Bairro:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="{{$usuarios->bairro}}" readonly>
                                  </div>
                                </div>

                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Cidade:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="{{$usuarios->cidade}}" readonly>
                                  </div>
                                </div>

                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Estado:<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="uf" id="uf" placeholder="UF" value="{{$usuarios->UF}}" readonly>

                                  </div>
                                </div>

                              </div>
                              <div class="row">

                                <div class="col-md-4">
                                  <label>Senha:<span style="color: red">* </span><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Senha de no mínimo 8 caracteres."></i></label>
                                  <input type="password" class="form-control" name="senha" id="senha" value="" require>
                                </div>

                                <div class="col-md-4">
                                  <label>Confirmar Senha:<span style="color: red">*</span></label>
                                  <input type="password" class="form-control" name="confirmarSenha" id="confirmarSenha" readonly>
                                </div>

                                <div class="col-md-4">
                                  <label>Status:<span style="color: red">*</span></label>
                                  <select class="form-control" name="status" id="status" readonly>
                                    <option value=""></option>
                                    <option value="1" @if ($usuarios->status =="1" ) {{ 'selected' }} @endif>ATIVO</option>
                                    <option value="0" @if ($usuarios->status=="0" ) {{ 'selected' }} @endif>INATIVO</option>

                                  </select>
                                </div>

                              </div>

                              <br>
                              <h6>Perfil</h6>
                              <br>

                              <div class="row">

                                <div class="col-md-4">
                                  <label>Perfil:<span style="color: red">*</span></label>
                                  <select class="form-control" name="perfil" id="perfil" readonly>

                                    <option value=""></option>
                                    <option value="P" @if ($usuarios->perfil=="P" ) {{ 'selected' }} @endif>Paciente</option>
                                    <option value="M" @if ($usuarios->perfil=="M" ) {{ 'selected' }} @endif>Médico</option>
                                    <option value="F" @if ($usuarios->perfil=="F" ) {{ 'selected' }} @endif>Funcionário</option>

                                  </select>
                                </div>

                                <div class="col-md-4">
                                  <label>Função:<span style="color: red">*</span></label>
                                  <select class="form-control" name="funcao" id="funcao" readonly>
                                    <option value=""></option>
                                    <option value="A" @if ($usuarios->funcao=="A" ) {{ 'selected' }} @endif>Atendente</option>
                                    <option value="B" @if ($usuarios->funcao=="B" ) {{ 'selected' }} @endif>Bioquimico</option>

                                  </select>
                                </div>

                                <div class="col-md-4">
                                  <label>Médico - CRM:<span style="color: red">*</span></label>
                                  <input type="text" class="form-control" name="crm" id="crm" value="{{$usuarios->crm}}" readonly>
                                </div>

                              </div>

                              <div class="row">

                                <div class="col-md-4">

                                </div>

                                <div class="col-md-4">
                                  <label>Convênio:<span style="color: red">*</span></label>
                                  <select class="form-control" name="convenio" id="convenio" readonly>
                                    @foreach($listaConvenios as $convenios)
                                    @if($usuarios->convenio_id == $convenios->id)
                                    <option value="{{$convenios->id}}" selected>{{$convenios->nome_fantasia}}</option>
                                    @endif
                                    @endforeach

                                  </select>
                                </div>

                                <div class="col-md-4">
                                  <label>Plano:<span style="color: red">*</span></label>
                                  <select class="form-control" name="plano" id="plano" readonly>
                                    @foreach($listaPlanos as $planos)
                                    @if($usuarios->plano_id == $planos->plano_id)
                                    <option value="{{$planos->plano_id}}" selected>{{$planos->descricao}}</option>
                                    @endif
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

              <!-- Modal Para Desativar um Usuario -->
              @foreach($listaUsuarios as $usuarios)
              <div class="modal fade" id="apagarUsuario{{$usuarios->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">

                  <!-- Conteúdo do modal-->
                  <div class="modal-content">

                    <!-- Cabeçalho do modal -->
                    <div class="modal-header">
                      <h4 class="modal-title">Desativar Usuário</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Corpo do modal -->
                    <div class="modal-body">

                      <div clas="span10 offset1">
                        <div class="card">

                          <div class="card-body">
                            <form class="form-horizontal" action="cadastrarUsuarios/{{$usuarios->usuario_id}}/delete" method="post">

                              @method('DELETE')

                              <input type="hidden" name="_token" value="{{csrf_token()}}">

                              <p class="text-center">Tem certeza de que deseja desativar o usuario {{$usuarios->nome}} {{$usuarios->sobrenome}}?</p>

                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                      <button type="submit" name="desativarUsuario" id="desativarEspecialidadeXMedico" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Confirmar</a>

                        </form>
                    </div>

                  </div>
                </div>
              </div>

              @endforeach

              @if ($listaUsuarios->lastPage() > 1)
              <ul class="pagination justify-content-end">
                <li class=" {{ ($listaUsuarios->currentPage() == 1) ? ' page-item disabled' : '' }}">
                  <a class="page-link" href="{{ $listaUsuarios->url(1) }}">Anterior</a>
                </li>
                @for ($i = 1; $i <= $listaUsuarios->lastPage(); $i++)
                  <li class="{{ ($listaUsuarios->currentPage() == $i) ? ' page-item active' : '' }}">
                    <a class="page-link" href="{{ $listaUsuarios->url($i) }}">{{ $i }}</a>
                  </li>
                  @endfor
                  <li class="{{ ($listaUsuarios->currentPage() == $listaUsuarios->lastPage()) ? '  page-item disabled' : '' }}">
                    <a class="page-link" href="{{ $listaUsuarios->url($listaUsuarios->currentPage()+1) }}">Proximo</a>
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
  

    @endcan
  </div>

  @if (count($errors) > 0)
  <script type="text/javascript">
    $('#addUsuario').modal('show');
  </script>
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

  <script>
    function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
    }
  </script>





  @endsection