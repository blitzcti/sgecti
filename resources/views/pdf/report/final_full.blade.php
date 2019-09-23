@extends('pdf.master', ['page_number' => false])

@section('title', 'Relatório final de estágio')

@section('css')
    <style type="text/css">
        h3 {
            font-size: 16pt !important;
        }

        h4 {
            font-size: 11.5pt !important;
        }

        footer {
            bottom: 25px !important;
        }

        .list {
            border: none;
            margin-left: 105px;
            font-size: 9pt;
        }

        .grades div {
            padding: 0 0 0 110px;
            font-size: 0;
            width: 250px;
        }

        .grades div div {
            text-align: left;
        }

        .grades span {
            display: inline-block;
            font-size: 9pt;
        }

        .grades .t-left {
            text-align: left;
            width: 100px;
        }

        .grades .t-right {
            padding-left: 80px;
        }

        .grades-info {
            font-size: 8.5pt;
            margin-left: auto;
            margin-right: auto;
        }

        .grades-info,
        .grades-info th,
        .grades-info td {
            border: 1px solid #333333;
        }

        .grades-info th,
        .grades-info td {
            padding: 0 6px;
            text-align: center;
        }
    </style>
@endsection

@section('content')

    <h3 style="margin-top: 5px; text-decoration: underline;" class="text-center">Ficha de Avaliação de Estágio</h3>

    <div style="text-align: center; margin-bottom: 5px;">
        <img src="{{ route('api.alunos.foto', ['id' => $student->matricula]) }}" style="height: 140px" alt="">
    </div>

    <div>
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
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="grades text-center">
        <h4 style="text-decoration: underline;" class="text-center">I - Exigências do Trabalho</h4>
        <div>
            <div>
                <span class="t-left">Letra A) {{ $report->gradeExplanation($report->grade_1_a) }}</span>
                <span class="t-right">X 5 = {{ $report->grade_1_a * 5 }}</span>
            </div>

            <div>
                <span class="t-left">Letra B) {{ $report->gradeExplanation($report->grade_1_b) }}</span>
                <span class="t-right">X 4 = {{ $report->grade_1_b * 4 }}</span>
            </div>

            <div>
                <span class="t-left">Letra C) {{ $report->gradeExplanation($report->grade_1_c) }}</span>
                <span class="t-right">X 2 = {{ $report->grade_1_c * 2 }}</span>
            </div>
        </div>

        <h4 style="text-decoration: underline;" class="text-center">II - Formação Educacional</h4>
        <div>
            <div>
                <span class="t-left">Letra A) {{ $report->gradeExplanation($report->grade_2_a) }}</span>
                <span class="t-right">X 3 = {{ $report->grade_2_a * 3 }}</span>
            </div>

            <div>
                <span class="t-left">Letra B) {{ $report->gradeExplanation($report->grade_2_b) }}</span>
                <span class="t-right">X 4 = {{ $report->grade_2_b * 4 }}</span>
            </div>

            <div>
                <span class="t-left">Letra C) {{ $report->gradeExplanation($report->grade_2_c) }}</span>
                <span class="t-right">X 3 = {{ $report->grade_2_c * 3 }}</span>
            </div>

            <div>
                <span class="t-left">Letra D) {{ $report->gradeExplanation($report->grade_2_d) }}</span>
                <span class="t-right">X 1 = {{ $report->grade_2_d * 1 }}</span>
            </div>
       </div>

        <h4 style="text-decoration: underline;" class="text-center">III - Formação Profissional</h4>
        <div>
            <div>
                <span class="t-left">Letra A) {{ $report->gradeExplanation($report->grade_3_a) }}</span>
                <span class="t-right">X 5 = {{ $report->grade_3_a * 5 }}</span>
            </div>

            <div>
                <span class="t-left">Letra B) {{ $report->gradeExplanation($report->grade_3_b) }}</span>
                <span class="t-right">X 4 = {{ $report->grade_3_b * 4 }}</span>
            </div>
        </div>

        <h4 style="text-decoration: underline;" class="text-center">IV - Formação Completa</h4>
        <div>
            <div>
                <span class="t-left">Letra A) {{ $report->gradeExplanation($report->grade_4_a) }}</span>
                <span class="t-right">X 2 = {{ $report->grade_4_a * 2 }}</span>
            </div>

            <div>
                <span class="t-left">Letra B) {{ $report->gradeExplanation($report->grade_4_b) }}</span>
                <span class="t-right">X 2 = {{ $report->grade_4_b * 2 }}</span>
            </div>

            <div>
                <span class="t-left">Letra C) {{ $report->gradeExplanation($report->grade_4_c) }}</span>
                <span class="t-right">X 5 = {{ $report->grade_4_c * 5 }}</span>
            </div>
        </div>
    </div>

    <div style="margin-left: -26px; margin-bottom: 10px;">
        <table class="list">
            <tbody>
            <tr>
                <td class="text-right"><b>Média da avaliação: </b></td>
                <td>{{ $report->final_grade }} - {{ $report->final_grade_explanation }}</td>
            </tr>

            <tr>
                <td class="text-right"><b>Responsável pela avaliação: </b></td>
                <td>{{ $report->coordinator->user->name }}</td>
            </tr>

            <tr>
                <td class="text-right"><b>Data da avaliação: </b></td>
                <td>{{ $report->date->format("d/m/Y") }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div style="text-align: center;">
        <table class="grades-info">
            <thead>
            <tr>
                <th>Peso</th>
                <th>Conceitos</th>
                <th>Média final</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>0</td>
                <td>Negativo</td>
                <td>0.0 a 1.3</td>
            </tr>

            <tr>
                <td>1</td>
                <td>Fraco</td>
                <td>1.4 a 2.8</td>
            </tr>

            <tr>
                <td>2</td>
                <td>Regular</td>
                <td>2.9 a 4.2</td>
            </tr>

            <tr>
                <td>3</td>
                <td>Médio</td>
                <td>4.3 a 5.7</td>
            </tr>

            <tr>
                <td>4</td>
                <td>Bom</td>
                <td>5.8 a 7.1</td>
            </tr>

            <tr>
                <td>5</td>
                <td>Ótimo</td>
                <td>7.2 a 8.4</td>
            </tr>

            <tr>
                <td>6</td>
                <td>Excelente</td>
                <td>8.5 a 10.0</td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection

@section('footer')
    <div style="font-size: 7pt; text-align: center;">
        <span>{{ $sysConfig->name }} - Coordenadoria de Estágio</span><br/>
        <span>{{ $sysConfig->street }}, {{ $sysConfig->number }} - CEP {{ $sysConfig->formatted_cep }} {{ $sysConfig->city }}, {{ $sysConfig->uf }} Brasil.</span><br/>
        <span>Tel {{ $sysConfig->formatted_phone }} Fax {{ $sysConfig->formatted_fax }}</span>
    </div>
@endsection
