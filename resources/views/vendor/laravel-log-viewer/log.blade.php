@extends('adminlte::page')

@section('title', 'Logs - SGE CTI')

@section('content_header')
    <h1>Logs do sistema</h1>
@stop

@section('css')
    <style>
        #contentSidebar a {
            color: #555;
        }
    </style>
@stop

@section('content')
    <script type="text/javascript">
        document.body.classList.add('sidebar-collapse');
    </script>

    <div class="box box-default">
        <div class="box-body">

            @if(sizeof($logs) > 0)

                <div class="row">
                    <div class="col-sm-2" style="max-height: 500px">
                        <div id="contentSidebar" class="col mb-3">
                            <div class="list-group div-scroll">

                                @foreach($folders as $folder)

                                    <div class="list-group-item">
                                        <a href="?f={{ \Illuminate\Support\Facades\Crypt::encrypt($folder) }}">
                                            <span class="fa fa-folder"></span> {{ $folder }}
                                        </a>

                                        @if ($current_folder == $folder)

                                            <div class="list-group folder">

                                                @foreach($folder_files as $file)
                                                    <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}&f={{ \Illuminate\Support\Facades\Crypt::encrypt($folder) }}"
                                                       class="list-group-item @if ($current_file == $file) llv-active @endif">
                                                        {{ $file }}
                                                    </a>

                                                @endforeach
                                            </div>

                                        @endif
                                    </div>

                                @endforeach

                                @foreach($files as $file)

                                    <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
                                       class="list-group-item @if ($current_file == $file) llv-active @endif">
                                        {{ $file }}
                                    </a>

                                @endforeach
                            </div>
                        </div>
                    </div>

                    @endif

                    <div class="{{ (sizeof($logs) > 0) ? 'col-sm-10' : '' }} table-container">

                        @if ($logs === null)

                            <div>
                                Log >50M, por favor baixe-o.
                            </div>

                        @else

                            <table id="logs" class="table table-bordered table-hover"
                                   data-ordering-index="{{ $standardFormat ? 0 : 2 }}">
                                <thead>
                                <tr>

                                    @if ($standardFormat)

                                        <th>Data / hora</th>
                                        <th>Nível</th>
                                        <th>Contexto</th>

                                    @else

                                        <th>Linha</th>

                                    @endif

                                    <th>Conteúdo</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($logs as $key => $log)

                                    <tr data-display="stack{{ $key }}">

                                        <td class="date">{{  date("d/m/Y H:i:s", strtotime($log['date'])) }}</td>

                                        @if ($standardFormat)

                                            <td class="nowrap text-{{ $log['level_class'] }}">
                                            <span class="fa fa-{{ $log['level_img'] }}"
                                                  aria-hidden="true"></span>&nbsp;&nbsp;{{ $log['level'] }}
                                            </td>

                                            <td class="text">{{ $log['context'] }}</td>

                                        @endif

                                        <td class="text">

                                            @if ($log['stack'])

                                                <button type="button"
                                                        class="float-right expand btn btn-outline-dark btn-sm mb-2 ml-2"
                                                        data-display="stack{{ $key }}">
                                                    <span class="fa fa-search"></span>
                                                </button>

                                            @endif

                                            {{ $log['text'] }}

                                            @if (isset($log['in_file']))

                                                <br/>{{ $log['in_file'] }}

                                            @endif

                                            @if ($log['stack'])

                                                <div class="stack" id="stack{{ $key }}"
                                                     style="display: none; white-space: pre-wrap;">{{ trim($log['stack']) }}
                                                </div>

                                            @endif

                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>

                        @endif

                    </div>

                    @if(sizeof($logs) > 0)

                </div>

            @endif

        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(() => {
            jQuery('.table-container tr').on('click', function () {
                jQuery(`#${jQuery(this).data('display')}`).toggle();
            });

            jQuery('#contentSidebar').slimScroll({
                height: 'auto',
            });

            let table = jQuery('#logs').DataTable({
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                },
                order: [jQuery('#logs').data('orderingIndex'), 'desc'],
                stateSave: true,
                stateSaveCallback: function (settings, data) {
                    window.localStorage.setItem("datatable", JSON.stringify(data));
                },
                stateLoadCallback: function (settings) {
                    let data = JSON.parse(window.localStorage.getItem("datatable"));
                    if (data) {
                        data.start = 0;
                    }

                    return data;
                },
                scrollX: false,
                lengthChange: false,
                buttons: [

                        @if($current_file)

                    {
                        text: '<span class="fa fa-download"></span> Baixar log',
                        className: 'btn btn-default',
                        action: function (e, dt, node, config) {
                            window.location.replace(`?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_folder ? $current_folder . "/" . $current_file : $current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}`);
                        }
                    },
                    {
                        text: '<span class="fa fa-eraser"></span> Limpar log',
                        className: 'btn btn-default',
                        action: function (e, dt, node, config) {
                            if (confirm('Tem certeza?')) {
                                window.location.replace(`?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_folder ? $current_folder . "/" . $current_file : $current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}`);
                            }
                        }
                    },
                    {
                        text: '<span class="fa fa-trash"></span> Excluir log',
                        className: 'btn btn-default',
                        action: function (e, dt, node, config) {
                            if (confirm('Tem certeza?')) {
                                window.location.replace(`?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_folder ? $current_folder . "/" . $current_file : $current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}`);
                            }
                        }
                    },

                        @if(count($files) > 1)

                    {
                        text: '<span class="fa fa-recycle"></span> Excluir tudo',
                        className: 'btn btn-default',
                        action: function (e, dt, node, config) {
                            if (confirm('Tem certeza?')) {
                                window.location.replace(`?delall=true{{ ($current_folder) ? '&f=' . IlluminateSupportFacadesCrypt::encrypt($current_folder) : '' }}`);
                            }
                        }
                    }

                    @endif

                    @endif

                ],
                initComplete: function () {
                    table.buttons().container().appendTo($('#logs_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                },
            });
        });
    </script>
@endsection
