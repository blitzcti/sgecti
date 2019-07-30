@extends('emails.master')

@section('title', $title)

@section('content')
    <p> Olá, {{ $student->nome }}, </p>
    <p>Temos uma nova vaga de estágio para você!</p>

    <p><b>Empresa: </b>{{ $proposal->company->name }} </p>
    <p><b>Descrição da vaga/atividades: </b>{{ $proposal->description }} </p>
    <p><b>Requisitos: </b>{{ $proposal->requirements }} </p>
    <p><b>Benefícios: </b>{{ $proposal->benefits }}</p>

    @if($proposal->remuneration > 0)
        <p><b>Remuneração: </b>R$ {{ number_format($proposal->remuneration, 2, ',', '.') }} </p>
    @endif

    <p><b>Tipo de vaga: </b>{{ $proposal->type == 1 ? 'Estágio' : '' }} </p>

    @if($proposal->observation != null)
        <p><b>Observações: </b>{{ $proposal->observation }} </p>
    @endif

    <p><b>Contato: </b>{{ $proposal->contact }} </p>
@endsection

