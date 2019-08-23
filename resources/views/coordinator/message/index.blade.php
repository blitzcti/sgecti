@extends('adminlte::page')

@section('title', 'Mensagem - SGE CTI')

@section('css')
    <style type="text/css">
        .gambi .form-group {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
    </style>
@endsection

@section('content_header')
    <h1>Enviar mensagem</h1>
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

    <form action="{{ route('coordenador.mensagem.enviar') }}" class="form-horizontal" method="post">
        @csrf

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Destinatários</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('grades')) has-error @endif">
                            <label for="inputGrades" class="col-sm-4 control-label">Anos</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" id="inputGrades" name="grades[]" multiple>
                                    <option value="1"
                                        {{ (old('grades') ?? 0) == 1 ? 'selected=selected' : '' }}>1º ano
                                    </option>
                                    <option value="2"
                                        {{ (old('grades') ?? 0) == 2 ? 'selected=selected' : '' }}>2º ano
                                    </option>
                                    <option value="3"
                                        {{ (old('grades') ?? 0) == 3 ? 'selected=selected' : '' }}>3º ano
                                    </option>
                                    <option value="4"
                                        {{ (old('grades') ?? 0) == 4 ? 'selected=selected' : '' }}>Formados
                                    </option>
                                </select>

                                <span class="help-block">{{ $errors->first('grades') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('periods')) has-error @endif">
                            <label for="inputPeriods" class="col-sm-4 control-label">Períodos</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" id="inputPeriods" name="periods[]" multiple>
                                    <option value="0"
                                        {{ (old('periods') ?? -1) == 0 ? 'selected=selected' : '' }}>Diurno
                                    </option>
                                    <option value="1"
                                        {{ (old('periods') ?? -1) == 1 ? 'selected=selected' : '' }}>Noturno
                                    </option>
                                </select>

                                <span class="help-block">{{ $errors->first('periods') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('courses')) has-error @endif">
                            <label for="inputCourses" class="col-sm-4 control-label">Cursos</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" id="inputCourses" name="courses[]" multiple>

                                    @foreach($courses as $course)

                                        <option
                                            value="{{ $course->id }}" {{ in_array($course->id, (old('courses') ?? [])) ? "selected" : "" }}>
                                            {{ $course->name }}</option>

                                    @endforeach

                                </select>

                                <span class="help-block">{{ $errors->first('courses') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('internship')) has-error @endif">
                            <label for="inputInternship" class="col-sm-4 control-label">Estágio</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" id="inputInternship" name="internships[]"
                                        multiple>
                                    <option value="0">Estagiando</option>
                                    <option value="1">Não estagiando</option>
                                    <option value="2">Nunca estagiaram</option>
                                </select>

                                <span class="help-block">{{ $errors->first('internship') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <div class="btn-group pull-right">
                    <a href="#" class="btn btn-default" onclick="loadStudents()"><i class="fa fa-search"></i> Visualizar</a>
                </div>
            </div>
        </div>

        <div class="box box-default gambi">
            <div class="box-header with-border">
                <h3 class="box-title">Tipo de mensagem</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="radio" class="radio" id="bimestral" name="message" value="0">
                            <label for="bimestral">Relatório bimestral</label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="radio" class="radio" id="proposal" name="message" value="1">
                            <label for="proposal">Proposta de estágio</label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="radio" class="radio" id="important" name="message" value="2">
                            <label for="important">Aviso importante</label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="radio" class="radio" id="free" name="message" value="3" checked>
                            <label for="free">Livre</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="pull-right btn btn-default" id="sendEmail">Enviar
                    <i class="fa fa-arrow-circle-right"></i></button>
            </div>
            <!-- /.box-footer -->
        </div>

        <div class="box box-default gambi" id="freeMessage">
            <div class="box-body">
                <div class="form-group" id="inputSubject">
                    <input type="text" class="form-control" name="subject" placeholder="Assunto">
                </div>
                <div>
                  <textarea id="message" name="messageBody" class="textarea" placeholder="Mensagem"
                            style="resize:none; width: 100%; height: 250px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(() => {
            jQuery('#importantMessage #message').wysihtml5({
                locale: 'pt-BR'
            });

            jQuery('#freeMessage #message').wysihtml5({
                locale: 'pt-BR'
            });

            jQuery('.selection').select2({
                language: "pt-BR"
            });

            jQuery('input[name="message"]').on('ifChanged', function () {
                let v = parseInt($('input[name="message"]:checked').val());

                switch (v) {
                    case 2:
                        jQuery('#freeMessage').css('display', 'block');
                        jQuery('#inputSubject').css('display', 'none');
                        break;

                    case 3:
                        jQuery('#freeMessage').css('display', 'block');
                        jQuery('#inputSubject').css('display', 'block');
                        break;

                    default:
                        jQuery('#inputSubject').css('display', 'none');
                        jQuery('#freeMessage').css('display', 'none');
                        break;
                }
            });

            jQuery('.radio').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@endsection
