@extends('adminlte::page')

@section('title', 'Detalhes do aluno - SGE CTI')

@section('content_header')
    <h1>Detalhes do aluno {{ $student->nome }}</h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-body">
            <div class="btn-group" style="display: inline-flex; margin: 0">
                @if($internship != null)
                    <a href="{{ route('coordenador.estagio.editar', $internship->id) }}"
                       class="btn btn-primary">Editar estágio</a>

                    <a href="{{ route('coordenador.relatorio.bimestral.novo', ['i' => $internship->id]) }}"
                       class="btn btn-success">Adicionar relatório bimestral</a>

                    <a href="{{ route('coordenador.relatorio.final.novo', ['i' => $internship->id]) }}"
                       class="btn btn-success">Adicionar relatório final</a>

                @else

                    <a href="{{ route('coordenador.estagio.novo', ['s' => $student->matricula]) }}"
                       class="btn btn-success">Novo estágio</a>

                @endif
            </div>

            <h3>Dados do aluno</h3>

            <dl class="row">
                <dt class="col-sm-2">RA</dt>
                <dd class="col-sm-10">{{ $student->matricula }}</dd>

                <dt class="col-sm-2">Nome</dt>
                <dd class="col-sm-10">{{ $student->nome }}</dd>

                <dt class="col-sm-2">Curso</dt>
                <dd class="col-sm-10">{{ $student->course->name }}</dd>

                <dt class="col-sm-2">Ano</dt>
                <dd class="col-sm-10">{{ $student->year }}</dd>

                <dt class="col-sm-2">Email</dt>
                <dd class="col-sm-10">{{ $student->email }}</dd>

                <dt class="col-sm-2">Email 2</dt>
                <dd class="col-sm-10">{{ $student->email2 }}</dd>
            </dl>

            <hr/>
            <h3>Estágio ativo do aluno</h3>

            @if ($internship != null)

                <dl class="row">
                    <dt class="col-sm-2">Empresa</dt>
                    <dd class="col-sm-10">{{ $internship->company->name }}</dd>

                    <dt class="col-sm-2">Setor</dt>
                    <dd class="col-sm-10">{{ $internship->sector->name }}</dd>

                    <dt class="col-sm-2">Supervisor</dt>
                    <dd class="col-sm-10">{{ $internship->supervisor->name }}</dd>

                    <dt class="col-sm-2">Data de início</dt>
                    <dd class="col-sm-10">{{ date("d/m/Y", strtotime($internship->start_date)) }}</dd>

                    <dt class="col-sm-2">Data de término</dt>
                    <dd class="col-sm-10">{{ date("d/m/Y", strtotime($internship->end_date)) }}</dd>

                    <dt class="col-sm-2">Horas estimadas</dt>
                    <dd class="col-sm-10">{{ $internship->estimatedHours() }}</dd>
                </dl>

            @else

                <p>Não há um estágio para esse aluno!</p>

            @endif
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('js')
    <script type="text/javascript">

    </script>
@endsection
