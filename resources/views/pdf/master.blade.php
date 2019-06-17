<html lang="pt-br">
<head>
    <title>@yield('title') - SGE</title>

    @yield('css')
    @stack('css')

    <style type="text/css">
        body {
            font-family: sans-serif;
        }

        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -60px;
        }

        footer {
            position: fixed;
            bottom: -60px;
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
        <div class="header-content" style="float: left">
            <img src="{{ asset('img/cti.png') }}" style="width: 3.39cm" alt="">
        </div>

        <div class="header-content" style="float: right">
            <img src="{{ asset('img/unesp.png') }}" style="width: 5.02cm" alt="">
        </div>

        <div>
            <div class="header-content" style="text-align: center">
                <p><b>UNIVERSIDADE ESTADUAL PAULISTA</b></p>
                <p>COLÉGIO TÉCNICO INDUSTRIAL</p>
                <p>“PROF. ISAAC PORTAL ROLDÁN”</p>
            </div>
        </div>
    </div>
</header>

<footer>
    <div>

    </div>
</footer>

<main>
    <div>

        @yield('content')

    </div>
</main>

</body>
</html>