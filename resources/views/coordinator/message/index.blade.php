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

                <a href="#" class="btn btn-default" onclick="loadStudents()"><i class="fa fa-search"></i></a>

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
        let courses = [
            @foreach(App\Models\Course::all()->sortBy('id') as $course)
            {name: '{{ $course->name }}'},
            @endforeach
        ];

        function getGrades() {
            return jQuery('#inputGrades').val();
        }

        function getPeriods() {
            return jQuery('#inputPeriods').val();
        }

        function getCourses() {
            return jQuery('#inputCourses').val();
        }

        function loadStudents() {
            let gs = getGrades().map(g => `&grades[]=${g}`);
            let ps = getPeriods().map(p => `&periods[]=${p}`);
            let cs = getCourses().map(c => `&courses[]=${c}`);

            let url = `/api/aluno?q=`;
            if (gs.length > 0) {
                url += gs;
            }

            if (ps.length > 0) {
                url += ps;
            }

            if (cs.length > 0) {
                url += cs;
            }

            jQuery.ajax({
                url: url,
                dataType: 'json',
                method: 'GET',
                success: function (students) {
                    let tbody = jQuery('#students tbody');
                    tbody.empty();

                    students.forEach(student => {
                        if (student.situacao_matricula === 0 || student.situacao_matricula === 5) {
                            let row = document.createElement('tr');
                            let col = document.createElement('td');
                            col.innerText = student.matricula;
                            row.appendChild(col);

                            col = document.createElement('td');
                            col.innerText = student.nome;
                            row.appendChild(col);

                            col = document.createElement('td');
                            col.innerText = courses[student.course_id - 1].name;
                            row.appendChild(col);

                            col = document.createElement('td');
                            col.innerText = student.class;
                            row.appendChild(col);

                            col = document.createElement('td');
                            col.innerText = student.year;
                            row.appendChild(col);

                            tbody.append(row);
                        }
                    });
                },

                error: function () {

                }
            });
        }

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
