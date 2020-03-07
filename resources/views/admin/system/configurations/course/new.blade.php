@extends('adminlte::page')

@section('title', 'Nova configuração geral de curso')

@section('content_header')
    <h1>Nova configuração geral de curso</h1>
@stop

@section('content')
    <form class="form-horizontal" action="{{ route('admin.configuracao.curso.salvar') }}" method="post">
        @csrf

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados da configuração</h3>
            </div>

            <div class="box-body">
                <div class="form-group @if($errors->has('maxYears')) has-error @endif">
                    <label for="inputMaxYears" class="col-sm-2 control-label">Anos máximos*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputMaxYears"
                               name="maxYears" placeholder="5" value="{{ old('maxYears') ?? '' }}"/>

                        <span class="help-block">{{ $errors->first('maxYears') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('minYear')) has-error @endif">
                            <label for="inputMinYear" class="col-sm-4 control-label">Ano mínimo*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                        id="inputMinYear" name="minYear">
                                    <option value="1"
                                        {{ (old('minYear') ?? 1) == 1 ? 'selected=selected' : '' }}>1º ano
                                    </option>
                                    <option value="2"
                                        {{ (old('minYear') ?? 1) == 2 ? 'selected=selected' : '' }}>2º ano
                                    </option>
                                    <option value="3"
                                        {{ (old('minYear') ?? 1) == 3 ? 'selected=selected' : '' }}>3º ano
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
                                        {{ (old('minSemester') ?? 1) == 1 ? 'selected=selected' : '' }}>1º semestre
                                    </option>
                                    <option value="2"
                                        {{ (old('minSemester') ?? 1) == 2 ? 'selected=selected' : '' }}>2º semestre
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
                                       placeholder="420" value="{{ old('minHours') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('minHours') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('minMonths')) has-error @endif">
                            <label for="inputMinMonths" class="col-sm-4 control-label">Meses mínimos*</label>

                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="inputMinMonths" name="minMonths"
                                       placeholder="6" value="{{ old('minMonths') ?? '' }}"/>

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
                                       placeholder="6" value="{{ old('minMonthsCTPS') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('minMonthsCTPS') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('minGrade')) has-error @endif">
                            <label for="inputMinGrade" class="col-sm-4 control-label">Nota mínima*</label>

                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="inputMinGrade" name="minGrade"
                                       placeholder="10" step="0.5" value="{{ old('minGrade') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('minGrade') }}</span>
                            </div>
                        </div>
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
        jQuery(document).ready(function () {
            jQuery('.selection').select2({
                language: "pt-BR"
            });

            jQuery(':input').inputmask({removeMaskOnSubmit: true});
        });
    </script>
@endsection

