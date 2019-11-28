@extends('adminlte::page')

@section('title', 'Empresas (CTPS)')

@section('content_header')
    <h1>Empresas (CTPS)</h1>
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
            <a id="addLink" href="{{ route('coordenador.trabalho.empresa.novo') }}"
               class="btn btn-success">Adicionar empresa</a>

            <table id="jobCompanies" class="table table-bordered table-hover" data-order="[[ 1, &quot;asc&quot; ]]">
                <thead>
                <tr>
                    <th>CPF / CNPJ</th>
                    <th>Razão social</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($companies as $company)

                    <tr>
                        <td>{{ $company->formatted_cpf_cnpj }}</td>
                        <td>{{ $company->name }} {{ $company->fantasy_name != null ? " ($company->fantasy_name)" : '' }}</td>
                        <td>{{ ($company->active) ? 'Sim' : 'Não' }}</td>

                        <td>
                            <a href="{{ route('coordenador.trabalho.empresa.detalhes', ['id' => $company->id]) }}">Detalhes</a>
                            |
                            <a class="text-aqua"
                               href="{{ route('coordenador.trabalho.empresa.editar', ['id' => $company->id]) }}">Editar</a>
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
            let table = jQuery("#jobCompanies").DataTable({
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
                    table.buttons().container().appendTo(jQuery('#jobCompanies_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                    jQuery('#addLink').prependTo(table.buttons().container());
                },
            });
        });
    </script>
@endsection
