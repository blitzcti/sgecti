@extends('adminlte::page')

@section('title', 'Parâmetros do sistema - SGE CTI')

@section('content_header')
    <h1>Parâmetros do sistema</h1>
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
            <a id="addLink" href="{{ route('admin.configuracao.parametros.novo') }}"
               class="btn btn-success">Adicionar parâmetros</a>

            <table id="systemConfigurations" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>CEP</th>
                    <th>UF</th>
                    <th>Cidade</th>
                    <th>Endereço</th>
                    <th>Bairro</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>

                @foreach($configs as $config)

                    <tr>
                        <td>{{ $config->name }}</td>
                        <td>{{ $config->cep }}</td>
                        <td>{{ $config->uf }}</td>
                        <td>{{ $config->city }}</td>
                        <td>{{ "{$config->street}, nº {$config->number}" }}</td>
                        <td>{{ $config->district }}</td>
                        <td>{{ $config->email }}</td>

                        <td>
                            <a href="{{ route('admin.configuracao.parametros.editar', ['id' => $config->id]) }}">Editar</a>
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
            let table = jQuery("#systemConfigurations").DataTable({
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
                    table.buttons().container().appendTo(jQuery('#systemConfigurations_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                    jQuery('#addLink').prependTo(table.buttons().container());
                },
            });
        });
    </script>
@endsection
