@extends('adminlte::page')

@section('title', 'Dashboard - SGE CTI')

@section('content_header')
    <h1>Bem vindo, {{ $user->name }}.</h1>
@stop

@section('content')
    <p>Você está conectado como {{ $user->roles->pluck('friendlyName')[0] }}.</p>

    @if($courseName != null)

        <p>Atualmente, você é coordenador de {{ $courseName }}.</p>

    @endisset
@stop