@extends('adminlte::page')

@section('title', 'Detalhes da empresa (CTPS)')

@section('content_header')
    <h1>Detalhes da empresa</h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-body">
            <div class="btn-group" style="display: inline-flex; margin: 0">
                <a href="{{ route('coordenador.trabalho.empresa.editar', $company->id) }}"
                   class="btn btn-primary">Editar empresa</a>
            </div>

            <h3>Dados da empresa</h3>

            <dl class="row">
                <dt class="col-sm-2">{{ ($company->pj) ? 'CNPJ' : 'CPF' }}</dt>
                <dd class="col-sm-10">{{ $company->formatted_cpf_cnpj }}</dd>

                <dt class="col-sm-2">Razão social</dt>
                <dd class="col-sm-10">{{ $company->name }}</dd>

                <dt class="col-sm-2">Nome fantasia</dt>
                <dd class="col-sm-10">{{ $company->fantasy_name ?? '(Não informado)' }}</dd>

                <dt class="col-sm-2">Ativo</dt>
                <dd class="col-sm-10">{{ $company->active ? 'Sim' : 'Não' }}</dd>

                <dt class="col-sm-2">Representante</dt>
                <dd class="col-sm-10">{{ $company->representative_name }}</dd>

                <dt class="col-sm-2">Cargo</dt>
                <dd class="col-sm-10">{{ $company->representative_role }}</dd>
            </dl>

            <hr/>
            <h3>Dados de trabalho</h3>

            <dl class="row">
                <dt class="col-sm-2">Trabalhos concluídos</dt>
                <dd class="col-sm-10">{{ sizeof($company->jobs->filter(function ($i) {return $i->state->id == 2;})) }}</dd>

                <dt class="col-sm-2">Trabalhos cancelados</dt>
                <dd class="col-sm-10">{{ sizeof($company->jobs->filter(function ($i) {return $i->state->id == 3;})) }}</dd>

                <dt class="col-sm-12">Alunos de:</dt>
                <dl class="col-sm-0"></dl>

                @foreach(App\Models\Course::all()->where('active', '=', true) as $course)

                    <dt class="col-sm-2"> {{ $course->name }}</dt>
                    <dd class="col-sm-10">{{ sizeof($company->jobs->filter(function ($i) use ($course) {return $i->student->course->id == $course->id;})) }}</dd>

                @endforeach
            </dl>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('js')
    <script type="text/javascript">

    </script>
@endsection
