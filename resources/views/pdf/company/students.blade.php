@extends('pdf.noimg')

@section('title', 'Relação de estagiários')

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

    <h3>{{ $company->formatted_cpf_cnpj }} - {{ $company->name }} {{ $company->fantasy_name != null ? "({$company->fantasy_name})" : '' }}</h3>

    @if(sizeof($internships) > 0)
        <h3>Alunos estagiando</h3>

        @foreach($courses as $course)
            @if(sizeof($internships->filter(function ($i) use ($course) { return $i->student->course_id == $course->id; })) > 0)
                <h4>{{ $course->name }}</h4>

                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th>Protocolo</th>
                        <th>RA</th>
                        <th>Nome</th>
                        <th>Data de início</th>
                        <th>Data de término</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($internships->filter(function ($i) use ($course) { return $i->student->course_id == $course->id; }) as $internship)

                        <tr>
                            <td>{{ $internship->formatted_protocol }}</td>
                            <td>{{ $internship->student->matricula }}</td>
                            <td>{{ $internship->student->nome }}</td>
                            <td>{{ $internship->start_date->format("d/m/Y") }}</td>
                            <td>{{ $internship->end_date->format("d/m/Y") }}</td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach

    @endif

    @if(sizeof($finished_internships) > 0)
        @if(sizeof($internships) > 0)

            <div class="page-break"></div>

        @endif

        <h3>Alunos que já realizaram estágio</h3>

        @foreach($courses as $course)
            @if(sizeof($finished_internships->filter(function ($i) use ($course) { return $i->student->course_id == $course->id; })) > 0)
                <h4>{{ $course->name }}</h4>

                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th>Protocolo</th>
                        <th>RA</th>
                        <th>Nome</th>
                        <th>Data de início</th>
                        <th>Data de término</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($finished_internships->filter(function ($i) use ($course) { return $i->student->course_id == $course->id; }) as $internship)

                        <tr>
                            <td>{{ $internship->formatted_protocol }}</td>
                            <td>{{ $internship->student->matricula }}</td>
                            <td>{{ $internship->student->nome }}</td>
                            <td>{{ $internship->start_date->format("d/m/Y") }}</td>
                            <td>{{ $internship->final_report->end_date->format("d/m/Y") }}</td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach

    @endif

@endsection
