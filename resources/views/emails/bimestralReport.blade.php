@extends('emails.master')

@section('title', $title)

@section('content')
    <p>Olá, {{ $student->nome }}, </p>
    <p>Durante a semana de provas, protocole na secretaria do colégio o seu <b>relatório bimestral de estágio</b>.
Caso o mesmo não seja entregue, estará sujeito às penalidades vigentes no código do estagiário.
Possuindo problemas na entrega do relatório bimestral, comunique a coordenadoria do curso por email com urgência.
    </p>
@endsection
