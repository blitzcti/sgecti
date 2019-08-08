@extends('pdf.noimg')

@section('title', 'Relatório final de estágio')

@section('css')

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">

@endsection

@section('content')

    <h3>Relatório final de estágio</h3>
    <hr />

    @if($student != null)

    <h3>Dados do aluno</h3>
    <hr />

    <dl class="row">
        <dt class="col-sm-2">RA</dt>
        <dd class="col-sm-10">{{ $student->matricula }}</dd>

        <dt class="col-sm-2">Nome</dt>
        <dd class="col-sm-10">{{ $student->nome }}</dd>

        <dt class="col-sm-2">Curso</dt>
        <dd class="col-sm-10">{{ $student->course->name }}</dd>

        <dt class="col-sm-2">Turma</dt>
        <dd class="col-sm-10">{{ $student->turma }} ({{ $student->turma_ano }})</dd>

        <dt class="col-sm-2">Email</dt>
        <dd class="col-sm-10">{{ $student->email }}</dd>

        <dt class="col-sm-2">Email 2</dt>
        <dd class="col-sm-10">{{ $student->email2 }}</dd>
    </dl>

    <div class="page-break"></div>

    @endif

    <h3>Dados do estágio</h3>
    <hr />

    <dl class="row">
        <dt class="col-sm-2">Empresa</dt>
        <dd class="col-sm-10">{{ $report->internship->company->name }}</dd>

        <dt class="col-sm-2">Setor</dt>
        <dd class="col-sm-10">{{ $report->internship->sector->name }}</dd>

        <dt class="col-sm-2">Supervisor</dt>
        <dd class="col-sm-10">{{ $report->internship->supervisor->name }}</dd>

        <dt class="col-sm-2">Data de início</dt>
        <dd class="col-sm-10">{{ date("d/m/Y", strtotime($report->internship->start_date)) }}</dd>

        <dt class="col-sm-2">Data de término</dt>
        <dd class="col-sm-10">{{ date("d/m/Y", strtotime($report->end_date)) }}</dd>

        <dt class="col-sm-2">Horas concluídas</dt>
        <dd class="col-sm-10">{{ $report->hours_completed }}</dd>

        <dt class="col-sm-2">Nota final</dt>
        <dd class="col-sm-10">{{ $report->final_grade }}</dd>

        <dt class="col-sm-2">Número de aprovação</dt>
        <dd class="col-sm-10">{{ $report->approval_number }}</dd>
    </dl>

@endsection
