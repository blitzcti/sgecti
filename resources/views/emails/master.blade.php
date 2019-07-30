<html lang="{{ config('app.locale') }}">
<head>
    <title>@yield('title')</title>

    <style type="text/css">
        #contactDiv {
            left: 0;
            font-size: 10pt;
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
        <p>Prof. {{ $user->name }}</p>

        @if($user->isCoordinator())
            <p>Coordenador de {{ $user->coordinator_courses_name }}</p>
        @endif

        <p>@if($user->phone != null){{ $user->phone_formated }} | @endif{{ $user->email }}</p>
    </div>
</div>
</body>
</html>
