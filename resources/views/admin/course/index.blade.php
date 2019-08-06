@extends('adminlte::page')

@section('title', 'Cursos - SGE CTI')

@section('content_header')
    <h1>Cursos</h1>
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

    @if(auth()->user()->can('course-delete'))

        @include('modals.admin.course.delete')

    @endif

    <div class="box box-default">
        <div class="box-body">
            <a id="addLink" href="{{ route('admin.curso.novo') }}" class="btn btn-success">Adicionar curso</a>

            <table id="courses" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Nome</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($courses as $course)

                    <tr>
                        <th scope="row">{{ $course->id }}</th>
                        <td>{{ $course->name }}</td>
                        <td>{{ ($course->active) ? 'Sim' : 'Não' }}</td>

                        <td>
                            <a href="{{ route('admin.curso.detalhes', ['id' => $course->id]) }}">Detalhes</a>
                            |
                            <a href="{{ route('admin.curso.editar', ['id' => $course->id]) }}">Editar</a>
                            |
                            <a href="{{ route('admin.curso.coordenador.index', ['id' => $course->id]) }}">Coordenadores</a>
                            |
                            <a href="{{ route('admin.curso.configuracao.index', ['id' => $course->id]) }}">Configurações</a>
                            @if(auth()->user()->can('course-delete'))
                                |
                                <a href="#"
                                   onclick="courseId('{{ $course->id }}'); course('{{ $course->name }}'); return false;"
                                   data-toggle="modal" class="text-red" data-target="#deleteModal">Excluir</a>
                            @endif
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function courseId(id) {
            jQuery(() => {
                jQuery('#deleteModalCourseId').val(id);
            });
        }

        function course(name) {
            jQuery(() => {
                jQuery('#deleteModalCourseName').text(name);
            });
        }

        jQuery(() => {
            let table = jQuery("#courses").DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                },
                lengthChange: false,
                buttons: [
                    {
                        extend: 'csv',
                        text: '<span class="glyphicon glyphicon-download-alt"></span> CSV',
                        charset: 'UTF-8',
                        fieldSeparator: ';',
                        bom: true,
                        className: 'btn btn-default',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        text: '<span class="glyphicon glyphicon-print"></span> Imprimir',
                        className: 'btn btn-default',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    }
                ],
                initComplete: function () {
                    table.buttons().container().appendTo($('#courses_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                    jQuery('#addLink').prependTo(table.buttons().container());
                },
            });
        });
    </script>
@endsection
