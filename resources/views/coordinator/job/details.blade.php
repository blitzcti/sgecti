@extends('adminlte::page')

@section('title', 'Detalhes do trabalho')

@section('content_header')
    <h1>Detalhes do trabalho</h1>
@stop

@section('content')
    @include('modals.coordinator.job.cancel')
    @include('modals.coordinator.job.reactivate')

    <div class="box box-default">
        <div class="box-body">
            <div class="btn-group" style="display: inline-flex; margin: 0">
                <a href="{{ route('coordenador.trabalho.editar', ['id' => $job->id]) }}"
                   class="btn btn-primary">Editar trabalho</a>

                @if($job->state->id == \App\Models\State::FINISHED)
                    <a href="#"
                       onclick="jobId('{{ $job->id }}'); studentName('{{ $job->student->nome }}'); return false;"
                       data-toggle="modal" class="btn btn-danger" data-target="#jobCancelModal">Cancelar</a>
                @elseif($job->state->id == \App\Models\State::CANCELED && $job->student->job == null)
                    <a href="#"
                       onclick="reactivateJobId('{{ $job->id }}'); reactivateStudentName('{{ $job->student->nome }}'); return false;"
                       data-toggle="modal" class="btn btn-default" data-target="#jobReactivateModal">Reativar</a>
                @endif
            </div>

            <h3>Dados do aluno</h3>

            <dl class="row">
                <dt class="col-sm-2">RA</dt>
                <dd class="col-sm-10">{{ $job->student->matricula }}</dd>

                <dt class="col-sm-2">Nome</dt>
                <dd class="col-sm-10">{{ $job->student->nome }}</dd>

                <dt class="col-sm-2">Curso</dt>
                <dd class="col-sm-10">{{ $job->student->course->name }}</dd>

                <dt class="col-sm-2">Turma</dt>
                <dd class="col-sm-10">{{ $job->student->turma }} ({{ $job->student->turma_ano }})</dd>

                <dt class="col-sm-2">Ano de matrícula</dt>
                <dd class="col-sm-10">{{ $job->student->year }}</dd>

                <dt class="col-sm-2">Email</dt>
                <dd class="col-sm-10">{{ $job->student->email }}</dd>

                <dt class="col-sm-2">Email institucional</dt>
                <dd class="col-sm-10">{{ $job->student->email2 }}</dd>
            </dl>

            <hr/>
            <h3>Dados do trabalho</h3>

            <dl class="row">
                <dt class="col-sm-2">CPF / CNPJ da empresa</dt>
                <dd class="col-sm-10">{{ $job->company->formatted_cpf_cnpj }}</dd>

                <dt class="col-sm-2">Empresa</dt>
                <dd class="col-sm-10">{{ $job->company->name }}</dd>

                <dt class="col-sm-2">Nome fantasia</dt>
                <dd class="col-sm-10">{{ $job->company->fantasy_name ?? '(Não informado)' }}</dd>

                <dt class="col-sm-2">Data de início</dt>
                <dd class="col-sm-10">{{ $job->start_date->format("d/m/Y") }}</dd>

                <dt class="col-sm-2">Data de término</dt>
                <dd class="col-sm-10">{{ $job->end_date->format("d/m/Y") }}</dd>

                <dt class="col-sm-2">CTPS</dt>
                <dd class="col-sm-10">{{ $job->ctps }}</dd>

                <dt class="col-sm-2">Estado</dt>
                <dd class="col-sm-10">{{ $job->state->description }}</dd>

                @if($job->state_id == 3)
                    <dt class="col-sm-2">Motivo do cancelamento</dt>
                    <dd class="col-sm-10">{{ $job->reason_to_cancel }}</dd>

                    <dt class="col-sm-2">Data do cancelamento</dt>
                    <dd class="col-sm-10">{{ $job->canceled_at->format("d/m/Y") }}</dd>
                @endif
            </dl>

            @if($job->state_id == \App\Models\State::FINISHED)
                <div class="btn-group">
                    <a href="{{ route('coordenador.trabalho.pdf', ['id' => $job->id]) }}" target="_blank"
                       class="btn btn-default">Imprimir relatório</a>
                </div>
            @endif
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('js')
    <script type="text/javascript">

    </script>
@endsection
