@extends('emails.master')

@section('title', $title)

@section('content')
    <p>Olá, {{ $student->nome }}, </p>
    <p>{{ $messageBody }}</p>
@endsection
