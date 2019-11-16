@extends('adminlte::page')

@section('title', 'Trabalhos - SGE CTI')

@section('content_header')
    <h1>Trabalhos</h1>
@stop

@section('content')
    @include('modals.coordinator.job.cancel')
    @include('modals.coordinator.job.reactivate')

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
            <a id="addLink" href="{{ route('coordenador.trabalho.novo') }}"
               class="btn btn-success">Adicionar trabalho</a>

            <table id="jobs" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Empresa</th>
                    <th>Coordenador</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($jobs as $job)

                    <tr>
                        <td>{{ $job->ra }} - {{ $job->student->nome }}</td>

                        <td>{{ $job->company->formatted_cpf_cnpj }} - {{ $job->company->name }} {{ $job->company->fantasy_name != null ? "({$job->company->fantasy_name})" : '' }}</td>
                        <td>{{ $job->coordinator->user->name }}</td>
                        <td>{{ $job->state->description }}</td>
                        <td>
                            <a href="{{ route('coordenador.trabalho.detalhes', ['id' => $job->id]) }}">Detalhes</a>
                            |
                            <a class="text-aqua"
                               href="{{ route('coordenador.trabalho.editar', ['id' => $job->id]) }}">Editar</a>

                            @if($job->state->id == \App\Models\State::FINISHED)

                                |
                                <a href="#"
                                   onclick="jobId('{{ $job->id }}'); studentName('{{ $job->student->nome }}'); return false;"
                                   data-toggle="modal" class="text-red" data-target="#jobCancelModal">Cancelar</a>

                            @elseif($job->state->id == \App\Models\State::CANCELED && $job->student->job == null)

                                |
                                <a href="#"
                                   onclick="reactivateJobId('{{ $job->id }}'); reactivateStudentName('{{ $job->student->nome }}'); return false;"
                                   data-toggle="modal" data-target="#jobReactivateModal">Reativar</a>

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

            let table = jQuery("#jobs").DataTable({
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                },
                responsive: true,
                lengthChange: false,
                aoColumns: [{sType: "Aluno"}, {sType: "Empresa"}, {sType: "Coordenador"}, {sType: "Estado"}, {sType: "Ações"}],
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
                    table.buttons().container().appendTo(jQuery('#jobs_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                    jQuery('#addLink').prependTo(table.buttons().container());
                },
            });
        });
    </script>
@endsection
