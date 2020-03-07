@extends('adminlte::page')

@section('title', 'Convênios')

@section('content_header')
    <h1>Convênios com o CTI @if(isset($company))
            de {{ $company->name }} {{ $company->fantasy_name != null ? " ($company->fantasy_name)" : '' }} @endif</h1>
@stop

@section('content')
    @include('modals.coordinator.company.agreement.cancel')
    @include('modals.coordinator.company.agreement.reactivate')

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
            <a id="addLink" class="btn btn-success"
               href="{{ (isset($company)) ? route('coordenador.empresa.convenio.novo', ['c' => $company->id]) : route('coordenador.empresa.convenio.novo') }}">
                Adicionar convênio
            </a>

            <table id="agreements" class="table table-bordered table-hover">
                <thead>
                <tr>
                    @if(!isset($company))
                        <th>Empresa</th>
                    @endif
                    <th>Início</th>
                    <th>Término</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>

                @foreach($agreements as $agreement)
                    <tr>
                        @if(!isset($company))
                            <td>{{ $agreement->company->formatted_cpf_cnpj }} - {{ $agreement->company->name }} {{ $agreement->company->fantasy_name != null ? "({$agreement->company->fantasy_name})" : '' }}</td>
                        @endif

                        <td>{{ $agreement->start_date->format("d/m/Y") }}</td>
                        <td>{{ $agreement->end_date->format("d/m/Y") }}</td>
                        <td>
                            <a class="text-aqua"
                               href="{{ route('coordenador.empresa.convenio.editar', ['id' => $agreement->id]) }}">Editar</a>

                            @if($agreement->active)
                                |
                                <a href="#"
                                   onclick="agreementId('{{ $agreement->id }}'); companyName('{{ $agreement->company->name }}'); return false;"
                                   data-toggle="modal" class="text-red"
                                   data-target="#agreementCancelModal">Cancelar</a>
                            @elseif(!$agreement->company->hasAgreementAt())
                                |
                                <a href="#"
                                   onclick="reactivateAgreementId('{{ $agreement->id }}'); reactivateCompanyName('{{ $agreement->company->name }}'); return false;"
                                   data-toggle="modal" data-target="#agreementReactivateModal">Reativar</a>
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
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                'Empresa-pre': function (a) {
                    return a.replace(/[\d]{2}\.[\d]{3}\.[\d]{3}\/[\d]{4}-[\d]{2} - /g, '').replace(/[\d]{3}\.[\d]{3}\.[\d]{3}-[\d]{2} - /g, '');
                },

                'Empresa-asc': function (a, b) {
                    return a - b;
                },

                'Empresa-desc': function (a, b) {
                    return b - a;
                }
            });

            let table = jQuery("#agreements").DataTable({
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                },
                responsive: true,
                lengthChange: false,
                aoColumns: [@if(!isset($company)){sType: "Empresa"}, @endif{sType: "Início"}, {sType: "Término"}, {sType: "Ações"}],
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
                    table.buttons().container().appendTo(jQuery('#agreements_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                    jQuery('#addLink').prependTo(table.buttons().container());
                },
            });
        });
    </script>
@endsection
