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
            <a id="addLink" href="{{ route('coordenador.estagio.aditivo.novo') }}"
               class="btn btn-success">Adicionar termo</a>

            <table id="amendments" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Aluno</th>
                    <th>Empresa</th>
                    <th>Data de início</th>
                    <th>Data de término</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($amendments as $amendment)

                    <tr>
                        <th scope="row">{{ $amendment->id }}</th>

                        <td>{{ $amendment->internship->ra}}

                            @if((new \App\Models\NSac\Student)->isConnected())
                                {{ (' - ' . $amendment->internship->student->nome) ?? '' }}
                            @endif
                        </td>

                        <td>{{ $amendment->internship->company->name }}</td>
                        <td>{{ date("d/m/Y", strtotime($amendment->start_date)) }}</td>
                        <td>{{ date("d/m/Y", strtotime($amendment->end_date)) }}</td>
                        <td>
                            <a href="{{ route('coordenador.estagio.aditivo.editar', ['id' => $amendment->id]) }}">Editar</a>
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
            let table = jQuery("#amendments").DataTable({
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
                    table.buttons().container().appendTo($('#amendments_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                    jQuery('#addLink').prependTo(table.buttons().container());
                },
            });
        });
    </script>
@endsection
