@extends('pdf.noimg')

@section('title', 'Relatório final de estágio')

@section('css')

    <style type="text/css">
        @page {
            margin: 2.9cm 1cm 0.75cm 1cm !important;
        }

        header {
            top: -72.5px !important;
        }
    </style>

@endsection

@section('content')

    @if(sizeof($internships) > 0)

        <h3>Alunos estagiando</h3>
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
            @foreach($internships as $internship)

                <tr>
                    <th scope="row">{{ $internship->protocol }}</th>
                    <td>{{ $internship->student->matricula }}</td>
                    <td>{{ $internship->student->nome }}</td>
                    <td>{{ $internship->company->name }}  {{ $internship->company->fantasy_name != null ? " (" . $internship->company->fantasy_name . ")" : '' }}</td>
                    <td>{{ date("d/m/Y", strtotime($internship->start_date)) }}</td>
                    <td>{{ date("d/m/Y", strtotime($internship->end_date)) }}</td>
                </tr>

            @endforeach
            </tbody>
        </table>

    @endif

    @if(sizeof($finished_internships) > 0)
        @if(sizeof($internships) > 0)

            <div class="page-break"></div>

        @endif

        <h3>Alunos que já realizaram estágio</h3>
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
            @foreach($finished_internships as $internship)

                <tr>
                    <th scope="row">{{ $internship->protocol }}</th>
                    <td>{{ $internship->student->matricula }}</td>
                    <td>{{ $internship->student->nome }}</td>
                    <td>{{ $internship->company->name }}  {{ $internship->company->fantasy_name != null ? " (" . $internship->company->fantasy_name . ")" : '' }}</td>
                    <td>{{ date("d/m/Y", strtotime($internship->start_date)) }}</td>
                    <td>{{ date("d/m/Y", strtotime($internship->end_date)) }}</td>
                </tr>

            @endforeach
            </tbody>
        </table>

    @endif

    @if(sizeof($not_in_internships) > 0)
        @if(sizeof($internships) > 0 || sizeof($finished_internships))

            <div class="page-break"></div>

        @endif

        <h3>Alunos que não estão estagiando</h3>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th scope="col">RA</th>
                <th>Nome</th>
                <th>Turma</th>
            </tr>
            </thead>

            <tbody>
            @foreach($not_in_internships as $student)

                <tr>
                    <th scope="row">{{ $student->matricula }}</th>
                    <td>{{ $student->nome }}</td>
                    <td>{{ $student->turma }}</td>
                </tr>

            @endforeach
            </tbody>
        </table>

    @endif

    @if(sizeof($never_had_internship) > 0)
        @if(sizeof($internships) > 0 || sizeof($finished_internships) || sizeof($not_in_internships) > 0)

            <div class="page-break"></div>

        @endif

        <h3>Alunos que nunca estagiaram</h3>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th scope="col">RA</th>
                <th>Nome</th>
                <th>Turma</th>
            </tr>
            </thead>

            <tbody>
            @foreach($never_had_internship as $student)

                <tr>
                    <th scope="row">{{ $student->matricula }}</th>
                    <td>{{ $student->nome }}</td>
                    <td>{{ $student->turma }}</td>
                </tr>

            @endforeach
            </tbody>
        </table>

    @endif

@endsection
