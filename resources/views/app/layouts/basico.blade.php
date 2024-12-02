<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>SallesForce</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/estilo_basico.css') }}">
</head>

<body>
    @include('app.layouts._partials.topo')
    @yield('conteudo')
    @include('app.layouts._partials.bottom')
</body>
</html>
