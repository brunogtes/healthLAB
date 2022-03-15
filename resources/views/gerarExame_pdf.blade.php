<!DOCTYPE html>
<html>
<meta charset="utf-8" />

<head>
    <title>Resultado do Exame</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" />
</head>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 12px;
    }


    #logo {
        float: left;
        min-height: 150px;
        width: 250px;

    }

    #cabecalho {
        min-height: 150px;
        margin-top: 55px;

    }

    #conteudo {
        min-height: 300px;
        margin-top: auto;
        width: 100%;

    }

    #rodape {
        height: 50px;

    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .styled-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        font-family: sans-serif;
        min-width: 400px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }

    .styled-table thead tr {
        background-color: #009879;
        color: #ffffff;
        text-align: center;
    }

    .styled-table th,
    .styled-table td {
        padding: 12px 15px;
    }

    .styled-table tbody tr {
        border-bottom: 1px solid #dddddd;
        text-align: center;
    }


    .styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .styled-table tbody tr:last-of-type {
        border-bottom: 2px solid black;
    }

    .styled-table tbody tr.active-row {
        font-weight: bold;
        color: #009879;
    }



    ul#infoPacientes li {
        display: inline;
        list-style-type: none;
        font-size: 14px;
        position: relative;
        text-transform: uppercase;
    }

    ul#infoExame li {
        display: inline;
        list-style-type: none;
        font-size: 12px;
        position: relative;
        text-transform: uppercase;
        width: 100%;
    }
</style>

<body>
    <div id="logo">
        <img src="img/logo.png" height="20%" width="30%" style=" text-align: center; margin-left:auto; margin-right:auto; width:auto;">

    </div>
    <div id="cabecalho">
        @foreach($exame as $resultadoExame)
        <ul id="infoPacientes">

            @foreach($listaUsuarios as $usuarios)
            @if($resultadoExame->paciente_id == $usuarios->id)
            <li><b>NOME:</b> {{$usuarios->nome}} {{$usuarios->sobrenome}}<br></li>
            @endif
            @endforeach

            @foreach($listaUsuarios as $usuarios)
            @if($resultadoExame->paciente_id == $usuarios->id)
            <li><b>DATA DE NASCIMENTO:</b> {{$usuarios->data_nascimento}}<br></li>
            @endif
            @endforeach

            @foreach($listaUsuarios as $usuarios)
            @if($resultadoExame->paciente_id == $usuarios->id)
            <li><b>CPF:</b>{{$usuarios->cpf}}<br></li>
            @endif
            @endforeach

            @foreach($listaUsuarios as $usuarios)
            @if($resultadoExame->paciente_id == $usuarios->id)
            <li><b>ENDEREÇO:</b> {{$usuarios->endereco}}, {{$usuarios->numero}} - {{$usuarios->bairro}}, {{$usuarios->cidade}} - {{$usuarios->UF}}, {{$usuarios->CEP}} </li>
            @endif
            @endforeach
        </ul>
        @endforeach
    </div>

    <div id="conteudo">

        <hr>

        <h3 style="text-align: left;">Dados do Exame</h3>

        @foreach($exame as $resultadoExame)
        <ul id="infoExame">

            @foreach($listaExames as $exames)
            @if($resultadoExame->exame_id == $exames->id)
            <li><b>NOME DO EXAME:</b> {{$exames->descricao}} &nbsp;</li>
            @endif
            @endforeach

            <li><b>DATA DA COLETA:</b> {{ date( 'd/m/Y' , strtotime($resultadoExame->data_coleta_exame))}}&nbsp;</li>

            <li><b>BIOQUIMICO:</b> {{$resultadoExame->bioquimico_resultado}}&nbsp;</li>


        </ul>

        @endforeach
        <br>

        <hr>


        <h3 style="text-align: left;">Resultado do Exame</h3>


        <table class="styled-table">
            <thead class=" text-primary">

                <th scope="col">Item</th>
                <th scope="col">Valor Minimo</th>
                <th scope="col">Valor Máximo</th>
                <th scope="col">Resultado</th>

            </thead>
            <tbody>


                @foreach($itensResultadoExame as $itensdoExame)
                @if($itensdoExame->id_pedido_medico == $resultadoExame->resultado_exame_id ) <tr>
                    <th>{{$itensdoExame->descricao_item}}</th>

                    @foreach($itensExames as $itensPrincipal)
                    @if($itensdoExame->id_item_exame == $itensPrincipal->item_exame_id)
                    <td>{{$itensPrincipal->valor_minimo}}</td>
                    @endif
                    @endforeach

                    @foreach($itensExames as $itensPrincipal)
                    @if($itensdoExame->id_item_exame == $itensPrincipal->item_exame_id)
                    <td>{{$itensPrincipal->valor_maximo}}</td>
                    @endif
                    @endforeach


                    <td>{{$itensdoExame->valor}}</td>

                </tr>

                @endif
                @endforeach
            </tbody>

        </table>

    </div>
    <div id="rodape">
        <p style=" text-align: right;">
        <footer>
            <p style=" text-align: right;">© 2022, healthLAB</p>
        </footer>
    </div>
</body>

</html>