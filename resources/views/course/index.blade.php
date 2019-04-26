@extends('adminlte::page')

@section('title', 'Cursos - SGE CTI')

@section('content_header')
    <h1>Curso</h1>
@stop

@section('content')
    @if (isset($saved))
        @if ($saved)
            <p>Salvo.</p>
        @else
            <p>Erro ao salvar.</p>
        @endif
    @endif

    <p>You are logged in!</p>
@stop
