<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SGE CTI</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #d4e7ee;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
                overflow: hidden;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #d4e7ee;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            #particles-js {
                position: absolute;
                width: 100%;
                height: 100%;
                background-color: #006991;
                background-repeat: no-repeat;
                background-size: cover;
                background-position: 50% 50%;
                opacity: 1;
            }
        </style>
    </head>
    <body>
        <div id="particles-js"></div>

        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">{{ __("Login") }}</a>

                        @if (config('adminlte.register_url', 'register'))
                            <a href="{{ route('register') }}">{{ __("Register") }}</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    SGE CTI
                </div>
            </div>
        </div>

        <script src="{{ asset('js/particles.min.js') }}" type="text/javascript"></script>

        <script type="text/javascript">
            particlesJS.load('particles-js', '{{ asset('js/particles.json') }}', function() {
                console.log('callback - particles.js config loaded');
            });
        </script>
    </body>
</html>
