@extends('emails.master')

@section('title', $title)

@section('content')
    <p>Olá, {{ $student->nome }}, </p>
    <p>A {{ $proposal->company->name }} tem uma nova vaga
        de {{ $proposal->type == \App\Models\Proposal::INTERNSHIP ? 'estágio' : 'iniciação científica' }} para você!</p>

    <span><b>Descrição da vaga/atividades: </b>{{ $proposal->description }} </span><br/>
    <span><b>Requisitos: </b>{{ $proposal->requirements }} </span><br/>

    @if($proposal->benefits != null)
        <span><b>Benefícios: </b>{{ $proposal->benefits }}</span><br/>
    @endif

    @if($proposal->remuneration > 0)
        <span><b>Remuneração: </b>R$ {{ number_format($proposal->remuneration, 2, ',', '.') }} </span><br/>
    @endif

    @if($proposal->observation != null)
        <span><b>Observações: </b>{{ $proposal->observation }} </span><br/>
    @endif

    @if($proposal->schedule != null)
        <span><b>Horários: </b></span><br/>

        @if($proposal->schedule->mon_s != null)
            <span>&nbsp;&nbsp;<b>Segunda: </b>
                {{ substr($proposal->schedule->mon_s, 0, 5) }} às {{ substr($proposal->schedule->mon_e, 0, 5) }}
                @if($proposal->schedule2 != null && $proposal->schedule2->mon_s != null)
                    / {{ substr($proposal->schedule2->mon_s, 0, 5) }} às {{ substr($proposal->schedule2->mon_e, 0, 5) }}
                @endif
            </span><br/>
        @endif

        @if($proposal->schedule->tue_s != null)
            <span>&nbsp;&nbsp;<b>Terça: </b>
                {{ substr($proposal->schedule->tue_s, 0, 5) }} às {{ substr($proposal->schedule->tue_e, 0, 5) }}
                @if($proposal->schedule2 != null && $proposal->schedule2->tue_s != null)
                    / {{ substr($proposal->schedule2->tue_s, 0, 5) }} às {{ substr($proposal->schedule2->tue_e, 0, 5) }}
                @endif
            </span><br/>
        @endif

        @if($proposal->schedule->wed_s != null)
            <span>&nbsp;&nbsp;<b>Quarta: </b>
                {{ substr($proposal->schedule->wed_s, 0, 5) }} às {{ substr($proposal->schedule->wed_e, 0, 5) }}
                @if($proposal->schedule2 != null && $proposal->schedule2->wed_s != null)
                    / {{ substr($proposal->schedule2->wed_s, 0, 5) }} às {{ substr($proposal->schedule2->wed_e, 0, 5) }}
                @endif
            </span><br/>
        @endif

        @if($proposal->schedule->thu_s != null)
            <span>&nbsp;&nbsp;<b>Quinta: </b>
                {{ substr($proposal->schedule->thu_s, 0, 5) }} às {{ substr($proposal->schedule->thu_e, 0, 5) }}
                @if($proposal->schedule2 != null && $proposal->schedule2->thu_s != null)
                    / {{ substr($proposal->schedule2->thu_s, 0, 5) }} às {{ substr($proposal->schedule2->thu_e, 0, 5) }}
                @endif
            </span><br/>
        @endif

        @if($proposal->schedule->fri_s != null)
            <span>&nbsp;&nbsp;<b>Sexta: </b>
                {{ substr($proposal->schedule->fri_s, 0, 5) }} às {{ substr($proposal->schedule->fri_e, 0, 5) }}
                @if($proposal->schedule2 != null && $proposal->schedule2->fri_s != null)
                    / {{ substr($proposal->schedule2->fri_s, 0, 5) }} às {{ substr($proposal->schedule2->fri_e, 0, 5) }}
                @endif
            </span><br/>
        @endif

        @if($proposal->schedule->sat_s != null)
            <span>&nbsp;&nbsp;<b>Sábado: </b>
                {{ substr($proposal->schedule->sat_s, 0, 5) }} às {{ substr($proposal->schedule->sat_e, 0, 5) }}
                @if($proposal->schedule2 != null && $proposal->schedule2->sat_s != null)
                    / {{ substr($proposal->schedule2->sat_s, 0, 5) }} às {{ substr($proposal->schedule2->sat_e, 0, 5) }}
                @endif
            </span><br/>
        @endif
    @endif

    <p>
        Se interessou pela vaga? Envie um email para <b>{{ $proposal->email }}</b> com o assunto
        <b>{{ $proposal->subject }}</b> até dia {{ $proposal->deadline->format("d/m/Y") }}<!--
        -->@if($proposal->phone != null), ou via telefone para {{ $proposal->formatted_phone }}@endif<!--
        -->@if($proposal->other != null) ou {{ $proposal->other }}@endif.
    </p>
@endsection
