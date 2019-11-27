@extends('adminlte::page')

@section('title', 'Relatórios - SGE CTI')

@section('content_header')
    <h1>Relatórios</h1>
@stop

@section('content')
    @include('modals.coordinator.report.bimestral.students')

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
        <div class="box-header with-border">
            <h3 class="box-title">Relatórios bimestrais</h3>
        </div>

        <div class="box-body">
            <a id="addBimestralLink" href="{{ route('coordenador.relatorio.bimestral.novo') }}"
               class="btn btn-success">Adicionar relatório</a>
            <a id="pdfBimestralLink" href="#" data-toggle="modal" data-target="#viewStudentsModal"
               class="btn btn-default" target="_blank">Não entregues</a>

            <table id="bimestralReports" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Data</th>
                    <th>Protocolo</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($bReports as $report)

                    <tr>
                        <td>{{ $report->internship->ra }} - {{ $report->internship->student->nome }}</td>

                        <td>{{ $report->date->format("d/m/Y") }}</td>
                        <td>{{ $report->formatted_protocol }}</td>
                        <td>
                            <a class="text-aqua"
                               href="{{ route('coordenador.relatorio.bimestral.editar', ['id' => $report->id]) }}">Editar</a>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Relatórios finais</h3>
        </div>

        <div class="box-body">
            <a id="addFinalLink" href="{{ route('coordenador.relatorio.final.novo') }}"
               class="btn btn-success">Adicionar relatório</a>

            <table id="finalReports" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Data</th>
                    <th>Nº de aprovação</th>
                    <th>Horas</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($fReports as $report)

                    <tr>
                        <td>{{ $report->internship->ra }} - {{ $report->internship->student->nome }}</td>

                        <td>{{ $report->date->format("d/m/Y") }}</td>
                        <td>{{ $report->approval_number }}</td>
                        <td>{{ $report->completed_hours }}</td>
                        <td>
                            <a class="text-aqua"
                               href="{{ route('coordenador.relatorio.final.editar', ['id' => $report->id]) }}">Editar</a>
                            |
                            <a href="#" onclick="pdf({{ $report->id }}); return false;" target="_blank">PDF</a>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    @if(session()->has('id') && session()->get('id'))
        <script type="text/javascript">
            pdf({{ session()->get('id') }});
        </script>
    @endif

    <script type="text/javascript">
        function pdf(id) {
            window.open(`{{ config('app.url') }}/coordenador/relatorio/final/${id}/pdf`, '_blank');
            window.open(`{{ config('app.url') }}/coordenador/relatorio/final/${id}/pdf2`, '_blank');
        }

        jQuery(document).ready(function () {
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                'Aluno-pre': function (a) {
                    return a.replace(/[\d]{7} - /g, '');
                },

                'Aluno-asc': function (a, b) {
                    return a - b;
                },

                'Aluno-desc': function (a, b) {
                    return b - a;
                }
            });

            let bimestralTable = jQuery("#bimestralReports").DataTable({
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                },
                responsive: true,
                lengthChange: false,
                aoColumns: [{sType: "Aluno"}, {sType: "Data"}, {sType: "Protocolo"}, {sType: "Ações"}],
                aaSorting: [[0, "asc"]],
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
                    bimestralTable.buttons().container().appendTo(jQuery('#bimestralReports_wrapper .col-sm-6:eq(0)'));
                    bimestralTable.buttons().container().addClass('btn-group');
                    jQuery('#pdfBimestralLink').prependTo(bimestralTable.buttons().container());
                    jQuery('#addBimestralLink').prependTo(bimestralTable.buttons().container());
                },
            });

            let finalTable = jQuery("#finalReports").DataTable({
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                },
                responsive: true,
                lengthChange: false,
                aoColumns: [{sType: "Aluno"}, {sType: "Data"}, {sType: "Nº de aprovação"}, {sType: "Horas"}, {sType: "Ações"}],
                aaSorting: [[0, "asc"]],
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
                    finalTable.buttons().container().appendTo(jQuery('#finalReports_wrapper .col-sm-6:eq(0)'));
                    finalTable.buttons().container().addClass('btn-group');
                    jQuery('#addFinalLink').prependTo(finalTable.buttons().container());
                },
            });
        });
    </script>
@endsection
