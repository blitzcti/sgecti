@extends('pdf.noimg')

@section('title', 'Relatório final de estágio')

@section('css')

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">

@endsection

@section('content')

    <h3>Relatório final de estágio</h3>
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
    {{--<table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th>Nome</th>
        </tr>
        </thead>

        <tbody>
        @foreach($courses as $course)

            <tr>
                <th scope="row">{{ $course->id }}</th>
                <td>{{ $course->name }}</td>
            </tr>

        @endforeach
        </tbody>
    </table>--}}

    <div class="page-break"></div>

    {{--<table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">RA</th>
            <th>Nome</th>
        </tr>
        </thead>

        <tbody>
        @foreach($students as $student)

            <tr>
                <th scope="row">{{ $student->matricula }}</th>
                <td>{{ $student->name }}</td>
            </tr>

        @endforeach
        </tbody>
    </table>--}}

@endsection
