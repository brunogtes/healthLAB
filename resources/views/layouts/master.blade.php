<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- CSS Files -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link href="../css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>


    <script src="../js/core/popper.min.js"></script>
    <script src="../js/core/bootstrap.min.js"></script>
    <script src="../js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="../js/core/custom.js"></script>
    <script src="https://js.pusher.com/4.0/pusher.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-notifications.min.css">

    <script>
        $(document).ready(function() {

            var down = false;

            $('#bell').click(function(e) {

                var color = $(this).text();
                if (down) {

                    $('#box').css('height', '0px');
                    $('#box').css('opacity', '0');
                    down = false;
                } else {

                    $('#box').css('height', 'auto');
                    $('#box').css('opacity', '1');
                    down = true;

                }

            });

        });
    </script>



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
                                <a href="../cadastroConvenios"><i class="fas fa-caret-right"></i>Conv??nios</a>
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
                                <a href="../cadastroEspecialidadesXMedicos"><i class="fas fa-caret-right"></i>Especialidades X M??dicos</a>
                            </li>

                        </ul>
                    </li>
                    @endcanany
                    @canany(['funcionario', 'medico', 'admin'])
                    <li class="{{ Request::segment(1) === 'cadastroResulExames' ? 'active' : null }}">
                        <a href="../cadastroResulExames">
                            <i class="fa fa-solid fa-microscope"></i>
                            <p>Gest??o de Exames</p>
                        </a>
                    </li>
                    @endcanany
                    @canany(['medico', 'admin'])
                    <li class="{{ Request::segment(1) === 'painelMedico' ? 'active' : null }}">
                        <a href="../painelMedico">
                            <i class="fa fa-solid fa-laptop-medical"></i>
                            <p>Painel M??dico</p>
                        </a>
                    </li>
                    @endcanany
                    @can('admin')
                    <li>
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-cog"></i>
                            <p>Configura????es</p>
                        </a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li class="{{ Request::segment(1) === 'cadastrarUsuarios' ? 'active' : null }}">
                                <a href="../cadastrarUsuarios"><i class="fas fa-caret-right"></i>Cadastro de Usu??rios</a>
                            </li>
                            <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                                <a href="../dashboard"><i class="fas fa-caret-right"></i>Dashboard</a>
                            </li>
                            <li class="{{ Request::segment(1) === 'relatorios' ? 'active' : null }}">
                                <a href="../relatorios"><i class="fas fa-caret-right"></i>Relat??rios</a>
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
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>

                        @yield('titulo')

                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>


                    <div class="collapse navbar-collapse justify-content-end" id="navigation">


                        <ul class="nav navbar-nav">
                        @canany(['funcionario', 'admin'])
                            <li class="nav-item dropdown-notifications">
                                <a class="nav-link" id="bell"><i title="Notifica????es" class="fas fa-bell fa-2x" id="totalNotificacoes"></i>

                                    <div class="notifications" id="box">
                                        <h2>Notifica????es</h2>
                                        <div class="notifications_itens"></div>

                                    </div>
                                    <p>
                                        <span class="d-lg-none d-md-block">Notifica????es</span>
                                    </p>
                                </a>
                            </li>
                            @endcan
                            <li class="nav-item">
                                <a class="nav-link" href="perfil"><i title="Perfil" class="fas fa-user fa-2x"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block"> Perfil</span>
                                    </p>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i title="Sair" class="fas fa-sign-out-alt fa-2x"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block"> Sair</span>
                                    </p>


                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </nav>
            <script>
                $(document).ready(function() {

                    $.ajax({
                        type: 'GET',
                        url: '/notificacao',
                        dataType: 'json',
                        success: function(data) {

                            // alert("sucesso");

                        },
                        error: function() {
                            // alert("erro" );
                        }

                    })

                });
            </script>

            <script type="text/javascript">
                var notificationsWrapper = $('.dropdown-notifications');
                var notifications = notificationsWrapper.find('div.notifications_itens');

                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;

                var pusher = new Pusher('deb72aa236b633d47afc', {
                    cluster: 'mt1',
                    namespace: false,
                    encrypted: true
                });

                // Subscribe to the channel we specified in our Laravel Event
                var channel = pusher.subscribe('notification');

                channel.bind('pusher:subscription_succeeded', function(members) {
                    // alert('successfully subscribed!');
                });

                // Bind a function to a Event (the full Laravel class)
                channel.bind('notification-event', function(message) {

                    var existingNotifications = notifications.html();
                    var newNotificationHtml = `
       
          <div class="notifications-item" id="boxItens"> <img src="https://cdn.iconscout.com/icon/free/png-256/attention-3-83556.png" alt="img">
                                            <div class="text">
                                                <h4>Atividade Pendente</h4>
                                                <p>` + message + `</p>
                                            </div>
                                        </div>       
        `;
                    notifications.html(newNotificationHtml + existingNotifications);

                    var total = $("#boxItens > div").length;
                    document.getElementById("totalNotificacoes").innerHTML = '&nbsp; ' + total;

                });
            </script>



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
    <!--   Core JS Files   -->


    <!-- Chart JS -->
    <script src="../js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center: parallax effects -->
    <script src="../js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
    <script src="../js/core/demo.js"></script>
    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            demo.initDashboardPageCharts();

        });
    </script>




</body>

</html>