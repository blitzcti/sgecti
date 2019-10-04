@extends('adminlte::page')

@section('title', 'Alunos que colaram ou não grau - SGE CTI')

@section('content_header')
    <h1>Alunos que colaram ou não grau</h1>
@stop

@section('content')
    @include('modals.admin.graduation.graduate')

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
            <table id="courses" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">RA</th>
                    <th>Nome</th>
                    <th>Turma/Ano</th>
                    <th>Graduado</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($students as $student)

                    <tr>
                        <th scope="row">{{ $student->matricula }}</th>
                        <td>{{ $student->nome }}</td>
                        <td>{{ $student->turma }}/{{ $student->turma_ano }}</td>
                        <td>{{ ($student->situacao_matricula == 5) ? 'Sim' : 'Não' }}</td>

                        <td>
                            <a href="#"
                               onclick="graduateStudent('{{ $student->matricula }}'); studentName('{{ $student->nome }}'); return false;"
                               data-toggle="modal" class="text-green" data-target="#graduateModal">Graudar</a>
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
        jQuery(document).ready(function () {
            let table = jQuery("#courses").DataTable({
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
                    table.buttons().container().appendTo(jQuery('#courses_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                    jQuery('#addLink').prependTo(table.buttons().container());
                },
            });
        });
    </script>
@endsection
