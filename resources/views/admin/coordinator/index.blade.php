@extends('adminlte::page')

@section('title', 'Cursos - SGE CTI')

@section('content_header')
    <h1>Coordenador</h1>
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

    @include('admin.coordinator.deleteModal')

    <div class="box box-default">
        <div class="box-body">
            <div class="btn-group" style="display: inline-flex; margin: 0 0 10px 0">
                <a href="{{ route('admin.coordenador.novo') }}"
                   class="btn btn-success">Adicionar curso</a>
            </div>

            <table id="coordinators" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Nome</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($coordinators as $coordinator)

                    <tr>
                        <th scope="row">{{ $coordinator->id }}</th>
                        <td>{{ $coordinator->name }}</td>
                        <td>{{ ($coordinator->active) ? 'Sim' : 'Não' }}</td>

                        <td>
                            <a href="{{ route('admin.coordenador.detalhes', ['id' => $coordinator->id]) }}">Detalhes</a>
                            |
                            <a href="{{ route('admin.coordenador.editar', ['id' => $coordinator->id]) }}">Editar</a>
                            |
                            <a href="#">Coordenador</a>
                            |
                            <a href="{{ route('admin.coordenador.configuracao.index', ['id' => $coordinator->id]) }}">Configurações</a>
                            |
                            <a href="#"
                               onclick="coordinatorId('{{ $coordinator->id }}'); coordinator('{{ $coordinator->name }}'); return false;"
                               data-toggle="modal" class="text-red" data-target="#deleteModal">Excluir</a>
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
        function coordinatorId(id) {
            jQuery(() => {
                jQuery('#deleteModalcoordinatorId').val(id);
            });
        }

        function coordinator(name) {
            jQuery(() => {
                jQuery('#deleteModalcoordinatorName').text(name);
            });
        }

        jQuery(() => {
            jQuery("#coordinators").DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>
@endsection
