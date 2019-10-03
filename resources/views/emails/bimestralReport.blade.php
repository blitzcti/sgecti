@extends('emails.master')

@section('title', $title)

@section('content')
    <p>Olá, {{ $student->nome }}, </p>
    <p>Este é apenas um lembrete para que, durante a semana de provas, você protocole na secretaria do colégio o seu <b>relatório bimestral de estágio</b>.
Caso o mesmo não seja entregue, estará sujeito às penalidades vigentes no código do estagiário.
    </p>

    <p>Possuindo problemas na entrega do relatório bimestral, comunique a coordenadoria do curso por email com urgência.</p>

    <p>Desconsidere essa mensagem caso já tenha protocolado seu relatório bimestral.</p>
@endsection
