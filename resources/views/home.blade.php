@extends('adminlte::page')

@section('title', 'Dashboard - SGE CTI')

@section('content_header')
    <h1>Bem vindo, {{ auth()->user()->name }}.</h1>
@stop

@section('content')
    <p>You are logged in!</p>
@stop
