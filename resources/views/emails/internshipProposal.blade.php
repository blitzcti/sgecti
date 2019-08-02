@extends('emails.master')

@section('title', $title)

@section('content')
    <p> Olá, {{ $student->nome }}, </p>
    <p>A {{ $proposal->company->name }} uma nova vaga de {{ $proposal->type == 1 ? 'estágio' : 'emprego' }} para você!</p>

    <p><b>Descrição da vaga/atividades: </b>{{ $proposal->description }} </p>
    <p><b>Requisitos: </b>{{ $proposal->requirements }} </p>
    <p><b>Benefícios: </b>{{ $proposal->benefits }}</p>

    @if($proposal->remuneration > 0)
        <p><b>Remuneração: </b>R$ {{ number_format($proposal->remuneration, 2, ',', '.') }} </p>
    @endif

    @if($proposal->observation != null)
        <p><b>Observações: </b>{{ $proposal->observation }} </p>
    @endif

    <p>Se interessou pela vaga? {{ $proposal->contact }}</p>
@endsection
