@extends('adminlte::page')

@section('title', 'Propostas de estágio - SGE CTI')

@section('content_header')
    <h1>Propostas de estágio da empresa</h1>
@stop

@section('content')
    @include('modals.company.proposal.delete')

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
            <a id="addLink" href="{{ route('empresa.proposta.novo') }}" class="btn btn-success">Nova proposta</a>

            <table id="proposals" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Descrição</th>
                    <th>Data limite</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($proposals as $proposal)

                    <tr>
                        <th scope="row">{{ $proposal->id }}</th>
                        <td>{{ $proposal->description }}</td>
                        <td>{{ $proposal->deadline->format('d/m/Y') }}</td>

                        @if($proposal->deadline < \Carbon\Carbon::now())
                            <td>Expirada</td>
                        @elseif($proposal->approved_at != null)
                            <td>Aprovada</td>
                        @elseif($proposal->reason_to_reject != null)
                            <td>Requer alterações</td>
                        @else
                            <td>Pendente</td>
                        @endif

                        <td>
                            <a href="{{ route('empresa.proposta.detalhes', ['id' => $proposal->id]) }}">Detalhes</a>
                            |
                            <a href="{{ route('empresa.proposta.editar', ['id' => $proposal->id]) }}">Editar</a>
                            |
                            <a href="#"
                               onclick="deleteProposalId('{{ $proposal->id }}'); return false;"
                               data-toggle="modal" class="text-red"
                               data-target="#proposalDeleteModal">Excluir</a>
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
            let table = jQuery("#proposals").DataTable({
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
                    table.buttons().container().appendTo(jQuery('#proposals_wrapper .col-sm-6:eq(0)'));
                    table.buttons().container().addClass('btn-group');
                    jQuery('#addLink').prependTo(table.buttons().container());
                },
            });
        });
    </script>
@endsection
