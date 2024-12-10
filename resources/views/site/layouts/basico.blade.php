<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>SallesForce</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/estilo_site.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .toast {
            max-width: 300px;
            /* Largura máxima */
            min-width: 100px;
            /* Largura mínima */
            /* Define altura fixa */
            border-radius: 10px;
            /* Bordas arredondadas suaves */
            padding: 0px;
            /* Espaçamento interno */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .toast .toast-body {
            font-size: 1rem;
            /* Ajusta o tamanho da fonte */
            margin: 0;
            /* Remove margens */
        }
    </style>

</head>

<body>

    <div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
        @if (session('success'))
            <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="toast-body">
                        {{ $error }}
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @yield('conteudo')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>

    <!-- Initialize Toasts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toastElList = document.querySelectorAll('.toast');
            const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl));
            toastList.forEach(toast => toast.show());
        });
    </script>
</body>

</html>
