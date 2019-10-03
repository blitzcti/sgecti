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
                <dd class="col-sm-10">{{ ($proposal->type == 1) ? "Estágio padrão" : "Iniciação Científica" }}</dd>

                <dt class="col-sm-2">Remuneração</dt>
                <dd class="col-sm-10">{{ $proposal->remuneration > 0.0 ? 'R$' . number_format($proposal->remuneration, 2, ',', '.') : 'Sem' }}</dd>

                <dt class="col-sm-2">Descrição da vaga</dt>
                <dd class="col-sm-10">{{ $proposal->description }}</dd>

                <dt class="col-sm-2">Requisitos</dt>
                <dd class="col-sm-10">{{ $proposal->requirements }}</dd>

                <dt class="col-sm-2">Benefícios</dt>
                <dd class="col-sm-10">{{ $proposal->benefits }}</dd>

                <dt class="col-sm-2">Contato</dt>
                <dd class="col-sm-10">{{ $proposal->contact }}</dd>

                <dt class="col-sm-2">Data limite</dt>
                <dd class="col-sm-10">{{ $proposal->deadline->format('d/m/Y') }}</dd>

                @if($proposal->observation != null)

                    <dt class="col-sm-2">Observação</dt>
                    <dd class="col-sm-10">{{ $proposal->observation }}</dd>

                @endif
            </dl>

            @if($proposal->schedule != null)
                <hr/>
                <h3>Horários</h3>

                <dl class="row">
                    @if($proposal->schedule->mon_s != null)
                        <dt class="col-sm-2">Segunda</dt>
                        <dd class="col-sm-10">
                            {{ $proposal->schedule->mon_s }} às {{ $proposal->schedule->mon_e }}
                            @if($proposal->schedule2 != null) / {{ $proposal->schedule2->mon_s }} às {{ $proposal->schedule2->mon_e }}@endif
                        </dd>
                    @endif

                    @if($proposal->schedule->tue_s != null)
                        <dt class="col-sm-2">Terça</dt>
                        <dd class="col-sm-10">
                            {{ $proposal->schedule->tue_s }} às {{ $proposal->schedule->tue_e }}
                            @if($proposal->schedule2 != null) / {{ $proposal->schedule2->tue_s }} às {{ $proposal->schedule2->tue_e }}@endif
                        </dd>
                    @endif

                    @if($proposal->schedule->wed_s != null)
                        <dt class="col-sm-2">Quarta</dt>
                        <dd class="col-sm-10">
                            {{ $proposal->schedule->wed_s }} às {{ $proposal->schedule->wed_e }}
                            @if($proposal->schedule2 != null) / {{ $proposal->schedule2->wed_s }} às {{ $proposal->schedule2->wed_e }}@endif
                        </dd>
                    @endif

                    @if($proposal->schedule->thu_s != null)
                        <dt class="col-sm-2">Quinta</dt>
                        <dd class="col-sm-10">
                            {{ $proposal->schedule->thu_s }} às {{ $proposal->schedule->thu_e }}
                            @if($proposal->schedule2 != null) / {{ $proposal->schedule2->thu_s }} às {{ $proposal->schedule2->thu_e }}@endif
                        </dd>
                    @endif

                    @if($proposal->schedule->fri_s != null)
                        <dt class="col-sm-2">Sexta</dt>
                        <dd class="col-sm-10">
                            {{ $proposal->schedule->fri_s }} às {{ $proposal->schedule->fri_e }}
                            @if($proposal->schedule2 != null) / {{ $proposal->schedule2->fri_s }} às {{ $proposal->schedule2->fri_e }}@endif
                        </dd>
                    @endif

                    @if($proposal->schedule->sat_s != null)
                        <dt class="col-sm-2">Sábado</dt>
                        <dd class="col-sm-10">
                            {{ $proposal->schedule->sat_s }} às {{ $proposal->schedule->sat_e }}
                            @if($proposal->schedule2 != null) / {{ $proposal->schedule2->sat_s }} às {{ $proposal->schedule2->sat_e }}@endif
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
