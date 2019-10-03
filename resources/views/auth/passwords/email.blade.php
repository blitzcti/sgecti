@extends('adminlte::passwords.email')

@section('css')
    <style type="text/css">
        .login-page {
            overflow: hidden;
            background-image: url('{{ asset('/img/email.jpg') }}');
            background-position: center;
            background-size: cover;
        }
    </style>
@endsection
