@extends('adminlte::page')

@section('title', 'Grupos - SGE CTI')

@section('content_header')
    <h1>Grupos</h1>
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
                <a href="{{ route('admin.curso.novo') }}"
                   class="btn btn-success">Novo</a>
            </div>


            <table id="userGroups" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Nome</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($userGroups as $userGroup)

                    <tr>
                        <th scope="row">{{ $userGroup->id }}</th>
                        <td>{{ $userGroup->name }}</td>
                        <td>{{ ($userGroup->active) ? 'Sim' : 'Não' }}</td>

                        <td>
                            <a href="{{ route('admin.usuario.detalhes', ['id' => $userGroup->id]) }}">Detalhes</a>
                            |
                            <a href="{{ route('admin.usuario.editar', ['id' => $userGroup->id]) }}">Editar</a>
                            |
                            <a href="#"
                               onclick="userGroupId('{{ $userGroup->id }}'); userGroup('{{ $userGroup->name }}'); return false;"
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
        function userGroupId(id) {
            jQuery(() => {
                jQuery('#deleteModaluserGroupId').val(id);
            });
        }

        function userGroup(name) {
            jQuery(() => {
                jQuery('#deleteModaluserGroupName').text(name);
            });
        }

        jQuery(() => {
            jQuery("#userGroups").DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>
@endsection
