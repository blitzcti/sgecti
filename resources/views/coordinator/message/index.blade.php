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

        <input type="hidden" id="inputUseFilters" name="useFilters" value="{{ old('useFilters') ?? 1 }}">
        <input type="hidden" id="inputMessage" name="message" value="{{ old('message') ?? 3 }}">
        <input type="hidden" id="inputProposal" name="proposal" value="{{ old('proposal') ?? '' }}">

        <div id="filters" class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_filters" data-toggle="tab" aria-expanded="true">Filtros</a>
                </li>

                <li>
                    <a href="#tab_students" data-toggle="tab" aria-expanded="false">Alunos específicos</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab_filters">
                    <div class="row">
                        <div class="col-sm-4">
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

                        <div class="col-sm-4">
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

                        <div class="col-sm-4">
                            <div class="form-group @if($errors->has('classes')) has-error @endif">
                                <label for="inputClasses" class="col-sm-3 control-label">Turmas</label>

                                <div class="col-sm-9">
                                    <select class="form-control selection" id="inputClasses" name="classes[]"
                                            multiple>
                                        <option value="A"
                                            {{ in_array('A', (old('classes') ?? [])) ? 'selected=selected' : '' }}>A
                                        </option>

                                        <option value="B"
                                            {{ in_array('B', (old('classes') ?? [])) ? 'selected=selected' : '' }}>
                                            B
                                        </option>

                                        <option value="C"
                                            {{ in_array('C', (old('classes') ?? [])) ? 'selected=selected' : '' }}>
                                            C
                                        </option>

                                        <option value="D"
                                            {{ in_array('D', (old('classes') ?? [])) ? 'selected=selected' : '' }}>
                                            D
                                        </option>
                                    </select>

                                    <span class="help-block">{{ $errors->first('classes') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group @if($errors->has('courses')) has-error @endif">
                                <label for="inputCourses" class="col-sm-2 control-label">Cursos</label>

                                <div class="col-sm-10">
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
                                <label for="inputInternships" class="col-sm-2 control-label">Estágio</label>

                                <div class="col-sm-10">
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
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab_students">
                    <div class="form-group @if($errors->has('students')) has-error @endif">
                        <label for="inputStudents" class="col-sm-2 control-label">Alunos</label>

                        <div class="col-sm-10">
                            <select class="form-control selection" id="inputStudents" name="students[]"
                                    multiple>

                                @foreach($students as $student)

                                    <option value="{{ $student->matricula }}"
                                        {{ in_array($student->matricula, (old('students') ?? [])) ? 'selected=selected' : '' }}>
                                        {{ $student->matricula }} - {{ $student->nome }}
                                    </option>

                                @endforeach
                            </select>

                            <span class="help-block">{{ $errors->first('students') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="messageType" class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li>
                    <a href="#tab_bimestralReport" data-toggle="tab" aria-expanded="false">Relatório bimestral</a>
                </li>

                <li>
                    <a href="#tab_internshipProposal" data-toggle="tab" aria-expanded="false">Proposta de estágio</a>
                </li>

                <li>
                    <a href="#tab_importantMessage" data-toggle="tab" aria-expanded="false">Aviso importante</a>
                </li>

                <li class="active">
                    <a href="#tab_message" data-toggle="tab" aria-expanded="true">Livre</a>
                </li>

                <li class="pull-right">
                    <button type="submit" class="btn btn-default" id="sendEmail">Enviar
                        <i class="fa fa-arrow-circle-right"></i></button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane" id="tab_bimestralReport">
                    <p>Olá, @{{ Aluno }}, </p>
                    <p>Este é apenas um lembrete para que, durante a semana de provas, você protocole na secretaria do
                        colégio o seu <b>relatório bimestral de estágio</b>.
                        Caso o mesmo não seja entregue, estará sujeito às penalidades vigentes no código do estagiário.
                    </p>

                    <p>Possuindo problemas na entrega do relatório bimestral, comunique a coordenadoria do curso por
                        email com urgência.</p>

                    <p>Desconsidere essa mensagem caso já tenha protocolado seu relatório bimestral.</p>
                </div>

                <div class="tab-pane" id="tab_internshipProposal">
                    <table id="proposals" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th>Empresa</th>
                            <th>Descrição</th>
                            <th>Validade</th>
                            <th>Ações</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($proposals as $proposal)

                            <tr>
                                <th scope="row">{{ $proposal->id }}</th>
                                <td>{{ $proposal->company->name }} {{ $proposal->company->fantasy_name != null ? "(" . $proposal->company->fantasy_name . ")" : '' }}</td>
                                <td>{{ $proposal->description }}</td>
                                <td>{{ $proposal->deadline }}</td>

                                <td>
                                    <a href="#" onclick="proposal({{ $proposal->id }}); return false;">Selecionar</a>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane active gambi" id="tab_message">
                    <div class="form-group @if($errors->has('subject')) has-error @endif" id="inputSubject">
                        <input type="text" class="form-control" name="subject" placeholder="Assunto"
                               value="{{ old('subject') ?? '' }}">
                    </div>

                    <div class="form-group @if($errors->has('messageBody')) has-error @endif">
                        <textarea id="message" name="messageBody" class="textarea" placeholder="Mensagem"
                                  style="resize:none; width: 100%; height: 250px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{!! old('messageBody') ?? '' !!}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('#message').wysihtml5({
                locale: 'pt-BR'
            });

            jQuery('.selection').select2({
                language: "pt-BR"
            });

            jQuery('#filters a[data-toggle="tab"]').on('shown.bs.tab', e => {
                let target = jQuery(e.target).attr("href");
                if (target === '#tab_filters') {
                    jQuery('#inputUseFilters').val(1);
                } else if (target === '#tab_students') {
                    jQuery('#inputUseFilters').val(0);
                }
            });

            jQuery('#messageType a[data-toggle="tab"]').on('shown.bs.tab', e => {
                let target = jQuery(e.target).attr("href");
                if (target === '#tab_importantMessage') {
                    jQuery('#messageType a[href="#tab_message"]').tab('show');
                    jQuery('#messageType a[href="#tab_message"]').parent().removeClass('active');
                    jQuery('#messageType a[href="#tab_importantMessage"]').parent().addClass('active');
                    jQuery('#inputSubject').css('display', 'none');
                    jQuery('#inputMessage').val(2);
                } else if (target === '#tab_message') {
                    jQuery('#inputSubject').css('display', 'block');
                    jQuery('#inputMessage').val(3);
                } else if (target === '#tab_internshipProposal') {
                    jQuery('#inputMessage').val(1);
                } else if (target === '#tab_bimestralReport') {
                    jQuery('#inputMessage').val(0);
                }
            });

            @if(old('useFilters') ?? true)

            jQuery('#filters a[href="#tab_filters"]').tab('show');

            @else

            jQuery('#filters a[href="#tab_students"]').tab('show');

            @endif

            @if((old('message') ?? 3) == 0)

            jQuery('#messageType a[href="#tab_bimestralReport"]').tab('show');

            @elseif((old('message') ?? 3) == 1)

            jQuery('#messageType a[href="#tab_internshipProposal"]').tab('show');

            @elseif((old('message') ?? 3) == 2)

            jQuery('#messageType a[href="#tab_importantMessage"]').tab('show');

            @elseif((old('message') ?? 3) == 3)

            jQuery('#messageType a[href="#tab_message"]').tab('show');

            @endif

            jQuery("#proposals").DataTable({
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                },
                lengthChange: true,
            });
        });
    </script>
@endsection
