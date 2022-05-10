<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório - Lista de Planos de Saúde</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .tabela th,
        .tabela td {
            border: thin solid black;
            padding: 8px;

        }

        .tabela th {
            background-color: #007FAA;
            color: whitesmoke;
        }

        img {
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;

        }

     
    </style>
</head>

<body>


    <img src="img/logo.png" height="10%" width="20%" style="margin-left:auto; margin-right:auto; width:auto;  display: block;">



    <h1 style="text-align: center;">LISTA DE PLANOS DE SAÚDE</h1>


    <table>
        <thead class=" text-primary">

            <th scope="col">Descrição</th>  
                   
            <th scope="col">Status</th>

        </thead>
        <tbody>

            @foreach($plano as $planos)
            <tr>

                <th>{{$planos->descricao}}</th>               
                <th>{{$status = ($planos->status == 0) ? "INATIVO"  : "ATIVO";}}</th>

            </tr>
            @endforeach

        </tbody>


    </table>

    <footer>
        <p style=" text-align: right;">© 2022, healthLAB</p>
    </footer>


</body>

</html>