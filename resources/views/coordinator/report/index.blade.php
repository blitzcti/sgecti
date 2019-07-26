@extends('adminlte::page')

@section('title', 'Relatórios - SGE CTI')

@section('content_header')
    <h1>Relatórios</h1>
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
        <div class="box-header with-border">
            <h3 class="box-title">Relatórios bimestrais</h3>
        </div>

        <div class="box-body">
            <a id="addBimestralLink" href="{{ route('coordenador.relatorio.bimestral.novo') }}"
               class="btn btn-success">Adicionar relatório</a>

            <table id="bimestralReports" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Aluno</th>
                    <th>Data</th>
                    <th>Protocolo</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($bReports as $report)

                    <tr>
                        <th scope="row">{{ $report->id }}</th>
                        <td>{{ ((new \App\Models\NSac\Student)->isConnected()) ? $report->internship->student->nome : $report->internship->ra }}</td>
                        <td>{{ date("d/m/Y", strtotime($report->date)) }}</td>
                        <td>{{ $report->protocol }}</td>
                        <td>
                            <a href="{{ route('coordenador.relatorio.bimestral.editar', ['id' => $report->id]) }}">Editar</a>
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
                    <th scope="col">ID</th>
                    <th>Aluno</th>
                    <th>Data</th>
                    <th>Nota final</th>
                    <th>Horas</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($fReports as $report)

                    <tr>
                        <th scope="row">{{ $report->id }}</th>
                        <td>{{ ((new \App\Models\NSac\Student)->isConnected()) ? $$report->internship->student->nome : $report->internship->ra }}</td>
                        <td>{{ $report->date }}</td>
                        <td>{{ $report->final_grade }}</td>
                        <td>{{ $report->hours_completed }}</td>
                        <td>
                            <a href="{{ route('coordenador.relatorio.final.editar', ['id' => $report->id]) }}">Editar</a>
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
        jQuery(() => {
            let bimestralTable = jQuery("#bimestralReports").DataTable({
                language: {
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
                    bimestralTable.buttons().container().appendTo($('#bimestralReports_wrapper .col-sm-6:eq(0)'));
                    bimestralTable.buttons().container().addClass('btn-group');
                    jQuery('#addBimestralLink').prependTo(bimestralTable.buttons().container());
                },
            });

            let finalTable = jQuery("#finalReports").DataTable({
                language: {
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
                    finalTable.buttons().container().appendTo($('#finalReports_wrapper .col-sm-6:eq(0)'));
                    finalTable.buttons().container().addClass('btn-group');
                    jQuery('#addFinalLink').prependTo(finalTable.buttons().container());
                },
            });
        });
    </script>
@endsection
