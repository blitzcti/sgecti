{{--
    TODO: mensagem => alunos de qual periodo (manha, noite, 4º ano)
--}}

@extends('adminlte::page')

@section('title', 'Mensagem - SGE CTI')

@section('content_header')
    <h1>Enviar mensagem</h1>
@stop

@section('content')
    @if(session()->has('message'))
        <div class="alert {{ session('saved') ? 'alert-success' : 'alert-error' }} alert-dismissible"
             role="alert">
            {{ session()->get('message') }}

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('coordenador.mensagem.enviar') }}" method="post">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Destinatários</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('year')) has-error @endif">
                            <label for="inputYear" class="col-sm-4 control-label">Ano</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" id="inputYear" name="year[]" multiple>
                                    <option value="1"
                                        {{ (old('year') ?? 0) == 1 ? 'selected=selected' : '' }}>1º ano
                                    </option>
                                    <option value="2"
                                        {{ (old('year') ?? 0) == 2 ? 'selected=selected' : '' }}>2º ano
                                    </option>
                                    <option value="3"
                                        {{ (old('year') ?? 0) == 3 ? 'selected=selected' : '' }}>3º ano
                                    </option>
                                    <option value="4"
                                        {{ (old('year') ?? 0) == 4 ? 'selected=selected' : '' }}>4º ano
                                    </option>
                                </select>

                                <span class="help-block">{{ $errors->first('year') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('period')) has-error @endif">
                            <label for="inputPeriod" class="col-sm-4 control-label">Período</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" id="inputPeriod" name="period[]" multiple>
                                    <option value="1"
                                        {{ (old('period') ?? -1) == 0 ? 'selected=selected' : '' }}>Matutino
                                    </option>
                                    <option value="2"
                                        {{ (old('period') ?? -1) == 1 ? 'selected=selected' : '' }}>Noturno
                                    </option>
                                </select>

                                <span class="help-block">{{ $errors->first('period') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('course')) has-error @endif">
                            <label for="inputCourse" class="col-sm-4 control-label">Curso</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" id="inputCourse" name="course[]" multiple>

                                    @foreach($courses as $course)

                                        <option
                                            value="{{ $course->id }}" {{ in_array($course->id, (old('courses') ?? [])) ? "selected" : "" }}>
                                            {{ $course->name }}</option>

                                    @endforeach

                                </select>

                                <span class="help-block">{{ $errors->first('course') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin: 15px 0">
                    <table id="students" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>RA</th>
                            <th>Nome</th>
                            <th>Curso</th>
                            <th>Turma</th>
                            <th>Ano</th>
                        </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-body">
                <div class="form-group">
                    <input type="text" class="form-control" name="subject" placeholder="Assunto">
                </div>
                <div>
                  <textarea id="message" class="textarea" placeholder="Mensagem"
                            style="resize:none; width: 100%; height: 250px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
            </div>
            <div class="box-footer clearfix">
                <button type="button" class="pull-right btn btn-default" id="sendEmail">Enviar
                    <i class="fa fa-arrow-circle-right"></i></button>
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
