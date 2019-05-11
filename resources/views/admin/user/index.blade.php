@extends('adminlte::page')

@section('title', 'Usuários - SGE CTI')

@section('content_header')
    <h1>Usuários</h1>
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


            <table id="users" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Nome</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($users as $user)

                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ ($user->active) ? 'Sim' : 'Não' }}</td>

                        <td>
                            <a href="{{ route('admin.usuario.detalhes', ['id' => $user->id]) }}">Detalhes</a>
                            |
                            <a href="{{ route('admin.usuario.editar', ['id' => $user->id]) }}">Editar</a>
                            |
                            <a href="#"
                               onclick="userId('{{ $user->id }}'); user('{{ $user->name }}'); return false;"
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
        function userId(id) {
            jQuery(() => {
                jQuery('#deleteModaluserId').val(id);
            });
        }

        function user(name) {
            jQuery(() => {
                jQuery('#deleteModaluserName').text(name);
            });
        }

        jQuery(() => {
            jQuery("#users").DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>
@endsection
