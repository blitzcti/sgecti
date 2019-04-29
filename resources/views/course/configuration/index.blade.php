@extends('adminlte::page')

@section('title', 'Configurações do curso - SGE CTI')

@section('content_header')
    <h1>Configurações do curso <a href="{{ route('curso.editar', ['id' => $course->id]) }}">{{ $course->name }}</a></h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-body">
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
                        <td>{{ $configuration->min_months->ctps }}</td>
                        <td>{{ $configuration->min_grade }}</td>

                        <td>
                            <a href="curso/{{ $course->id }}/editar">Editar</a>
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
            jQuery("#courses").DataTable();
        });
    </script>
@endsection
