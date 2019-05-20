@extends('adminlte::page')

@section('title', 'Coordenadores - SGE CTI')

@section('content_header')
    <h1>Coordenadores</h1>
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
                <a href="{{ route('admin.coordenador.novo') }}"
                   class="btn btn-success">Adicionar coordenador</a>
            </div>

            <table id="coordinators" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Nome</th>
                    <th>Curso</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($coordinators as $coordinator)

                    <tr>
                        <th scope="row">{{ $coordinator->id }}</th>
                        <td><a href="{{ route('admin.usuario.editar', ['id' => $coordinator->id_user]) }}">{{ App\User::all()->find($coordinator->id_user)->name }}</a></td>
                        <td><a href="{{ route('admin.curso.editar', ['id' => $coordinator->id_course]) }}">{{ App\Course::all()->find($coordinator->id_course)->name }}</a></td>
                        <td>{{ $coordinator->vigencia_ini }}</td>
                        <td>{{ $coordinator->vigencia_fim }}</td>

                        <td>
                            <a href="{{ route('admin.coordenador.editar', ['id' => $coordinator->id]) }}">Editar</a>
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
            jQuery("#coordinators").DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>
@endsection
