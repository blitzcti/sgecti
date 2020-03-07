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

    <h3 style="margin-top: 5px; text-decoration: underline;" class="text-center">Ficha de Avaliação de Estágio - CTPS</h3>

    <div style="text-align: center; margin-bottom: 10px;">
        <img src="{{ route('api.alunos.foto', ['id' => $student->matricula]) }}" style="height: 140px" alt="">
    </div>

    <table class="list">
        <tbody>
        <tr>
            <td class="text-right"><b>Número de aprovação: </b></td>
            <td>{{ $job->approval_number }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Número do trabalho: </b></td>
            <td>{{ $job->formatted_protocol }}</td>
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
            <td>{{ $job->company->name }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Setor: </b></td>
            <td>{{ $job->sector->name }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Período de trabalho: </b></td>
            <td>
                {{ $job->start_date->format("d/m/Y") }} a {{ $job->end_date->format("d/m/Y") }}
                - {{ $job->end_date->diff($job->start_date)->days }} dias.
            </td>
        </tr>

        <tr>
            <td class="text-right"><b>CTPS: </b></td>
            <td>{{ $job->formatted_ctps }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Data de admissão: </b></td>
            <td>{{ $job->start_date->format("d/m/Y") }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Data da declaração: </b></td>
            <td>{{ $job->plan_date->format("d/m/Y") }}</td>
        </tr>
        </tbody>
    </table>

    <br/><br/>

    @if($student->canGraduate())
        <span>Aluno habilitado a colar grau no curso técnico em {{ $student->course->name }}, conforme o disposto no Art. 108 e 109 do Regimento Escolar, e Item 32 do Subitem 32.1 do Plano Escolar, após concluir o curso.</span>
        <br/><br/>
    @endif

    <table class="list">
        <tbody>
        <tr>
            <td class="text-right"><b>Responsável pela avaliação: </b></td>
            <td>{{ $job->coordinator->user->name }}</td>
        </tr>

        <tr>
            <td class="text-right"><b>Data da avaliação: </b></td>
            <td>{{ $job->created_at->format("d/m/Y") }}</td>
        </tr>
        </tbody>
    </table>

    <span
        class="pull-right">{{ $sysConfig->city }}, {{ \Carbon\Carbon::now()->formatLocalized('%02d de %B de %Y') }}.</span>

@endsection

@section('footer')
    <div style="font-size: 7pt; text-align: center;">
        <span>{{ $sysConfig->name }} - Coordenadoria de {{ $job->coordinator->course->name }}</span><br/>
        <span>{{ $sysConfig->street }}, {{ $sysConfig->number }} - CEP {{ $sysConfig->formatted_cep }} {{ $sysConfig->city }}, {{ $sysConfig->uf }} Brasil.</span><br/>
        <span>Tel {{ $sysConfig->formatted_phone }} Fax {{ $sysConfig->formatted_fax }}</span>
    </div>
@endsection
