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
            <div class="btn-group" style="display: inline-flex; margin: 0 0 10px 0">
                <a href="{{ route('admin.configuracoes.parametros.novo') }}"
                   class="btn btn-success">Adicionar parâmetros</a>
            </div>

            <table id="systemConfigurations" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Nome</th>
                    <th>CEP</th>
                    <th>UF</th>
                    <th>Cidade</th>
                    <th>Endereço</th>
                    <th>Bairro</th>
                    <th>Email</th>
                    <th>Validade do convênio</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>

                @foreach($systemConfigs as $systemConfig)

                    <tr>
                        <th scope="row">{{ $systemConfig->id }}</th>
                        <td>{{ $systemConfig->nome }}</td>
                        <td>{{ $systemConfig->cep }}</td>
                        <td>{{ $systemConfig->uf }}</td>
                        <td>{{ $systemConfig->cidade }}</td>
                        <td>{{ $systemConfig->rua . ', nº ' .  $systemConfig->numero }}</td>
                        <td>{{ $systemConfig->bairro }}</td>
                        <td>{{ $systemConfig->email }}</td>
                        <td>{{ $systemConfig->validade_convenio }}</td>

                        <td>
                            <a href="{{ route('admin.configuracoes.parametros.editar', ['id' => $systemConfig->id]) }}">Editar</a>
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
            let table = jQuery("#systemConfigurations").DataTable({
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
                initComplete : function () {
                    table.buttons().container().appendTo( $('#systemConfigurations_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                },
            });
        });
    </script>
@endsection
