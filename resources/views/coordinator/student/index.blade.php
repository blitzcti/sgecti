@extends('adminlte::page')

@section('title', 'Alunos - SGE CTI')

@section('content_header')
    <h1>Alunos</h1>
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

    <div class="box box-default">
        <div class="box-body">
            <table id="students" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>RA</th>
                    <th>Nome</th>
                    <th>Curso</th>
                    <th>Ano</th>
                    <th>Email</th>
                    <th>Email institucional</th>
                    <th data-priority="2">Ações</th>
                </tr>
                </thead>

                <tbody>

                @foreach($students as $student)

                    <tr>
                        <th scope="row">{{ $student->matricula }}</th>
                        <td>{{ $student->nome }}</td>
                        <td id="courseId">{{ $student->course->name }}</td>
                        <td>{{ $student->year }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->email2 }}</td>

                        <td>
                            <a href="{{ route('coordenador.aluno.detalhes', ['ra' => $student->matricula]) }}">Detalhes</a>
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(() => {
            let table = jQuery("#students").DataTable({
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                },
                responsive: true,
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
                    table.buttons().container().appendTo(jQuery('#students_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                },
            });
        });
    </script>
@endsection
