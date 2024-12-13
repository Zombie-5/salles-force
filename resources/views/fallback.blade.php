<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>SallesForce</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .titulo {
            color: #00C0FF;
            font-size: 10vw;
            /* Responsivo */
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body class="d-flex align-items-center" style="min-height: 100vh;">

    <div class="container text-center">
        <h1 class="display-3 titulo">SallesForce</h1>
        <h2 class="display-4">Oops!</h2>
        <h4 class="display-4">Algo deu errado!</h3>

        <p class="lead">Estamos resolvendo problema no servidor. Tente novamente mais tarde.</p>
        <p>Por questões de segurança a sua sessão será encerrada</p>
        <p>Se não estava logado, por favor, faça login para continuar.</p>

        <a href="{{ route('site.login') }}" class="btn btn-primary" style="background-color: #00C0FF; border: none">Ir
            para a tela de login</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
</body>


</html>
