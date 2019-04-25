@extends('adminlte::login')

@section('css')
    <style type="text/css">
        .login-page {
            overflow: hidden;
            background-image: url('{{ asset('/img/login.jpg') }}');
            background-position: center;
            background-size: cover;
        }
    </style>
@endsection
