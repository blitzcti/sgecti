@extends('adminlte::page')

@section('title', 'Relatório PDF - SGE CTI')

@section('css')
    <style type="text/css">
        .gambi .form-group {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
    </style>
@endsection

@section('content_header')
    <h1>Relação de alunos em PDF</h1>
@stop

@section('content')
    @include('modals.coordinator.message.students')

    @if(session()->has('message'))
        <div class="alert {{ session('sent') ? 'alert-success' : 'alert-error' }} alert-dismissible"
             role="alert">
            {{ session()->get('message') }}

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('coordenador.aluno.gerarPDF') }}" class="form-horizontal" method="post">
        @csrf

        <div id="filters" class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_filters" data-toggle="tab" aria-expanded="true">Filtros</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab_filters">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group @if($errors->has('grades')) has-error @endif">
                                <label for="inputGrades" class="col-sm-3 control-label">Anos</label>

                                <div class="col-sm-9">
                                    <select class="form-control selection" id="inputGrades" name="grades[]"
                                            multiple>
                                        <option value="1"
                                            {{ in_array(1, (old('grades') ?? [])) ? 'selected=selected' : '' }}>1º ano
                                        </option>

                                        <option value="2"
                                            {{ in_array(2, (old('grades') ?? [])) ? 'selected=selected' : '' }}>2º ano
                                        </option>

                                        <option value="3"
                                            {{ in_array(3, (old('grades') ?? [])) ? 'selected=selected' : '' }}>3º ano
                                        </option>

                                        <option value="4"
                                            {{ in_array(4, (old('grades') ?? [])) ? 'selected=selected' : '' }}>Formados
                                        </option>
                                    </select>

                                    <span class="help-block">{{ $errors->first('grades') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group @if($errors->has('periods')) has-error @endif">
                                <label for="inputPeriods" class="col-sm-3 control-label">Períodos</label>

                                <div class="col-sm-9">
                                    <select class="form-control selection" id="inputPeriods" name="periods[]"
                                            multiple>
                                        <option value="0"
                                            {{ in_array(0, (old('periods') ?? [])) ? 'selected=selected' : '' }}>Diurno
                                        </option>

                                        <option value="1"
                                            {{ in_array(1, (old('periods') ?? [])) ? 'selected=selected' : '' }}>
                                            Noturno
                                        </option>
                                    </select>

                                    <span class="help-block">{{ $errors->first('periods') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group @if($errors->has('courses')) has-error @endif">
                                <label for="inputCourses" class="col-sm-3 control-label">Cursos</label>

                                <div class="col-sm-9">
                                    <select class="form-control selection" id="inputCourses" name="courses[]"
                                            multiple>

                                        @foreach($courses as $course)

                                            <option
                                                value="{{ $course->id }}"
                                                {{ in_array($course->id, (old('courses') ?? [])) ? "selected" : "" }}>
                                                {{ $course->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                    <span class="help-block">{{ $errors->first('courses') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group @if($errors->has('internships')) has-error @endif">
                                <label for="inputInternships" class="col-sm-3 control-label">Estágio</label>

                                <div class="col-sm-9">
                                    <select class="form-control selection" id="inputInternships"
                                            name="internships[]"
                                            multiple>
                                        <option value="0"
                                            {{ in_array(0, (old('internships') ?? [])) ? 'selected=selected' : '' }}>
                                            Estagiando
                                        </option>

                                        <option value="1"
                                            {{ in_array(1, (old('internships') ?? [])) ? 'selected=selected' : '' }}>
                                            Estágio finalizado
                                        </option>

                                        <option value="2"
                                            {{ in_array(2, (old('internships') ?? [])) ? 'selected=selected' : '' }}>
                                            Não estagiando
                                        </option>

                                        <option value="3"
                                            {{ in_array(3, (old('internships') ?? [])) ? 'selected=selected' : '' }}>
                                            Nunca estagiaram
                                        </option>
                                    </select>

                                    <span class="help-block">{{ $errors->first('internships') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin: 0">
                        <div class="btn-group pull-right">
                            <a href="#" class="btn btn-default" onclick="loadStudents()"><i class="fa fa-search"></i>
                                Visualizar</a>
                            <button type="submit" class="btn btn-primary">Gerar PDF</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(() => {
            jQuery('#message').wysihtml5({
                locale: 'pt-BR'
            });

            jQuery('.selection').select2({
                language: "pt-BR"
            });
        });
    </script>
@endsection
