<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" />

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">


    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="227731425075-si29h86650onoqtcs37885mmlqqpms1s.apps.googleusercontent.com">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <title>healthLAB</title>

</head>

<body>

    <div id="login-container">
        <h1>Login</h1>


        @if ($message = Session::get('msg'))
        <br>
        <p id='msg'>{{ $message }}</p>

        @endif


        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input id="email" type="email" placeholder="Digite seu e-mail" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <input id="password" type="password" placeholder="Digite sua senha" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <input type="submit">

            <!-- @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">
                Esqueceu a senha?
            </a>
            @endif -->


        </form>
        <div id="social-container">
            <p>Ou entre pelas suas redes sociais</p>

            <!-- Facebook -->
            <a href="{{ url('login/facebook') }}">
                <i class="fa fa-facebook-f"></i>
            </a>



            <!-- Google -->
            <a href="{{ url('auth/google') }}">
                <i class="fa fa-google"></i>
            </a>

        </div>
        <div id="register-container">
            <p>Ainda não tem sua conta?</p>
            <a href="cadastro">Registrar</a>
        </div>

    </div>


    <ul class="bg-bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>


</body>

</html>