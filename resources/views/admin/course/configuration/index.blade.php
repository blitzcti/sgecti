@extends('adminlte::page')

@section('title', 'Configurações do curso - SGE CTI')

@section('content_header')
    <h1>Configurações do curso <a
                href="{{ route('admin.curso.detalhes', ['id' => $course->id]) }}">{{ $course->name }}</a></h1>
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
            <a id="addLink" href="{{ route('admin.curso.configuracao.novo', $course->id) }}"
               class="btn btn-success">Adicionar configuração</a>

            <table id="courseConfigurations" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Ano mínimo</th>
                    <th>Semestre mínimo</th>
                    <th>Horas mínimas</th>
                    <th>Meses mínimos</th>
                    <th>Meses mínimos (CTPS)</th>
                    <th>Nota mínima</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>

                @foreach($configurations as $configuration)

                    <tr>
                        <th scope="row">{{ $configuration->id }}</th>
                        <td>{{ $configuration->min_year }}</td>
                        <td>{{ $configuration->min_semester }}</td>
                        <td>{{ $configuration->min_hours }}</td>
                        <td>{{ $configuration->min_months }}</td>
                        <td>{{ $configuration->min_months_ctps }}</td>
                        <td>{{ $configuration->min_grade }}</td>

                        <td>
                            <a href="{{ route('admin.curso.configuracao.editar', ['id' => $course->id, 'id_config' => $configuration->id]) }}">Editar</a>
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
        jQuery(function () {
            let table = jQuery("#courseConfigurations").DataTable({
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
                    table.buttons().container().appendTo($('#courseConfigurations_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                    jQuery('#addLink').prependTo(table.buttons().container());
                },
            });
        });
    </script>
@endsection