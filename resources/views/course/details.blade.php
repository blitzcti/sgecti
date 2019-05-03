@extends('adminlte::page')

@section('title', 'Detalhes do curso - SGE CTI')

@section('content_header')
    <h1>Detalhes do curso <a href="{{ route('curso.editar', ['id' => $course->id]) }}">{{ $course->name }}</a></h1>
@stop

@section('content')
    @include('course.deleteModal')

    <div class="box box-default">
        <div class="box-body">
            <div class="btn-group" style="display: inline-flex; margin: 0">
                <a href="{{ route('curso.editar', $course->id) }}"
                   class="btn btn-primary">Editar curso</a>

                <a href="{{ route('curso.configuracao.novo', $course->id) }}"
                   class="btn btn-success">Adicionar configuração</a>

                <a href="#" onclick="courseId('{{ $course->id }}'); course('{{ $course->name }}'); return false;"
                   data-toggle="modal" data-target="#deleteModal" class="btn btn-danger">Excluir curso</a>
            </div>

            <h3>Dados do curso</h3>
            <hr/>

            <dl class="row">
                <dt class="col-sm-2">Nome do curso</dt>
                <dd class="col-sm-10">{{ $course->name }}</dd>

                <dt class="col-sm-2">Cor do curso</dt>
                <dd class="col-sm-10">{{ __('colors.' . $color->name) }}</dd>

                <dt class="col-sm-2">Ativo</dt>
                <dd class="col-sm-10">{{ $course->active ? 'Sim' : 'Não' }}</dd>
            </dl>

            <h3>Configuração ativa do curso</h3>
            <hr/>

            @if ($config != null)

                <dl class="row">
                    <dt class="col-sm-2">Ano mínimo</dt>
                    <dd class="col-sm-10">{{ $config->min_year }}º ano</dd>

                    <dt class="col-sm-2">Semestre mínimo</dt>
                    <dd class="col-sm-10">{{ $config->min_semester }}º semestre</dd>

                    <dt class="col-sm-2">Horas mínimas</dt>
                    <dd class="col-sm-10">{{ $config->min_hours }}</dd>

                    <dt class="col-sm-2">Meses mínimos</dt>
                    <dd class="col-sm-10">{{ $config->min_months }}</dd>

                    <dt class="col-sm-2">Meses mínimos (CTPS)</dt>
                    <dd class="col-sm-10">{{ $config->min_months_ctps }}</dd>

                    <dt class="col-sm-2">Nota mínima</dt>
                    <dd class="col-sm-10">{{ $config->min_grade }}</dd>

                    <dt class="col-sm-2">Ativo desde</dt>
                    <dd class="col-sm-10">{{ date_format($config->created_at, "d/m/Y") }}</dd>
                </dl>

            @else

                <p>Não há configurações para este curso!</p>

            @endif
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('js')
    <script>
        function courseId(id) {
            jQuery(() => {
                jQuery('#deleteModalCourseId').val(id);
            });
        }

        function course(name) {
            jQuery(() => {
                jQuery('#deleteModalCourseName').text(name);
            });
        }
    </script>
@endsection
