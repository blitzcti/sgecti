@extends('adminlte::page')

@section('title', 'Detalhes do trabalho - SGE CTI')

@section('content_header')
    <h1>Detalhes do trabalho</h1>
@stop

@section('content')
    @include('modals.coordinator.internship.job.cancel')

    <div class="box box-default">
        <div class="box-body">
            <div class="btn-group" style="display: inline-flex; margin: 0">
                <a href="{{ route('coordenador.estagio.trabalho.editar', $job->id) }}"
                   class="btn btn-primary">Editar estágio</a>

                @if($job->state->id == 1)

                    <a href="#"
                       onclick="jobId('{{ $job->id }}'); studentName('{{ $job->student->nome }}'); return false;"
                       data-toggle="modal" class="btn btn-danger" data-target="#jobCancelModal">Cancelar</a>

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

                <dt class="col-sm-2">Email 2</dt>
                <dd class="col-sm-10">{{ $job->student->email2 }}</dd>
            </dl>

            <hr/>
            <h3>Dados do trabalho</h3>

            <dl class="row">
                <dt class="col-sm-2">Empresa</dt>
                <dd class="col-sm-10">{{ $job->company->name }}</dd>

                <dt class="col-sm-2">Setor</dt>
                <dd class="col-sm-10">{{ $job->sector->name }}</dd>

                <dt class="col-sm-2">Supervisor</dt>
                <dd class="col-sm-10">{{ $job->supervisor->name }}</dd>

                <dt class="col-sm-2">Data de início</dt>
                <dd class="col-sm-10">{{ date("d/m/Y", strtotime($job->start_date)) }}</dd>

                <dt class="col-sm-2">Data de término</dt>
                <dd class="col-sm-10">{{ date("d/m/Y", strtotime($job->end_date)) }}</dd>

                <dt class="col-sm-2">CTPS</dt>
                <dd class="col-sm-10">{{ $job->ctps }}</dd>

                <dt class="col-sm-2">Estado</dt>
                <dd class="col-sm-10">{{ $job->state->description }}</dd>

                @if($job->state_id == 3)

                    <dt class="col-sm-2">Motivo do cancelamento</dt>
                    <dd class="col-sm-10">{{ $job->reason_to_cancel }}</dd>

                @endif
            </dl>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('js')
    <script type="text/javascript">

    </script>
@endsection
