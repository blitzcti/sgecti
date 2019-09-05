<html lang="pt-br">
<head>
    <title>@yield('title') - SGE</title>

    @yield('css')
    @stack('css')

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.pdf.min.css') }}">

    <style type="text/css">
        body, h1, h2, h3, h4, h5, h6 {
            font-family: sans-serif;
        }

        @page {
            margin: 4cm 2cm 1.5cm 2cm;
        }

        header {
            position: fixed;
            top: -85px;
        }

        footer {
            position: fixed;
            bottom: 25px;
        }

        footer .page-number:after {
            content: counter(page);
        }

        .page-break {
            page-break-after: always;
        }
    </style>

    <style type="text/css">
        .header-content {
            display: inline;
        }

        .header-content p {
            margin: 1px;
        }
    </style>

    <style type="text/css">

    </style>
</head>
<body>

<header>
    <div>
        <div>
            <div class="header-content" style="text-align: center">
                <p><b>UNIVERSIDADE ESTADUAL PAULISTA "JÚLIO DE MESQUITA FILHO"</b></p>
                <p><b>CÂMPUS DE BAURU</b></p>
                <p>COLÉGIO TÉCNICO INDUSTRIAL “PROF. ISAAC PORTAL ROLDÁN”</p>
            </div>
        </div>
    </div>
</header>

<footer>
    <div>
        <div class="pull-right page-number"></div>
    </div>
</footer>

<main>
    <div>

        @yield('content')

    </div>
</main>

</body>
</html>
