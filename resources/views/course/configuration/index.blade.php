@extends('adminlte::page')

@section('title', 'Configurações do curso - SGE CTI')

@section('content_header')
    <h1>Configurações do curso <a href="{{ route('curso.detalhes', ['id' => $course->id]) }}">{{ $course->name }}</a></h1>
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
                <a href="{{ route('curso.configuracao.novo', $course->id) }}"
                   class="btn btn-success">Adicionar configuração</a>
            </div>

            <table id="courseConfigurations" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Ano mínimo</th>
                    <th>Semestre mínimo</th>
                    <th>Horas mínimas</th>
                    <th>Meses mínimos</th>
                    <th>Meses mínimos (CTPS)</th>
                    <th>Nota mínima</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>

                @foreach($configurations as $configuration)

                    <tr>
                        <th scope="row">{{ $configuration->id }}</th>
                        <td>{{ $configuration->min_year }}</td>
                        <td>{{ $configuration->min_semester }}</td>
                        <td>{{ $configuration->min_hours }}</td>
                        <td>{{ $configuration->min_months }}</td>
                        <td>{{ $configuration->min_months_ctps }}</td>
                        <td>{{ $configuration->min_grade }}</td>

                        <td>
                            <a href="{{ route('curso.configuracao.editar', ['id' => $course->id, 'id_config' => $configuration->id]) }}">Editar</a>
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
            jQuery("#courseConfigurations").DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>
@endsection
