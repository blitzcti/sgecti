@extends('emails.master')

@section('title', $title)

@section('content')
    <p>Olá, {{ $student->nome }}, </p>
    <p>A {{ $proposal->company->name }} tem uma nova vaga de {{ $proposal->type == \App\Models\Proposal::INTERNSHIP ? 'estágio' : 'iniciação científica' }} para você!</p>

    <span><b>Descrição da vaga/atividades: </b>{{ $proposal->description }} </span><br />
    <span><b>Requisitos: </b>{{ $proposal->requirements }} </span><br />

    @if($proposal->benefits != null)
        <span><b>Benefícios: </b>{{ $proposal->benefits }}</span><br />
    @endif

    @if($proposal->remuneration > 0)
        <span><b>Remuneração: </b>R$ {{ number_format($proposal->remuneration, 2, ',', '.') }} </span><br />
    @endif

    @if($proposal->observation != null)
        <span><b>Observações: </b>{{ $proposal->observation }} </span><br />
    @endif

    @if($proposal->schedule != null)
        <span><b>Horários: </b></span><br />

        @if($proposal->schedule->mon_s != null)
            <span>&nbsp;<b>Segunda: </b>
                {{ $proposal->schedule->mon_s }} às {{ $proposal->schedule->mon_e }}
                @if($proposal->schedule2 != null) / {{ $proposal->schedule2->mon_s }} às {{ $proposal->schedule2->mon_e }} @endif
            </span><br />
        @endif

        @if($proposal->schedule->mon_s != null)
            <span>&nbsp;<b>Terça: </b>
                {{ $proposal->schedule->tue_s }} às {{ $proposal->schedule->tue_e }}
                @if($proposal->schedule2 != null) / {{ $proposal->schedule2->tue_s }} às {{ $proposal->schedule2->tue_e }} @endif
            </span><br />
        @endif

        @if($proposal->schedule->mon_s != null)
            <span>&nbsp;<b>Quarta: </b>
                {{ $proposal->schedule->wed_s }} às {{ $proposal->schedule->wed_e }}
                @if($proposal->schedule2 != null) / {{ $proposal->schedule2->wed_s }} às {{ $proposal->schedule2->wed_e }} @endif
            </span><br />
        @endif

        @if($proposal->schedule->mon_s != null)
            <span>&nbsp;<b>Quinta: </b>
                {{ $proposal->schedule->thu_s }} às {{ $proposal->schedule->thu_e }}
                @if($proposal->schedule2 != null) / {{ $proposal->schedule2->thu_s }} às {{ $proposal->schedule2->thu_e }} @endif
            </span><br />
        @endif

        @if($proposal->schedule->mon_s != null)
            <span>&nbsp;<b>Sexta: </b>
                {{ $proposal->schedule->fri_s }} às {{ $proposal->schedule->fri_e }}
                @if($proposal->schedule2 != null) / {{ $proposal->schedule2->fri_s }} às {{ $proposal->schedule2->fri_e }} @endif
            </span><br />
        @endif

        @if($proposal->schedule->mon_s != null)
            <span>&nbsp;<b>Sábado: </b>
                {{ $proposal->schedule->sat_s }} às {{ $proposal->schedule->sat_e }}
                @if($proposal->schedule2 != null) / {{ $proposal->schedule2->sat_s }} às {{ $proposal->schedule2->sat_e }} @endif
            </span><br />
        @endif
    @endif

    <p>Se interessou pela vaga? {{ $proposal->contact }}</p>
@endsection
