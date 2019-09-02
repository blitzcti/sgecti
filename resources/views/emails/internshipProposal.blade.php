@extends('emails.master')

@section('title', $title)

@section('content')
    <p>Olá, {{ $student->nome }}, </p>
    <p>A {{ $proposal->company->name }} tem uma nova vaga de {{ $proposal->type == 1 ? 'estágio' : 'iniciação científica' }} para você!</p>

    <span><b>Descrição da vaga/atividades: </b>{{ $proposal->description }} </span><br />
    <span><b>Requisitos: </b>{{ $proposal->requirements }} </span><br />
    <span><b>Benefícios: </b>{{ $proposal->benefits }}</span><br />

    @if($proposal->remuneration > 0)
        <span><b>Remuneração: </b>R$ {{ number_format($proposal->remuneration, 2, ',', '.') }} </span><br />
    @endif

    @if($proposal->observation != null)
        <span><b>Observações: </b>{{ $proposal->observation }} </span><br />
    @endif

    <p>Se interessou pela vaga? {{ $proposal->contact }}</p>
@endsection
