@extends('adminlte::page')

@section('title', 'Termos aditivos - SGE CTI')

@section('content_header')
    <h1>Termos aditivos @if(isset($internship)) de {{ $internship->student->nome }} @endif</h1>
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

            @if(!isset($internship) || (isset($internship) && $internship->state->id == 1))

                <a id="addLink" class="btn btn-success"
                   href="{{ (isset($internship)) ? route('coordenador.estagio.aditivo.novo', ['i' => $internship->id]) : route('coordenador.estagio.aditivo.novo') }}">
                    Adicionar termo
                </a>

            @endif

            <table id="amendments" class="table table-bordered table-hover">
                <thead>
                <tr>
                    @if(!isset($internship))
                        <th>Aluno</th>
                        <th>Empresa</th>
                    @endif
                    <th>Alterou data de término</th>
                    <th>Alterou horário</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($amendments as $amendment)

                    <tr>
                        @if(!isset($internship))
                            <td>{{ $amendment->internship->ra }} - {{ $amendment->internship->student->nome }}</td>
                            <td>{{ $amendment->internship->company->formatted_cpf_cnpj }} - {{ $amendment->internship->company->name }} {{ $amendment->internship->company->fantasy_name != null ? "({$amendment->internship->company->fantasy_name})" : '' }}</td>
                        @endif
                        <td>{{ $amendment->end_date != null ? 'Sim' : 'Não' }}</td>
                        <td>{{ $amendment->schedule != null ? 'Sim' : 'Não' }}</td>
                        <td>
                            <a class="text-aqua"
                               href="{{ route('coordenador.estagio.aditivo.editar', ['id' => $amendment->id]) }}">Editar</a>
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
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                'Aluno-pre': function (a) {
                    return a.replace(/[\d]{7} - /g, '');
                },

                'Aluno-asc': function (a, b) {
                    return a - b;
                },

                'Aluno-desc': function (a, b) {
                    return b - a;
                },

                'Empresa-pre': function (a) {
                    return a.replace(/[\d]{2}\.[\d]{3}\.[\d]{3}\/[\d]{4}-[\d]{2} - /g, '').replace(/[\d]{3}\.[\d]{3}\.[\d]{3}-[\d]{2}/g, '');
                },

                'Empresa-asc': function (a, b) {
                    return a - b;
                },

                'Empresa-desc': function (a, b) {
                    return b - a;
                }
            });

            let table = jQuery("#amendments").DataTable({
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                },
                responsive: true,
                lengthChange: false,
                aoColumns: [@if(!isset($internship)){sType: "Aluno"}, {sType: "Empresa"}, @endif {sType: "Alterou_data_de_término"}, {sType: "Alterou_horário"}, {sType: "Ações"}],
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
                    table.buttons().container().appendTo(jQuery('#amendments_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                    jQuery('#addLink').prependTo(table.buttons().container());
                },
            });
        });
    </script>
@endsection
