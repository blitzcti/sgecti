@extends('adminlte::page')

@section('title', 'Supervisores')

@section('content_header')
    <h1>Supervisores @if(isset($company))
            de {{ $company->name }} {{ $company->fantasy_name != null ? " ($company->fantasy_name)" : '' }} @endif</h1>
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
            <a id="addLink" class="btn btn-success"
               href="{{ (isset($company)) ? route('coordenador.empresa.supervisor.novo', ['c' => $company->id]) : route('coordenador.empresa.supervisor.novo') }}">
                Adicionar supervisor
            </a>

            <table id="supervisors" class="table table-bordered table-hover" data-order="[[ 1, &quot;asc&quot; ]]">
                <thead>
                <tr>
                    @if(!isset($company))
                        <th>Empresa</th>
                    @endif
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($supervisors as $supervisor)
                    <tr>
                        @if(!isset($company))
                            <td>{{ $supervisor->company->formatted_cpf_cnpj }} - {{ $supervisor->company->name }} {{ $supervisor->company->fantasy_name != null ? "({$supervisor->company->fantasy_name})" : '' }}</td>
                        @endif

                        <td>{{ $supervisor->name }}</td>
                        <td>{{ $supervisor->email }}</td>

                        <td>
                            <a class="text-aqua"
                               href="{{ route('coordenador.empresa.supervisor.editar', ['id' => $supervisor->id]) }}">Editar</a>
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

            let table = jQuery("#supervisors").DataTable({
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                },
                responsive: true,
                lengthChange: false,
                aoColumns: [@if(!isset($company)){sType: "Empresa"}, @endif{sType: "Nome"}, {sType: "Email"}, {sType: "Ações"}],
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
                    table.buttons().container().appendTo(jQuery('#supervisors_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                    jQuery('#addLink').prependTo(table.buttons().container());
                },
            });
        });
    </script>
@endsection
