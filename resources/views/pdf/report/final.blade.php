@extends('pdf.master', ['page_number' => false])

@section('title', 'Relatório final de estágio')

@section('css')
    <style type="text/css">
        .list {
            border: none;
            margin-left: 40px;
            border-collapse: separate;
            border-spacing: 0 6px;
        }

        h3 {
            font-size: 16pt !important;
        }
    </style>
@endsection

@section('content')

    <h3 style="margin-top: 5px; text-decoration: underline;" class="text-center">Ficha de Avaliação de Estágio</h3>

    <div style="text-align: center; margin-bottom: 10px;">
        <img src="{{ route('api.alunos.foto', ['id' => $student->matricula]) }}" style="height: 140px" alt="">
    </div>

    <table class="list">
        <tbody>
        <tr>
            <td class="text-right"><b>Número de aprovação: </b></td>
            <td>{{ $report->approval_number }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Número do estágio: </b></td>
            <td>{{ $report->internship->formatted_protocol }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Número de matrícula: </b></td>
            <td>{{ $student->matricula }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Nome do aluno: </b></td>
            <td>{{ $student->nome }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Curso: </b></td>
            <td>{{ $student->course->name }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Empresa: </b></td>
            <td>{{ $report->internship->company->name }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Setor: </b></td>
            <td>{{ $report->internship->sector->name }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Supervisor da empresa: </b></td>
            <td>{{ $report->internship->supervisor->name }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Período de estágio: </b></td>
            <td>
                {{ $report->internship->start_date->format("d/m/Y") }} a {{ $report->end_date->format("d/m/Y") }}
                - {{ $report->end_date->diff($report->internship->start_date)->days }} dias.
            </td>
        </tr>

        <tr>
            <td class="text-right"><b>Avaliação: </b></td>
            <td>{{ $report->final_grade }} - {{ $report->final_grade_explanation }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Total em horas: </b></td>
            <td>{{ $report->completed_hours }}</td>
        </tr>
        </tbody>
    </table>

    <br/><br/>

    @if($student->canGraduate())
        <span><b>Aluno habilitado a colar grau no curso técnico em {{ $student->course->name }}.</b></span><br/>
    @endif

    <span class="pull-right">{{ $sysConfig->city }}, {{ \Carbon\Carbon::now()->formatLocalized('%02d de %B de %Y') }}.</span>

@endsection

@section('footer')
    <div style="font-size: 7pt; text-align: center;">
        <span>{{ $sysConfig->name }} - Coordenadoria de {{ $report->coordinator->course->name }}</span><br/>
        <span>{{ $sysConfig->street }}, {{ $sysConfig->number }} - CEP {{ $sysConfig->formatted_cep }} {{ $sysConfig->city }}, {{ $sysConfig->uf }} Brasil.</span><br/>
        <span>Tel {{ $sysConfig->formatted_phone }} Fax {{ $sysConfig->formatted_fax }}</span>
    </div>
@endsection
