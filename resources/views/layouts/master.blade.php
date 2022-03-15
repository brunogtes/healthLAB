<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <!-- Fonts and icons     -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/v4-shims.css">
    

    <!-- Styles -->
    <!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/now-ui-dashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">


    <!-- Outth -->

    <meta name="google-signin-client_id" content="227731425075-si29h86650onoqtcs37885mmlqqpms1s.apps.googleusercontent.com">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    
    <!--   Core JS Files   -->
    <!--  <script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}" defer></script>-->
    <!-- <script src="{{ asset('js/core/jquery.min.js') }}" rel="preload"></script>
  <script src="{{ asset('js/core/popper.min.js') }}" defer></script>
<script src="{{ asset('js/core/bootstrap.min.js') }}" defer></script>
 <script src="{{ asset('js/core/popper.min.js') }}" defer></script>  -->



    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="{{ asset('js/core/custom.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

   
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    




    <!-- Chart JS -->
    <!--<script src="{{ asset('js/plugins/chartjs.min.js') }}" defer></script>-->
    <!--  Notifications Plugin    -->
    <script src="{{ asset('js/plugins/bootstrap-notify.js') }}" defer></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <!--<script src="{{ asset('js/now-ui-dashboard.min.js') }}" defer></script>-->





</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="blue">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
            <div class="logo">
                <a style="text-align: center" class="simple-text logo-normal">
                    healthLAB
                </a>
            </div>
            <div class="sidebar-wrapper" id="sidebar-wrapper">
                <ul class="nav side-menu">
                @canany(['paciente', 'funcionario', 'medico', 'admin']) 
                    <li class="{{ Request::segment(1) === 'inicio' ? 'active' : null }}">
                        <a href="../inicio">
                            <i class="fas fa-home"></i>
                            <p>Inicio</p>
                        </a>
                    </li>  
                    @endcanany
                    @canany(['paciente', 'admin'])                                   
                    <li class="{{ Request::segment(1) === 'exames' ? 'active' : null }}">
                        <a href="../exames">
                            <i class="fas fa-solid fa-file-medical"></i>
                            <p>Resultado de Exames</p>
                        </a>
                    </li>    
                    @endcanany    
                    @canany(['paciente', 'funcionario', 'medico', 'admin'])            
                    <li class="{{ Request::segment(1) === 'perfil' ? 'active' : null }}">
                        <a href="../perfil">
                            <i class="fas fa-user"></i>
                            <p>Perfil</p>
                        </a>
                    </li>
                    @endcanany
                    @canany(['funcionario', 'admin'])  
                    <li class="{{ Request::segment(1) === 'agendamento' ? 'active' : null }}">
                        <a href="../agendamento">
                            <i class="far fa-calendar-alt"></i>
                            <p>Agendamento</p>
                        </a>
                    </li>
                    <li>                     
                        <a href="#pageSubCadastros" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-keyboard"></i>
                            <p>Cadastros</p>
                        </a>
                        <ul class="collapse list-unstyled" id="pageSubCadastros">
                            <li class="{{ Request::segment(1) === 'cadastroConvenios' ? 'active' : null }}">
                                <a href="../cadastroConvenios"><i class="fas fa-caret-right"></i>Convênios</a>
                            </li>
                            <li class="{{ Request::segment(1) === 'cadastroPlanos' ? 'active' : null }}">
                                <a href="../cadastroPlanos"><i class="fas fa-caret-right"></i>Planos</a>
                            </li>
                            <li class="{{ Request::segment(1) === 'cadastroExames' ? 'active' : null }}">
                                <a href="../cadastroExames"><i class="fas fa-caret-right"></i> Exames</a>
                            </li>
                            <li class="{{ Request::segment(1) === 'cadastroItensExame' ? 'active' : null }}">
                                <a href="../cadastroItensExame"><i class="fas fa-caret-right"></i>Itens de Exames</a>
                            </li>                           
                            <li class="{{ Request::segment(1) === 'cadastroExamesXPlanos' ? 'active' : null }}">
                                <a href="../cadastroExamesXPlanos"><i class="fas fa-caret-right"></i>Exames X Planos</a>
                            </li>
                            <li class="{{ Request::segment(1) === 'cadastroEspecialidades' ? 'active' : null }}">
                                <a href="../cadastroEspecialidades"><i class="fas fa-caret-right"></i>Especialidades</a>
                            </li>
                            <li class="{{ Request::segment(1) === 'cadastroEspecialidadesXMedicos' ? 'active' : null }}">
                                <a href="../cadastroEspecialidadesXMedicos"><i class="fas fa-caret-right"></i>Especialidades X Médicos</a>
                            </li>

                        </ul>
                    </li>
                    @endcanany 
                    @canany(['funcionario', 'medico', 'admin'])  
                    <li class="{{ Request::segment(1) === 'cadastroResulExames' ? 'active' : null }}">
                        <a href="../cadastroResulExames">
                            <i class="fa fa-solid fa-microscope"></i>
                            <p>Gestão de Exames</p>
                        </a>
                    </li>
                    @endcanany 
                    @canany(['medico', 'admin'])  
                    <li class="{{ Request::segment(1) === 'painelMedico' ? 'active' : null }}">
                        <a href="../painelMedico">
                            <i class="fa fa-solid fa-laptop-medical"></i>
                            <p>Painel Médico</p>
                        </a>
                    </li>
                    @endcanany 
                    @can('admin')
                    <li>
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-cog"></i>
                            <p>Configurações</p>
                        </a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li class="{{ Request::segment(1) === 'cadastrarUsuarios' ? 'active' : null }}">
                                <a href="../cadastrarUsuarios"><i class="fas fa-caret-right"></i>Cadastro de Usuários</a>
                            </li>
                            <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                                <a href="../dashboard"><i class="fas fa-caret-right"></i>Dashboard</a>
                            </li>
                            <li class="{{ Request::segment(1) === 'relatorios' ? 'active' : null }}">
                                <a href="../relatorios"><i class="fas fa-caret-right"></i>Relatórios</a>
                            </li>
                        </ul>
                    </li>
                    @endcan 

                </ul>
            </div>
        </div>
        
        <div class="main-panel" id="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-wrapper">

                        @yield('titulo')

                    </div>

                    <div class="collapse navbar-collapse justify-content-end" id="navigation">

                        <ul class="navbar-nav">


                            <li class="nav-item">
                                <a class="nav-link" href="perfil"><i title="Perfil" class="fas fa-user fa-2x"></i>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i title="Sair" class="fas fa-sign-out-alt fa-2x"></i>
                                

                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->

            @yield('panel-header')

            <div class="content">
                @yield('content')

            </div>
            <footer class="footer">
                <div class=" container-fluid ">

                    <div class="copyright" id="copyright">
                        &copy; <script>
                            document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                        </script>, Designed by <a href="https://www.linkedin.com/in/bruno-almeida-55525b55/" target="_blank">Bruno Almeida</a>.
                    </div>
                </div>
            </footer>
        </div>
    </div>



</body>

</html>