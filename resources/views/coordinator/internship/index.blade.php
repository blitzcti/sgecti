@extends('adminlte::page')

@section('title', 'Estágios - SGE CTI')

@section('content_header')
    <h1>Estágios</h1>
@stop

@section('content')
    @include('modals.coordinator.internship.cancel')
    @include('modals.coordinator.internship.reactivate')

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
            <a id="addLink" href="{{ route('coordenador.estagio.novo') }}"
               class="btn btn-success">Adicionar estágio</a>

            <table id="internships" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Aluno</th>
                    <th>Empresa</th>
                    <th>Coordenador</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($internships as $internship)

                    <tr>
                        <th scope="row">{{ $internship->id }}</th>

                        <td>{{ $internship->ra}}

                            @if((new \App\Models\NSac\Student)->isConnected())
                                {{ (' - ' . $internship->student->nome) ?? '' }}
                            @endif
                        </td>

                        <td>{{ $internship->company->name }} {{ $internship->company->fantasy_name != null ? "(" . $internship->company->fantasy_name . ")" : '' }}</td>
                        <td>{{ $internship->coordinator->user->name }}</td>
                        <td>{{ $internship->state->description }}</td>
                        <td>
                            <a href="{{ route('coordenador.estagio.detalhes', ['id' => $internship->id]) }}">Detalhes</a>
                            |
                            <a href="{{ route('coordenador.estagio.editar', ['id' => $internship->id]) }}">Editar</a>

                            @if(\App\Auth::user()->can('internshipAmendment-list'))
                                |
                                <a href="{{ route('coordenador.estagio.aditivo', ['id' => $internship->id]) }}">Termos
                                    aditivos</a>
                            @endif

                            @if($internship->state->id == 1)

                                |
                                <a href="#"
                                   onclick="internshipId('{{ $internship->id }}'); studentName('{{ $internship->student->nome }}'); return false;"
                                   data-toggle="modal" class="text-red"
                                   data-target="#internshipCancelModal">Cancelar</a>

                            @elseif($internship->state->id == 3 && $internship->student->internship == null)

                                |
                                <a href="#"
                                   onclick="reactivateInternshipId('{{ $internship->id }}'); reactivateStudentName('{{ $internship->student->nome }}'); return false;"
                                   data-toggle="modal" data-target="#internshipReactivateModal">Reativar</a>

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
    <script>
        jQuery(document).ready(function () {
            let table = jQuery("#internships").DataTable({
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
                    table.buttons().container().appendTo(jQuery('#internships_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                    jQuery('#addLink').prependTo(table.buttons().container());
                },
            });
        });
    </script>
@endsection
