<html lang="{{ config('app.locale') }}">
<head>
    <title>@yield('title')</title>

    <style type="text/css">
        body {
            font-family: sans-serif;
            font-size: 12pt;
        }

        #contact {
            left: 0;
        }

        #contact p {
            margin: 0;
        }
    </style>
</head>
<body>
@yield('content')

<div id="contactDiv">
    <p>Atenciosamente,</p>
    <div id="contact">
        <span>Prof. {{ $user->name }}</span><br />

        @if($user->isCoordinator())
            <span>Coordenador de {{ $user->coordinator_courses_name }}</span><br />
        @endif

        <span>@if($user->phone != null){{ $user->phone_formated }} | @endif{{ $user->email }}</span><br /><br />
    </div>
</div>
</body>
</html>
