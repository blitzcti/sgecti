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

    <form class="form-horizontal" action="{{ route('coordenador.relatorio.final.salvar') }}" method="post">
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
                        <div class="form-group @if($errors->has('date')) has-error @endif">
                            <label for="inputDate" class="col-sm-4 control-label">Data do Relatório*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputDate" name="date"
                                       value="{{ old('date') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('date') }}</span>
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
                        <div class="form-group @if($errors->has('hoursCompleted')) has-error @endif">
                            <label for="inputHoursCompleted" class="col-sm-4 control-label">Horas Cumpridas*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputHoursCompleted" name="hoursCompleted"
                                       placeholder="420" data-inputmask="'mask': '9999'"
                                       value="{{ old('hoursCompleted') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('hoursCompleted') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Adicionar</button>
                <a href="{{url()->previous()}}" class="btn btn-default">Cancelar</a>
            </div>
            <!-- /.box-footer -->
        </div>

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
                            {{ date("d/m/Y", strtotime((App\Models\Internship::find($i) ?? $internships->first())->start_date)) }}
                        </span>
                    </dd>

                    <dt class="col-sm-2">Data de término</dt>
                    <dd class="col-sm-10">
                        <span id="internshipEndDate">
                            {{ date("d/m/Y", strtotime((App\Models\Internship::find($i) ?? $internships->first())->end_date)) }}
                        </span>
                    </dd>

                    <dt class="col-sm-2">Horas estimadas</dt>
                    <dd class="col-sm-10">
                        <span id="internshipEstimatedHours">
                            {{ (App\Models\Internship::find($i) ?? $internships->first())->estimated_hours }}
                        </span>
                    </dd>
                </dl>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">I - Exigências do trabalho</h3>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6">A. QUALIDADE DO TRABALHO: qualidade e precisão da execução das tarefas</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_a_5" name="grade_1_a"
                                       value="5" {{ (old('grade_1_a') ?? -1) == 5 ? 'checked' : '' }}>
                                <label for="grade_1_a_5">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_a_4" name="grade_1_a"
                                       value="4" {{ (old('grade_1_a') ?? -1) == 4 ? 'checked' : '' }}>
                                <label for="grade_1_a_4">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_a_3" name="grade_1_a"
                                       value="3" {{ (old('grade_1_a') ?? -1) == 3 ? 'checked' : '' }}>
                                <label for="grade_1_a_3">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_a_2" name="grade_1_a"
                                       value="2" {{ (old('grade_1_a') ?? -1) == 2 ? 'checked' : '' }}>
                                <label for="grade_1_a_2">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_a_1" name="grade_1_a"
                                       value="1" {{ (old('grade_1_a') ?? -1) == 1 ? 'checked' : '' }}>
                                <label for="grade_1_a_1">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_a_0" name="grade_1_a"
                                       value="0" {{ (old('grade_1_a') ?? -1) == 0 ? 'checked' : '' }}>
                                <label for="grade_1_a_0">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6">B. ATIVIDADE E RAPIDEZ: rapidez, facilidade na execução das tarefas</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_b_5" name="grade_1_b"
                                       value="5" {{ (old('grade_1_b') ?? -1) == 5 ? 'checked' : '' }}>
                                <label for="grade_1_b_5">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_b_4" name="grade_1_b"
                                       value="4" {{ (old('grade_1_b') ?? -1) == 4 ? 'checked' : '' }}>
                                <label for="grade_1_b_4">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_b_3" name="grade_1_b"
                                       value="3" {{ (old('grade_1_b') ?? -1) == 3 ? 'checked' : '' }}>
                                <label for="grade_1_b_3">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_b_2" name="grade_1_b"
                                       value="2" {{ (old('grade_1_b') ?? -1) == 2 ? 'checked' : '' }}>
                                <label for="grade_1_b_2">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_b_1" name="grade_1_b"
                                       value="1" {{ (old('grade_1_b') ?? -1) == 1 ? 'checked' : '' }}>
                                <label for="grade_1_b_1">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_b_0" name="grade_1_b"
                                       value="0" {{ (old('grade_1_b') ?? -1) == 0 ? 'checked' : '' }}>
                                <label for="grade_1_b_0">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6">C. ORGANIZAÇÃO E MÉTODO: uso de meios racionais para melhor desempenho das
                            tarefas
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_c_5" name="grade_1_c"
                                       value="5" {{ (old('grade_1_c') ?? -1) == 5 ? 'checked' : '' }}>
                                <label for="grade_1_c_5">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_c_4" name="grade_1_c"
                                       value="4" {{ (old('grade_1_c') ?? -1) == 4 ? 'checked' : '' }}>
                                <label for="grade_1_c_4">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_c_3" name="grade_1_c"
                                       value="3" {{ (old('grade_1_c') ?? -1) == 3 ? 'checked' : '' }}>
                                <label for="grade_1_c_3">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_c_2" name="grade_1_c"
                                       value="2" {{ (old('grade_1_c') ?? -1) == 2 ? 'checked' : '' }}>
                                <label for="grade_1_c_2">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_c_1" name="grade_1_c"
                                       value="1" {{ (old('grade_1_c') ?? -1) == 1 ? 'checked' : '' }}>
                                <label for="grade_1_c_1">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_1_c_0" name="grade_1_c"
                                       value="0" {{ (old('grade_1_c') ?? -1) == 0 ? 'checked' : '' }}>
                                <label for="grade_1_c_0">Fraco</label>
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
                        <th colspan="6">A. COMPORTAMENTO: facilidade em aceitar e seguir as instruções dos superiores e
                            normas da Empresa
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_a_5" name="grade_2_a"
                                       value="5" {{ (old('grade_2_a') ?? -1) == 5 ? 'checked' : '' }}>
                                <label for="grade_2_a_5">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_a_4" name="grade_2_a"
                                       value="4" {{ (old('grade_2_a') ?? -1) == 4 ? 'checked' : '' }}>
                                <label for="grade_2_a_4">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_a_3" name="grade_2_a"
                                       value="3" {{ (old('grade_2_a') ?? -1) == 3 ? 'checked' : '' }}>
                                <label for="grade_2_a_3">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_a_2" name="grade_2_a"
                                       value="2" {{ (old('grade_2_a') ?? -1) == 2 ? 'checked' : '' }}>
                                <label for="grade_2_a_2">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_a_1" name="grade_2_a"
                                       value="1" {{ (old('grade_2_a') ?? -1) == 1 ? 'checked' : '' }}>
                                <label for="grade_2_a_1">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_a_0" name="grade_2_a"
                                       value="0" {{ (old('grade_2_a') ?? -1) == 0 ? 'checked' : '' }}>
                                <label for="grade_2_a_0">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6">B. ASSIDUIDADE E PONTUALIDADE: constância e pontualidade no cumprimento dos
                            horários, dias de
                            trabalho tarefas a serem executadas
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_b_5" name="grade_2_b"
                                       value="5" {{ (old('grade_2_b') ?? -1) == 5 ? 'checked' : '' }}>
                                <label for="grade_2_b_5">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_b_4" name="grade_2_b"
                                       value="4" {{ (old('grade_2_b') ?? -1) == 4 ? 'checked' : '' }}>
                                <label for="grade_2_b_4">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_b_3" name="grade_2_b"
                                       value="3" {{ (old('grade_2_b') ?? -1) == 3 ? 'checked' : '' }}>
                                <label for="grade_2_b_3">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_b_2" name="grade_2_b"
                                       value="2" {{ (old('grade_2_b') ?? -1) == 2 ? 'checked' : '' }}>
                                <label for="grade_2_b_2">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_b_1" name="grade_2_b"
                                       value="1" {{ (old('grade_2_b') ?? -1) == 1 ? 'checked' : '' }}>
                                <label for="grade_2_b_1">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_b_0" name="grade_2_b"
                                       value="0" {{ (old('grade_2_b') ?? -1) == 0 ? 'checked' : '' }}>
                                <label for="grade_2_b_0">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6">C. RELAÇÕES COM OS SUPERIORES: facilidade em aceitar as instruções superiores;
                            facilidade com que age
                            frente a pessoas e situações
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_c_5" name="grade_2_c"
                                       value="5" {{ (old('grade_2_c') ?? -1) == 5 ? 'checked' : '' }}>
                                <label for="grade_2_c_5">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_c_4" name="grade_2_c"
                                       value="4" {{ (old('grade_2_c') ?? -1) == 4 ? 'checked' : '' }}>
                                <label for="grade_2_c_4">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_c_3" name="grade_2_c"
                                       value="3" {{ (old('grade_2_c') ?? -1) == 3 ? 'checked' : '' }}>
                                <label for="grade_2_c_3">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_c_2" name="grade_2_c"
                                       value="2" {{ (old('grade_2_c') ?? -1) == 2 ? 'checked' : '' }}>
                                <label for="grade_2_c_2">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_c_1" name="grade_2_c"
                                       value="1" {{ (old('grade_2_c') ?? -1) == 1 ? 'checked' : '' }}>
                                <label for="grade_2_c_1">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_c_0" name="grade_2_c"
                                       value="0" {{ (old('grade_2_c') ?? -1) == 0 ? 'checked' : '' }}>
                                <label for="grade_2_c_0">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6">D. RELAÇÕES COM OS COLEGAS: espontaneidade nas relações, cooperação com os
                            colegas no sentido de
                            alcançarem o mesmo objetivo, influência positiva no grupo
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_d_5" name="grade_2_d"
                                       value="5" {{ (old('grade_2_d') ?? -1) == 5 ? 'checked' : '' }}>
                                <label for="grade_2_d_5">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_d_4" name="grade_2_d"
                                       value="4" {{ (old('grade_2_d') ?? -1) == 4 ? 'checked' : '' }}>
                                <label for="grade_2_d_4">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_d_3" name="grade_2_d"
                                       value="3" {{ (old('grade_2_d') ?? -1) == 3 ? 'checked' : '' }}>
                                <label for="grade_2_d_3">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_d_2" name="grade_2_d"
                                       value="2" {{ (old('grade_2_d') ?? -1) == 2 ? 'checked' : '' }}>
                                <label for="grade_2_d_2">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_d_1" name="grade_2_d"
                                       value="1" {{ (old('grade_2_d') ?? -1) == 1 ? 'checked' : '' }}>
                                <label for="grade_2_d_1">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_2_d_0" name="grade_2_d"
                                       value="0" {{ (old('grade_2_d') ?? -1) == 0 ? 'checked' : '' }}>
                                <label for="grade_2_d_0">Fraco</label>
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
                        <th colspan="6">A. DEDICAÇÃO E CONSCIÊNCIA PROFISSIONAL: capacidade para cuidar e responder
                            pelas atribuições,
                            materiais, equipamentos e bens da Empresa que lhe foram confiados durante o Estágio
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_a_5" name="grade_3_a"
                                       value="5" {{ (old('grade_3_a') ?? -1) == 5 ? 'checked' : '' }}>
                                <label for="grade_3_a_5">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_a_4" name="grade_3_a"
                                       value="4" {{ (old('grade_3_a') ?? -1) == 4 ? 'checked' : '' }}>
                                <label for="grade_3_a_4">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_a_3" name="grade_3_a"
                                       value="3" {{ (old('grade_3_a') ?? -1) == 3 ? 'checked' : '' }}>
                                <label for="grade_3_a_3">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_a_2" name="grade_3_a"
                                       value="2" {{ (old('grade_3_a') ?? -1) == 2 ? 'checked' : '' }}>
                                <label for="grade_3_a_2">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_a_1" name="grade_3_a"
                                       value="1" {{ (old('grade_3_a') ?? -1) == 1 ? 'checked' : '' }}>
                                <label for="grade_3_a_1">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_a_0" name="grade_3_a"
                                       value="0" {{ (old('grade_3_a') ?? -1) == 0 ? 'checked' : '' }}>
                                <label for="grade_3_a_0">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6">B. INICIATIVA/INDEPENDÊNCIA: capacidade de procurar novas soluções, sem prévia
                            orientação, adequadas
                            aos padrões da Empresa
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_b_5" name="grade_3_b"
                                       value="5" {{ (old('grade_3_b') ?? -1) == 5 ? 'checked' : '' }}>
                                <label for="grade_3_b_5">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_b_4" name="grade_3_b"
                                       value="4" {{ (old('grade_3_b') ?? -1) == 4 ? 'checked' : '' }}>
                                <label for="grade_3_b_4">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_b_3" name="grade_3_b"
                                       value="3" {{ (old('grade_3_b') ?? -1) == 3 ? 'checked' : '' }}>
                                <label for="grade_3_b_3">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_b_2" name="grade_3_b"
                                       value="2" {{ (old('grade_3_b') ?? -1) == 2 ? 'checked' : '' }}>
                                <label for="grade_3_b_2">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_b_1" name="grade_3_b"
                                       value="1" {{ (old('grade_3_b') ?? -1) == 1 ? 'checked' : '' }}>
                                <label for="grade_3_b_1">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_3_b_0" name="grade_3_b"
                                       value="0" {{ (old('grade_3_b') ?? -1) == 0 ? 'checked' : '' }}>
                                <label for="grade_3_b_0">Fraco</label>
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
                        <th colspan="6">A. INTELIGÊNCIA E COMPREENSÃO: facilidade em compreender, interpretar e colocar
                            em prática instruções
                            novas e informações verbais e/ou críticas
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_a_5" name="grade_4_a"
                                       value="5" {{ (old('grade_4_a') ?? -1) == 5 ? 'checked' : '' }}>
                                <label for="grade_4_a_5">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_a_4" name="grade_4_a"
                                       value="4" {{ (old('grade_4_a') ?? -1) == 4 ? 'checked' : '' }}>
                                <label for="grade_4_a_4">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_a_3" name="grade_4_a"
                                       value="3" {{ (old('grade_4_a') ?? -1) == 3 ? 'checked' : '' }}>
                                <label for="grade_4_a_3">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_a_2" name="grade_4_a"
                                       value="2" {{ (old('grade_4_a') ?? -1) == 2 ? 'checked' : '' }}>
                                <label for="grade_4_a_2">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_a_1" name="grade_4_a"
                                       value="1" {{ (old('grade_4_a') ?? -1) == 1 ? 'checked' : '' }}>
                                <label for="grade_4_a_1">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_a_0" name="grade_4_a"
                                       value="0" {{ (old('grade_4_a') ?? -1) == 0 ? 'checked' : '' }}>
                                <label for="grade_4_a_0">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6">B. CONHECIMENTOS GERAIS: demonstrado no cumprimento de instruções não
                            específicas da área de atuação
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_b_5" name="grade_4_b"
                                       value="5" {{ (old('grade_4_b') ?? -1) == 5 ? 'checked' : '' }}>
                                <label for="grade_4_b_5">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_b_4" name="grade_4_b"
                                       value="4" {{ (old('grade_4_b') ?? -1) == 4 ? 'checked' : '' }}>
                                <label for="grade_4_b_4">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_b_3" name="grade_4_b"
                                       value="3" {{ (old('grade_4_b') ?? -1) == 3 ? 'checked' : '' }}>
                                <label for="grade_4_b_3">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_b_2" name="grade_4_b"
                                       value="2" {{ (old('grade_4_b') ?? -1) == 2 ? 'checked' : '' }}>
                                <label for="grade_4_b_2">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_b_1" name="grade_4_b"
                                       value="1" {{ (old('grade_4_b') ?? -1) == 1 ? 'checked' : '' }}>
                                <label for="grade_4_b_1">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_b_0" name="grade_4_b"
                                       value="0" {{ (old('grade_4_b') ?? -1) == 0 ? 'checked' : '' }}>
                                <label for="grade_4_b_0">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped notas">
                    <thead>
                    <tr>
                        <th colspan="6">C. CONHECIMENTOS PROFISSIONAIS: demonstrado no cumprimento dos programas de
                            Estágio relativos à área
                            de atuação
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_c_5" name="grade_4_c"
                                       value="5" {{ (old('grade_4_c') ?? -1) == 5 ? 'checked' : '' }}>
                                <label for="grade_4_c_5">Excelente</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_c_4" name="grade_4_c"
                                       value="4" {{ (old('grade_4_c') ?? -1) == 4 ? 'checked' : '' }}>
                                <label for="grade_4_c_4">Ótimo</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_c_3" name="grade_4_c"
                                       value="3" {{ (old('grade_4_c') ?? -1) == 3 ? 'checked' : '' }}>
                                <label for="grade_4_c_3">Bom</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_c_2" name="grade_4_c"
                                       value="2" {{ (old('grade_4_c') ?? -1) == 2 ? 'checked' : '' }}>
                                <label for="grade_4_c_2">Médio</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_c_1" name="grade_4_c"
                                       value="1" {{ (old('grade_4_c') ?? -1) == 1 ? 'checked' : '' }}>
                                <label for="grade_4_c_1">Regular</label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="radio" class="radio" id="grade_4_c_0" name="grade_4_c"
                                       value="0" {{ (old('grade_4_c') ?? -1) == 0 ? 'checked' : '' }}>
                                <label for="grade_4_c_0">Fraco</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados administrativos</h3>
            </div>

            <div class="box-body">
                <div class="form-group @if($errors->has('observation')) has-error @endif">
                    <label for="inputObservation" class="col-sm-2 control-label">Obervação</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" id="inputObservation" name="observation"
                                  style="resize: none"
                                  placeholder="Observações adicionais">{{ old('observation') ?? '' }}</textarea>

                        <span class="help-block">{{ $errors->first('observation') }}</span>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Adicionar</button>
                <a href="{{url()->previous()}}" class="btn btn-default">Cancelar</a>
            </div>
            <!-- /.box-footer -->
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery(':input').inputmask({removeMaskOnSubmit: true});

            jQuery('.selection').select2({
                language: "pt-BR"
            });

            jQuery('#inputInternship').on('change', e => {
                jQuery.ajax({
                    url: `/api/estagio/${jQuery('#inputInternship').val()}`,
                    dataType: 'json',
                    method: 'GET',
                    success: function (data) {
                        jQuery.ajax({
                            url: `/api/empresa/${data.company_id}`,
                            dataType: 'json',
                            method: 'GET',
                            success: function (data) {
                                jQuery('#internshipCompanyName').text(data.name);
                            },
                            error: function () {

                            },
                        });

                        jQuery.ajax({
                            url: `/api/empresa/setor/${data.sector_id}`,
                            dataType: 'json',
                            method: 'GET',
                            success: function (data) {
                                jQuery('#internshipSector').text(data.name);
                            },
                            error: function () {

                            },
                        });

                        jQuery.ajax({
                            url: `/api/empresa/supervisor/${data.supervisor_id}`,
                            dataType: 'json',
                            method: 'GET',
                            success: function (data) {
                                jQuery('#internshipSupervisorName').text(data.name);
                            },
                            error: function () {

                            },
                        });

                        jQuery('#internshipStartDate').text(data.start_date);
                        jQuery('#internshipEndDate').text(data.end_date);
                        jQuery('#internshipEstimatedHours').text(data.estimated_hours);
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
