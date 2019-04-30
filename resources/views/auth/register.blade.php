@extends('adminlte::register')

@section('css')
    <style type="text/css">
        .register-page {
            overflow: hidden;
            background-image: url('{{ asset('/img/register.jpg') }}');
            background-position: center;
            background-size: cover;
        }
    </style>
@endsection
