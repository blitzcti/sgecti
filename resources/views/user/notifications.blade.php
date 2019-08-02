@extends('adminlte::page')

@section('title', 'Notificações - SGE CTI')

@section('content_header')
    <h1>Notificações</h1>
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
            <h3 class="box-title">Notificações</h3>
        </div>

        <div class="box-body">
            <table id="notifications" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Texto</th>
                    <th>Visto em</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($notifications as $notification)

                    <tr>
                        <td>{{ $notification->toArray()['data']['description'] }}</td>
                        <td>{{ $notification->toArray()['data']['text'] }}</td>
                        <td>{{ $notification->read_at }}</td>
                        <td>{{ $notification->created_at }}</td>

                        <td>
                            <a href="{{ route('api.usuario.notificacao.lida', ['id' => $notification->id]) }}">Marcar como lida</a>
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
            let table = jQuery("#notifications").DataTable({
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
                    table.buttons().container().appendTo($('#notifications_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                },
            });
        });
    </script>
@endsection
