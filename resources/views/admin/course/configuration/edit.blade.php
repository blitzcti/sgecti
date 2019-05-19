﻿@extends('adminlte::page')

@section('title', 'Editar configurações do curso - SGE CTI')

@section('content_header')
    <h1>Editar configurações do curso <a
                href="{{ route('admin.curso.detalhes', ['id' => $course->id]) }}">{{ $course->name }}</a></h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="box box-default">
        <form class="form-horizontal" action="{{ route('admin.curso.configuracao.salvar', $config->id_course) }}"
              method="post">
            @csrf

            <div class="box-body">
                <input type="hidden" name="id_config" value="{{ $config->id }}">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputMinYear" class="col-sm-4 control-label">Ano mínimo</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                        id="inputMinYear" name="minYear">
                                    <option value="1" {{ $config->min_year == 1 ? 'selected=selected' : '' }}>
                                        1º ano
                                    </option>
                                    <option value="2" {{ $config->min_year == 2 ? 'selected=selected' : '' }}>
                                        2º ano
                                    </option>
                                    <option value="3" {{ $config->min_year == 3 ? 'selected=selected' : '' }}>
                                        3º ano
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputMinSemester" class="col-sm-4 control-label">Semestre mínimo</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                        id="inputMinSemester" name="minSemester">
                                    <option value="1" {{ $config->min_semester == 1 ? 'selected=selected' : '' }}>
                                        1º semestre
                                    </option>
                                    <option value="2" {{ $config->min_semester == 2 ? 'selected=selected' : '' }}>
                                        2º semestre
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputMinHour" class="col-sm-4 control-label">Horas mínimas</label>

                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="inputMinHour" name="minHour"
                                       placeholder="420"
                                       value="{{ $config->min_hours }}"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputMinMonth" class="col-sm-4 control-label">Meses mínimos</label>

                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="inputMinMonth" name="minMonth"
                                       placeholder="6"
                                       value="{{ $config->min_months }}"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputMinMonthCTPS" class="col-sm-4 control-label">Meses mínimos (CTPS)</label>

                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="inputMinMonth" name="minMonthCTPS"
                                       placeholder="6" value="{{ $config->min_months_ctps }}"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputMinMark" class="col-sm-4 control-label">Nota mínima</label>

                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="inputMinMark" name="minMark"
                                       placeholder="10" step="0.5" value="{{ $config->min_grade }}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                <button type="submit" name="cancel" class="btn btn-default">Cancelar</button>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
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
