@extends('adminlte::page')

@section('title', 'Editar configurações do curso')

@section('content_header')
    <h1>Editar configurações do curso <a
            href="{{ route('admin.curso.detalhes', ['id' => $course->id]) }}">{{ $course->name }}</a></h1>
@stop

@section('content')
    <form class="form-horizontal" method="post"
          action="{{ route('admin.curso.configuracao.alterar', [$config->course_id, $config->id]) }}">
        @method('PUT')
        @csrf

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados da configuração do curso</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('minYear')) has-error @endif">
                            <label for="inputMinYear" class="col-sm-4 control-label">Ano mínimo*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                        id="inputMinYear" name="minYear">
                                    <option value="1"
                                        {{ (old('minYear') ?? $config->min_year) == 1 ? 'selected=selected' : '' }}>1º
                                        ano
                                    </option>
                                    <option value="2"
                                        {{ (old('minYear') ?? $config->min_year) == 2 ? 'selected=selected' : '' }}>2º
                                        ano
                                    </option>
                                    <option value="3"
                                        {{ (old('minYear') ?? $config->min_year) == 3 ? 'selected=selected' : '' }}>3º
                                        ano
                                    </option>
                                </select>

                                <span class="help-block">{{ $errors->first('minYear') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('minSemester')) has-error @endif">
                            <label for="inputMinSemester" class="col-sm-4 control-label">Semestre mínimo*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                        id="inputMinSemester" name="minSemester">
                                    <option value="1"
                                        {{ (old('minSemester') ?? $config->min_semester) == 1 ? 'selected=selected' : '' }}>
                                        1º semestre
                                    </option>
                                    <option value="2"
                                        {{ (old('minSemester') ?? $config->min_semester) == 2 ? 'selected=selected' : '' }}>
                                        2º semestre
                                    </option>
                                </select>

                                <span class="help-block">{{ $errors->first('minSemester') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('minHours')) has-error @endif">
                            <label for="inputMinHours" class="col-sm-4 control-label">Horas mínimas*</label>

                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="inputMinHours" name="minHours"
                                       placeholder="420" value="{{ old('minHours') ?? $config->min_hours }}"/>

                                <span class="help-block">{{ $errors->first('minHours') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('minMonths')) has-error @endif">
                            <label for="inputMinMonths" class="col-sm-4 control-label">Meses mínimos*</label>

                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="inputMinMonths" name="minMonths"
                                       placeholder="6" value="{{ old('minMonths') ?? $config->min_months }}"/>

                                <span class="help-block">{{ $errors->first('minMonths') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('minMonthsCTPS')) has-error @endif">
                            <label for="inputMinMonthsCTPS" class="col-sm-4 control-label">Meses mínimos (CTPS)*</label>

                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="inputMinMonthsCTPS" name="minMonthsCTPS"
                                       placeholder="6" value="{{ old('minMonthsCTPS') ?? $config->min_months_ctps }}"/>

                                <span class="help-block">{{ $errors->first('minMonthsCTPS') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('minGrade')) has-error @endif">
                            <label for="inputMinGrade" class="col-sm-4 control-label">Nota mínima*</label>

                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="inputMinGrade" name="minGrade"
                                       placeholder="10" step="0.5" value="{{ old('minGrade') ?? $config->min_grade }}"/>

                                <span class="help-block">{{ $errors->first('minGrade') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary pull-right">Salvar</button>

                <input type="hidden" id="inputPrevious" name="previous"
                       value="{{ old('previous') ?? url()->previous() }}">
                <a href="{{ old('previous') ?? url()->previous() }}" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('.selection').select2({
                language: "pt-BR"
            });
        });
    </script>
@endsection
