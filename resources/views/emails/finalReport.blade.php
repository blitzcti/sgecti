@extends('emails.master')

@section('title', $title)

@section('content')
    <p>Atenção, {{ $student->nome }}, </p>
    <p>O seu estágio acabou de ser finalizado, portanto você precisa protocolar na secretaria seu <b>relatório final de estágio</b>.</p>

    <p>Você possui um prazo de 20 dias para fazer isso. Fique atento ao prazo!</p>
@endsection
