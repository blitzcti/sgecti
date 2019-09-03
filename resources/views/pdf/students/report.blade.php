@extends('pdf.noimg')

@section('title', 'Relatório final de estágio')

@section('css')

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">

    <style type="text/css">
        @page {
            margin: 2.4cm 1cm 0.75cm 1cm !important;
        }

        header {
            top: -60px !important;
        }
    </style>

@endsection

@section('content')

    <h3>Relação de alunos estagiando</h3>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">Protocolo</th>
            <th>RA</th>
            <th>Nome</th>
            <th>Empresa</th>
            <th>Data de início</th>
            <th>Data de término</th>
        </tr>
        </thead>

        <tbody>
        @foreach($students->where('internship_state', '=', 0) as $student)

            <tr>
                <th scope="row">{{ $student->internship->protocol }}</th>
                <td>{{ $student->matricula }}</td>
                <td>{{ $student->nome }}</td>
                <td>{{ $student->internship->company->name }}  {{ $student->internship->company->fantasy_name != null ? " (" . $student->internship->company->fantasy_name . ")" : '' }}</td>
                <td>{{ date("d/m/Y", strtotime($student->internship->start_date)) }}</td>
                <td>{{ date("d/m/Y", strtotime($student->internship->end_date)) }}</td>
            </tr>

        @endforeach
        </tbody>
    </table>

@endsection
