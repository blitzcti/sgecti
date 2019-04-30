@extends('adminlte::page')

@section('title', 'Cursos - SGE CTI')

@section('content_header')
    <h1>Cursos</h1>
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
                <a href="{{ route('curso.novo') }}"
                   class="btn btn-default">Adicionar curso</a>
            </div>

            <table id="courses" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Nome</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($courses as $course)

                    <tr>
                        <th scope="row">{{ $course->id }}</th>
                        <td>{{ $course->name }}</td>
                        <td>{{ ($course->active) ? 'Sim' : 'Não' }}</td>

                        <td>
                            <a href="{{ route('curso.detalhes', ['id' => $course->id]) }}">Detalhes</a>
                            |
                            <a href="{{ route('curso.editar', ['id' => $course->id]) }}">Editar</a>
                            |
                            <a href="{{ route('curso.configuracao.index', ['id' => $course->id]) }}">Configurações</a>
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
        jQuery(function () {
            jQuery("#courses").DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>
@endsection
