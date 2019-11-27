@extends('adminlte::page')

@section('title', 'Novo relatório final - SGE CTI')

@section('css')
    <style type="text/css">
        .notas .form-group {
            margin: 0;
        }
    </style>
@endsection

@section('content_header')
    <h1>Adicionar relatório final</h1>
@stop

@section('content')
    @include('modals.coordinator.report.final.warning')

    <form id="formReport" class="form-horizontal" action="{{ route('coordenador.relatorio.final.salvar') }}"
          method="post">
        @csrf

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do relatório</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('internship')) has-error @endif">
                            <label for="inputInternship" class="col-sm-4 control-label">Aluno*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" id="inputInternship" name="internship">

                                    @foreach($internships as $internship)
                                        <option value="{{ $internship->id }}"
                                            {{ (old('internship') ?? $i) == $internship->id ? 'selected=selected' : '' }}>
                                            {{ $internship->student->matricula }} - {{ $internship->student->nome }}
                                        </option>
                                    @endforeach

                                </select>

                                <span class="help-block">{{ $errors->first('internship') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('reportDate')) has-error @endif">
                            <label for="inputReportDate" class="col-sm-4 control-label">Data do relatório*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputReportDate" name="reportDate"
                                       value="{{ old('reportDate') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('reportDate') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('endDate')) has-error @endif">
                            <label for="inputEndDate" class="col-sm-4 control-label">Data de término*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputEndDate" name="endDate"
                                       value="{{ old('endDate') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('endDate') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('completedHours')) has-error @endif">
                            <label for="inputHoursCompleted" class="col-sm-4 control-label">Horas cumpridas*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputHoursCompleted" name="completedHours"
                                       placeholder="420" data-inputmask="'mask': '9999'"
                                       value="{{ old('completedHours') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('completedHours') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if((App\Models\Internship::find($i) ?? $internships->first()) != null)
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Dados do estágio</h3>
                </div>

                <div class="box-body">
                    <dl class="row">
                        <dt class="col-sm-2">Empresa</dt>
                        <dd class="col-sm-10">
                        <span id="internshipCompanyName">
                            {{ (App\Models\Internship::find($i) ?? $internships->first())->company->name }}
                        </span>
                        </dd>

                        <dt class="col-sm-2">Setor</dt>
                        <dd class="col-sm-10">
                        <span id="internshipSector">
                            {{ (App\Models\Internship::find($i) ?? $internships->first())->sector->name }}
                        </span>
                        </dd>

                        <dt class="col-sm-2">Supervisor</dt>
                        <dd class="col-sm-10">
                        <span id="internshipSupervisorName">
                            {{ (App\Models\Internship::find($i) ?? $internships->first())->supervisor->name }}
                        </span>
                        </dd>

                        <dt class="col-sm-2">Data de início</dt>
                        <dd class="col-sm-10">
                        <span id="internshipStartDate">
                            {{ date("d/m/Y", strtotime((App\Models\Internship::find($i) ?? $internships->first())->start_date->format("Y-m-d"))) }}
                        </span>
                        </dd>

                        <dt class="col-sm-2">Data de término</dt>
                        <dd class="col-sm-10">
                        <span id="internshipEndDate">
                            {{ date("d/m/Y", strtotime((App\Models\Internship::find($i) ?? $internships->first())->end_date->format("Y-m-d"))) }}
                        </span>
                        </dd>

                        <dt class="col-sm-2">Horas estimadas</dt>
                        <dd class="col-sm-10">
                        <span id="internshipEstimatedHours">
                            {{ round((App\Models\Internship::find($i) ?? $internships->first())->estimated_hours) }}
                        </span>
                        </dd>
                    </dl>
                </div>
            </div>
        @endif

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">I - Exigências do trabalho</h3>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6" class="@if($errors->has('grade_1_a')) text-red @endif">
                            A. QUALIDADE DO TRABALHO: qualidade e precisão da execução das tarefas
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_a_6" name="grade_1_a"
                                       value="6" {{ (old('grade_1_a') ?? 5) == 6 ? 'checked' : '' }}>
                                <label for="grade_1_a_6">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_a_5" name="grade_1_a"
                                       value="5" {{ (old('grade_1_a') ?? 5) == 5 ? 'checked' : '' }}>
                                <label for="grade_1_a_5">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_a_4" name="grade_1_a"
                                       value="4" {{ (old('grade_1_a') ?? 5) == 4 ? 'checked' : '' }}>
                                <label for="grade_1_a_4">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_a_3" name="grade_1_a"
                                       value="3" {{ (old('grade_1_a') ?? 5) == 3 ? 'checked' : '' }}>
                                <label for="grade_1_a_3">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_a_2" name="grade_1_a"
                                       value="2" {{ (old('grade_1_a') ?? 5) == 2 ? 'checked' : '' }}>
                                <label for="grade_1_a_2">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_a_1" name="grade_1_a"
                                       value="1" {{ (old('grade_1_a') ?? 5) == 1 ? 'checked' : '' }}>
                                <label for="grade_1_a_1">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6" class="@if($errors->has('grade_1_b')) text-red @endif">
                            B. ATIVIDADE E RAPIDEZ: rapidez, facilidade na execução das tarefas
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_b_6" name="grade_1_b"
                                       value="6" {{ (old('grade_1_b') ?? 5) == 6 ? 'checked' : '' }}>
                                <label for="grade_1_b_6">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_b_5" name="grade_1_b"
                                       value="5" {{ (old('grade_1_b') ?? 5) == 5 ? 'checked' : '' }}>
                                <label for="grade_1_b_5">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_b_4" name="grade_1_b"
                                       value="4" {{ (old('grade_1_b') ?? 5) == 4 ? 'checked' : '' }}>
                                <label for="grade_1_b_4">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_b_3" name="grade_1_b"
                                       value="3" {{ (old('grade_1_b') ?? 5) == 3 ? 'checked' : '' }}>
                                <label for="grade_1_b_3">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_b_2" name="grade_1_b"
                                       value="2" {{ (old('grade_1_b') ?? 5) == 2 ? 'checked' : '' }}>
                                <label for="grade_1_b_2">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_b_1" name="grade_1_b"
                                       value="1" {{ (old('grade_1_b') ?? 5) == 1 ? 'checked' : '' }}>
                                <label for="grade_1_b_1">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6" class="@if($errors->has('grade_1_c')) text-red @endif">
                            C. ORGANIZAÇÃO E MÉTODO: uso de meios racionais para melhor desempenho das tarefas
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_c_6" name="grade_1_c"
                                       value="6" {{ (old('grade_1_c') ?? 5) == 6 ? 'checked' : '' }}>
                                <label for="grade_1_c_6">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_c_5" name="grade_1_c"
                                       value="5" {{ (old('grade_1_c') ?? 5) == 5 ? 'checked' : '' }}>
                                <label for="grade_1_c_5">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_c_4" name="grade_1_c"
                                       value="4" {{ (old('grade_1_c') ?? 5) == 4 ? 'checked' : '' }}>
                                <label for="grade_1_c_4">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_c_3" name="grade_1_c"
                                       value="3" {{ (old('grade_1_c') ?? 5) == 3 ? 'checked' : '' }}>
                                <label for="grade_1_c_3">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_c_2" name="grade_1_c"
                                       value="2" {{ (old('grade_1_c') ?? 5) == 2 ? 'checked' : '' }}>
                                <label for="grade_1_c_2">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_c_1" name="grade_1_c"
                                       value="1" {{ (old('grade_1_c') ?? 5) == 1 ? 'checked' : '' }}>
                                <label for="grade_1_c_1">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">II - Formação Educacional</h3>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6" class="@if($errors->has('grade_2_a')) text-red @endif">
                            A. COMPORTAMENTO: facilidade em aceitar e seguir as instruções dos superiores e normas da
                            Empresa
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_a_6" name="grade_2_a"
                                       value="6" {{ (old('grade_2_a') ?? 5) == 6 ? 'checked' : '' }}>
                                <label for="grade_2_a_6">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_a_5" name="grade_2_a"
                                       value="5" {{ (old('grade_2_a') ?? 5) == 5 ? 'checked' : '' }}>
                                <label for="grade_2_a_5">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_a_4" name="grade_2_a"
                                       value="4" {{ (old('grade_2_a') ?? 5) == 4 ? 'checked' : '' }}>
                                <label for="grade_2_a_4">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_a_3" name="grade_2_a"
                                       value="3" {{ (old('grade_2_a') ?? 5) == 3 ? 'checked' : '' }}>
                                <label for="grade_2_a_3">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_a_2" name="grade_2_a"
                                       value="2" {{ (old('grade_2_a') ?? 5) == 2 ? 'checked' : '' }}>
                                <label for="grade_2_a_2">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_a_1" name="grade_2_a"
                                       value="1" {{ (old('grade_2_a') ?? 5) == 1 ? 'checked' : '' }}>
                                <label for="grade_2_a_1">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6" class="@if($errors->has('grade_2_b')) text-red @endif">
                            B. ASSIDUIDADE E PONTUALIDADE: constância e pontualidade no cumprimento dos horários, dias
                            de trabalho tarefas a serem executadas
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_b_6" name="grade_2_b"
                                       value="6" {{ (old('grade_2_b') ?? 5) == 6 ? 'checked' : '' }}>
                                <label for="grade_2_b_6">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_b_5" name="grade_2_b"
                                       value="5" {{ (old('grade_2_b') ?? 5) == 5 ? 'checked' : '' }}>
                                <label for="grade_2_b_5">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_b_4" name="grade_2_b"
                                       value="4" {{ (old('grade_2_b') ?? 5) == 4 ? 'checked' : '' }}>
                                <label for="grade_2_b_4">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_b_3" name="grade_2_b"
                                       value="3" {{ (old('grade_2_b') ?? 5) == 3 ? 'checked' : '' }}>
                                <label for="grade_2_b_3">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_b_2" name="grade_2_b"
                                       value="2" {{ (old('grade_2_b') ?? 5) == 2 ? 'checked' : '' }}>
                                <label for="grade_2_b_2">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_b_1" name="grade_2_b"
                                       value="1" {{ (old('grade_2_b') ?? 5) == 1 ? 'checked' : '' }}>
                                <label for="grade_2_b_1">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6" class="@if($errors->has('grade_2_c')) text-red @endif">
                            C. RELAÇÕES COM OS SUPERIORES: facilidade em aceitar as instruções superiores; facilidade
                            com que age frente a pessoas e situações
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_c_6" name="grade_2_c"
                                       value="6" {{ (old('grade_2_c') ?? 5) == 6 ? 'checked' : '' }}>
                                <label for="grade_2_c_6">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_c_5" name="grade_2_c"
                                       value="5" {{ (old('grade_2_c') ?? 5) == 5 ? 'checked' : '' }}>
                                <label for="grade_2_c_5">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_c_4" name="grade_2_c"
                                       value="4" {{ (old('grade_2_c') ?? 5) == 4 ? 'checked' : '' }}>
                                <label for="grade_2_c_4">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_c_3" name="grade_2_c"
                                       value="3" {{ (old('grade_2_c') ?? 5) == 3 ? 'checked' : '' }}>
                                <label for="grade_2_c_3">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_c_2" name="grade_2_c"
                                       value="2" {{ (old('grade_2_c') ?? 5) == 2 ? 'checked' : '' }}>
                                <label for="grade_2_c_2">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_c_1" name="grade_2_c"
                                       value="1" {{ (old('grade_2_c') ?? 5) == 1 ? 'checked' : '' }}>
                                <label for="grade_2_c_1">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6" class="@if($errors->has('grade_2_d')) text-red @endif">
                            D. RELAÇÕES COM OS COLEGAS: espontaneidade nas relações, cooperação com os colegas no
                            sentido de alcançarem o mesmo objetivo, influência positiva no grupo
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_d_6" name="grade_2_d"
                                       value="6" {{ (old('grade_2_d') ?? 5) == 6 ? 'checked' : '' }}>
                                <label for="grade_2_d_6">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_d_5" name="grade_2_d"
                                       value="5" {{ (old('grade_2_d') ?? 5) == 5 ? 'checked' : '' }}>
                                <label for="grade_2_d_5">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_d_4" name="grade_2_d"
                                       value="4" {{ (old('grade_2_d') ?? 5) == 4 ? 'checked' : '' }}>
                                <label for="grade_2_d_4">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_d_3" name="grade_2_d"
                                       value="3" {{ (old('grade_2_d') ?? 5) == 3 ? 'checked' : '' }}>
                                <label for="grade_2_d_3">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_d_2" name="grade_2_d"
                                       value="2" {{ (old('grade_2_d') ?? 5) == 2 ? 'checked' : '' }}>
                                <label for="grade_2_d_2">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_d_1" name="grade_2_d"
                                       value="1" {{ (old('grade_2_d') ?? 5) == 1 ? 'checked' : '' }}>
                                <label for="grade_2_d_1">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">III - Formação Profissional</h3>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6" class="@if($errors->has('grade_3_a')) text-red @endif">
                            A. DEDICAÇÃO E CONSCIÊNCIA PROFISSIONAL: capacidade para cuidar e responder pelas
                            atribuições, materiais, equipamentos e bens da Empresa que lhe foram confiados durante o
                            Estágio
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_a_6" name="grade_3_a"
                                       value="6" {{ (old('grade_3_a') ?? 5) == 6 ? 'checked' : '' }}>
                                <label for="grade_3_a_6">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_a_5" name="grade_3_a"
                                       value="5" {{ (old('grade_3_a') ?? 5) == 5 ? 'checked' : '' }}>
                                <label for="grade_3_a_5">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_a_4" name="grade_3_a"
                                       value="4" {{ (old('grade_3_a') ?? 5) == 4 ? 'checked' : '' }}>
                                <label for="grade_3_a_4">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_a_3" name="grade_3_a"
                                       value="3" {{ (old('grade_3_a') ?? 5) == 3 ? 'checked' : '' }}>
                                <label for="grade_3_a_3">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_a_2" name="grade_3_a"
                                       value="2" {{ (old('grade_3_a') ?? 5) == 2 ? 'checked' : '' }}>
                                <label for="grade_3_a_2">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_a_1" name="grade_3_a"
                                       value="1" {{ (old('grade_3_a') ?? 5) == 1 ? 'checked' : '' }}>
                                <label for="grade_3_a_1">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6" class="@if($errors->has('grade_3_b')) text-red @endif">
                            B. INICIATIVA/INDEPENDÊNCIA: capacidade de procurar novas soluções, sem prévia orientação,
                            adequadas aos padrões da Empresa
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_b_6" name="grade_3_b"
                                       value="6" {{ (old('grade_3_b') ?? 5) == 6 ? 'checked' : '' }}>
                                <label for="grade_3_b_6">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_b_5" name="grade_3_b"
                                       value="5" {{ (old('grade_3_b') ?? 5) == 5 ? 'checked' : '' }}>
                                <label for="grade_3_b_5">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_b_4" name="grade_3_b"
                                       value="4" {{ (old('grade_3_b') ?? 5) == 4 ? 'checked' : '' }}>
                                <label for="grade_3_b_4">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_b_3" name="grade_3_b"
                                       value="3" {{ (old('grade_3_b') ?? 5) == 3 ? 'checked' : '' }}>
                                <label for="grade_3_b_3">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_b_2" name="grade_3_b"
                                       value="2" {{ (old('grade_3_b') ?? 5) == 2 ? 'checked' : '' }}>
                                <label for="grade_3_b_2">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_b_1" name="grade_3_b"
                                       value="1" {{ (old('grade_3_b') ?? 5) == 1 ? 'checked' : '' }}>
                                <label for="grade_3_b_1">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">IV - Formação Completa</h3>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6" class="@if($errors->has('grade_4_a')) text-red @endif">
                            A. INTELIGÊNCIA E COMPREENSÃO: facilidade em compreender, interpretar e colocar em prática
                            instruções novas e informações verbais e/ou críticas
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_a_6" name="grade_4_a"
                                       value="6" {{ (old('grade_4_a') ?? 5) == 6 ? 'checked' : '' }}>
                                <label for="grade_4_a_6">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_a_5" name="grade_4_a"
                                       value="5" {{ (old('grade_4_a') ?? 5) == 5 ? 'checked' : '' }}>
                                <label for="grade_4_a_5">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_a_4" name="grade_4_a"
                                       value="4" {{ (old('grade_4_a') ?? 5) == 4 ? 'checked' : '' }}>
                                <label for="grade_4_a_4">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_a_3" name="grade_4_a"
                                       value="3" {{ (old('grade_4_a') ?? 5) == 3 ? 'checked' : '' }}>
                                <label for="grade_4_a_3">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_a_2" name="grade_4_a"
                                       value="2" {{ (old('grade_4_a') ?? 5) == 2 ? 'checked' : '' }}>
                                <label for="grade_4_a_2">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_a_1" name="grade_4_a"
                                       value="1" {{ (old('grade_4_a') ?? 5) == 1 ? 'checked' : '' }}>
                                <label for="grade_4_a_1">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6" class="@if($errors->has('grade_4_b')) text-red @endif">
                            B. CONHECIMENTOS GERAIS: demonstrado no cumprimento de instruções não específicas da área de
                            atuação
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_b_6" name="grade_4_b"
                                       value="6" {{ (old('grade_4_b') ?? 5) == 6 ? 'checked' : '' }}>
                                <label for="grade_4_b_6">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_b_5" name="grade_4_b"
                                       value="5" {{ (old('grade_4_b') ?? 5) == 5 ? 'checked' : '' }}>
                                <label for="grade_4_b_5">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_b_4" name="grade_4_b"
                                       value="4" {{ (old('grade_4_b') ?? 5) == 4 ? 'checked' : '' }}>
                                <label for="grade_4_b_4">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_b_3" name="grade_4_b"
                                       value="3" {{ (old('grade_4_b') ?? 5) == 3 ? 'checked' : '' }}>
                                <label for="grade_4_b_3">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_b_2" name="grade_4_b"
                                       value="2" {{ (old('grade_4_b') ?? 5) == 2 ? 'checked' : '' }}>
                                <label for="grade_4_b_2">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_b_1" name="grade_4_b"
                                       value="1" {{ (old('grade_4_b') ?? 5) == 1 ? 'checked' : '' }}>
                                <label for="grade_4_b_1">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6" class="@if($errors->has('grade_4_c')) text-red @endif">
                            C. CONHECIMENTOS PROFISSIONAIS: demonstrado no cumprimento dos programas de Estágio
                            relativos à área de atuação
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_c_6" name="grade_4_c"
                                       value="6" {{ (old('grade_4_c') ?? 5) == 6 ? 'checked' : '' }}>
                                <label for="grade_4_c_6">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_c_5" name="grade_4_c"
                                       value="5" {{ (old('grade_4_c') ?? 5) == 5 ? 'checked' : '' }}>
                                <label for="grade_4_c_5">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_c_4" name="grade_4_c"
                                       value="4" {{ (old('grade_4_c') ?? 5) == 4 ? 'checked' : '' }}>
                                <label for="grade_4_c_4">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_c_3" name="grade_4_c"
                                       value="3" {{ (old('grade_4_c') ?? 5) == 3 ? 'checked' : '' }}>
                                <label for="grade_4_c_3">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_c_2" name="grade_4_c"
                                       value="2" {{ (old('grade_4_c') ?? 5) == 2 ? 'checked' : '' }}>
                                <label for="grade_4_c_2">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_c_1" name="grade_4_c"
                                       value="1" {{ (old('grade_4_c') ?? 5) == 1 ? 'checked' : '' }}>
                                <label for="grade_4_c_1">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">V - Informações que julgar útil</h3>
            </div>

            <div class="box-body">
                <div class="form-group @if($errors->has('observation')) has-error @endif">
                    <label for="inputObservation" class="col-sm-2 control-label">Observações</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" rows="4" id="inputObservation" name="observation"
                                  style="resize: none"
                                  placeholder="Observações adicionais">{{ old('observation') ?? '' }}</textarea>

                        <span class="help-block">{{ $errors->first('observation') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary pull-right">Adicionar</button>

                <input type="hidden" id="inputPrevious" name="previous"
                       value="{{ old('previous') ?? url()->previous() }}">
                <a href="{{ old('previous') ?? url()->previous() }}" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        let ignore = false;

        let hours = {{ (App\Models\Internship::find($i) ?? $internships->first())->student->completed_hours }};
        let months = {{ (App\Models\Internship::find($i) ?? $internships->first())->student->completed_months }};
        let minHours = {{ (App\Models\Internship::find($i) ?? $internships->first())->student->course_configuration->min_hours }};
        let minMonths = {{ (App\Models\Internship::find($i) ?? $internships->first())->student->course_configuration->min_months }};

        jQuery(document).ready(function () {
            jQuery(':input').inputmask({removeMaskOnSubmit: true});

            jQuery('.selection').select2({
                language: "pt-BR"
            });

            jQuery('#formReport').submit(e => {
                let tHours = hours + jQuery('#inputHoursCompleted').val();
                let startDate = new Date(`${jQuery('#internshipStartDate').text().trim().split("/").reverse().join("-")} `);
                let endDate = new Date(`${jQuery('#inputEndDate').val()} `);

                let mDiff = Math.abs((endDate - startDate) / (30 * 24 * 60 * 60 * 1000));
                let tMonths = months + mDiff;
                if (ignore || tHours < minHours || tMonths < minMonths) {
                    e.preventDefault();

                    if (tHours < minHours) {
                        warningMessage(`O aluno ainda precisa de ${minHours - tHours}h para atingir o mínimo.`);

                        if (tMonths < minMonths) {
                            warningMessage(`O aluno ainda precisa de ${minHours - tHours}h  e ${minMonths - tMonths} meses para o mínimo.`);
                        }
                    } else if (tMonths < minMonths) {
                        warningMessage(`O aluno ainda precisa de ${minMonths - tMonths} meses para atingir o mínimo.`);
                    }

                    jQuery("#reportWarningModal").modal({
                        backdrop: "static",
                        keyboard: false,
                        show: true
                    });
                }
            });

            jQuery('#inputInternship').on('change', e => {
                jQuery.ajax({
                    url: `{{ config('app.url') }}/api/coordenador/estagio/${jQuery('#inputInternship').val()}`,
                    dataType: 'json',
                    method: 'GET',
                    success: function (data) {
                        jQuery('#internshipCompanyName').text(data.company.name);
                        jQuery('#internshipSector').text(data.sector.name);
                        jQuery('#internshipSupervisorName').text(data.supervisor.name);
                        jQuery('#internshipStartDate').text(new Date(`${data.start_date} `).toLocaleDateString());
                        jQuery('#internshipEndDate').text(new Date(`${data.end_date} `).toLocaleDateString());
                        jQuery('#internshipEstimatedHours').text(data.estimated_hours.toFixed(0));

                        hours = data.completed_hours;
                        months = data.completed_months;
                    },
                    error: function () {

                    },
                });
            });

            jQuery('.radio').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@endsection
