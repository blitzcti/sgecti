@extends('adminlte::page')

@section('title', 'Detalhes da proposta de estágio - SGE CTI')

@section('content_header')
    <h1>Detalhes da proposta de estágio</h1>
@stop

@section('content')
    @include('modals.company.proposal.delete')

    <div class="box box-default">
        <div class="box-body">
            <h3>Dados da proposta</h3>

            <dl class="row">
                <dt class="col-sm-2">Tipo de estágio</dt>
                <dd class="col-sm-10">{{ ($proposal->type == \App\Models\Proposal::INTERNSHIP) ? "Estágio padrão" : "Iniciação Científica" }}</dd>

                <dt class="col-sm-2">Remuneração</dt>
                <dd class="col-sm-10">{{ $proposal->remuneration > 0.0 ? 'R$' . number_format($proposal->remuneration, 2, ',', '.') : 'Sem' }}</dd>

                <dt class="col-sm-2">Descrição da vaga</dt>
                <dd class="col-sm-10">{{ $proposal->description }}</dd>

                <dt class="col-sm-2">Requisitos</dt>
                <dd class="col-sm-10">{{ $proposal->requirements }}</dd>

                @if($proposal->benefits != null)

                    <dt class="col-sm-2">Benefícios</dt>
                    <dd class="col-sm-10">{{ $proposal->benefits }}</dd>

                @endif

                <dt class="col-sm-2">Data limite</dt>
                <dd class="col-sm-10">{{ $proposal->deadline->format('d/m/Y') }}</dd>

                @if($proposal->observation != null)

                    <dt class="col-sm-2">Observação</dt>
                    <dd class="col-sm-10">{{ $proposal->observation }}</dd>

                @endif
            </dl>

            <hr>
            <h3>Contato</h3>

            <dl class="row">
                <dt class="col-sm-2">Email</dt>
                <dd class="col-sm-10">{{ $proposal->email }}</dd>

                <dt class="col-sm-2">Assunto do email</dt>
                <dd class="col-sm-10">{{ $proposal->subject }}</dd>

                @if($proposal->phone != null)

                    <dt class="col-sm-2">Telefone</dt>
                    <dd class="col-sm-10">{{ $proposal->formatted_phone }}</dd>

                @endif

                @if($proposal->other != null)

                    <dt class="col-sm-2">Outra forma</dt>
                    <dd class="col-sm-10">{{ $proposal->other }}</dd>

                @endif
            </dl>

            <a href="mailto:{{ $proposal->email }}?subject={{ str_replace('+', '%20', urlencode($proposal->subject)) }}"
               class="btn btn-default"><i class="fa fa-send"></i> Enviar email</a>

            @if($proposal->schedule != null)
                <hr/>
                <h3>Horários</h3>

                <dl class="row">
                    @if($proposal->schedule->mon_s != null)
                        <dt class="col-sm-2">Segunda</dt>
                        <dd class="col-sm-10">
                            {{ substr($proposal->schedule->mon_s, 0, 5) }}
                            às {{ substr($proposal->schedule->mon_e, 0, 5) }}
                            @if($proposal->schedule2 != null && $proposal->schedule2->mon_s != null)
                                / {{ substr($proposal->schedule2->mon_s, 0, 5) }}
                                às {{ substr($proposal->schedule2->mon_e, 0, 5) }}
                            @endif
                        </dd>
                    @endif

                    @if($proposal->schedule->tue_s != null)
                        <dt class="col-sm-2">Terça</dt>
                        <dd class="col-sm-10">
                            {{ substr($proposal->schedule->tue_s, 0, 5) }}
                            às {{ substr($proposal->schedule->tue_e, 0, 5) }}
                            @if($proposal->schedule2 != null && $proposal->schedule2->tue_s != null)
                                / {{ substr($proposal->schedule2->tue_s, 0, 5) }}
                                às {{ substr($proposal->schedule2->tue_e, 0, 5) }}
                            @endif
                        </dd>
                    @endif

                    @if($proposal->schedule->wed_s != null)
                        <dt class="col-sm-2">Quarta</dt>
                        <dd class="col-sm-10">
                            {{ substr($proposal->schedule->wed_s, 0, 5) }}
                            às {{ substr($proposal->schedule->wed_e, 0, 5) }}
                            @if($proposal->schedule2 != null && $proposal->schedule2->wed_s != null)
                                / {{ substr($proposal->schedule2->wed_s, 0, 5) }}
                                às {{ substr($proposal->schedule2->wed_e, 0, 5) }}
                            @endif
                        </dd>
                    @endif

                    @if($proposal->schedule->thu_s != null)
                        <dt class="col-sm-2">Quinta</dt>
                        <dd class="col-sm-10">
                            {{ substr($proposal->schedule->thu_s, 0, 5) }}
                            às {{ substr($proposal->schedule->thu_e, 0, 5) }}
                            @if($proposal->schedule2 != null && $proposal->schedule2->thu_s != null)
                                / {{ substr($proposal->schedule2->thu_s, 0, 5) }}
                                às {{ substr($proposal->schedule2->thu_e, 0, 5) }}
                            @endif
                        </dd>
                    @endif

                    @if($proposal->schedule->fri_s != null)
                        <dt class="col-sm-2">Sexta</dt>
                        <dd class="col-sm-10">
                            {{ substr($proposal->schedule->fri_s, 0, 5) }}
                            às {{ substr($proposal->schedule->fri_e, 0, 5) }}
                            @if($proposal->schedule2 != null && $proposal->schedule2->fri_s != null)
                                / {{ substr($proposal->schedule2->fri_s, 0, 5) }}
                                às {{ substr($proposal->schedule2->fri_e, 0, 5) }}
                            @endif
                        </dd>
                    @endif

                    @if($proposal->schedule->sat_s != null)
                        <dt class="col-sm-2">Sábado</dt>
                        <dd class="col-sm-10">
                            {{ substr($proposal->schedule->sat_s, 0, 5) }}
                            às {{ substr($proposal->schedule->sat_e, 0, 5) }}
                            @if($proposal->schedule2 != null && $proposal->schedule2->sat_s != null)
                                / {{ substr($proposal->schedule2->sat_s, 0, 5) }}
                                às {{ substr($proposal->schedule2->sat_e, 0, 5) }}
                            @endif
                        </dd>
                    @endif
                </dl>
            @endif

            <hr/>
            <h3>Cursos abrangentes</h3>

            <dl class="row">
                @foreach($proposal->courses as $course)

                    <dt class="col-sm-12">{{ $course->name }}</dt>
                    <dd class="col-sm-0"></dd>

                @endforeach
            </dl>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('js')
    <script type="text/javascript">

    </script>
@endsection
