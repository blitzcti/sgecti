@extends('adminlte::page')

@section('title', 'Detalhes da empresa - SGE CTI')

@section('content_header')
    <h1>Detalhes da empresa</h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-body">
            <div class="btn-group" style="display: inline-flex; margin: 0">
                <a href="{{ route('coordenador.empresa.editar', $company->id) }}"
                   class="btn btn-primary">Editar empresa</a>

                <a href="{{ route('coordenador.empresa.supervisor', $company->id) }}"
                   class="btn btn-default">Supervisores</a>

                <a href="{{ route('coordenador.empresa.convenio', $company->id) }}"
                   class="btn btn-default">Convênios</a>
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

                <dt class="col-sm-2">Email</dt>
                <dd class="col-sm-10">{{ $company->email ?? '(Não informado)' }}</dd>

                <dt class="col-sm-2">Telefone</dt>
                <dd class="col-sm-10">{{ $company->formatted_phone ?? '(Não informado)' }}</dd>

                <dt class="col-sm-2">Representante</dt>
                <dd class="col-sm-10">{{ $company->representative_name }}</dd>

                <dt class="col-sm-2">Cargo</dt>
                <dd class="col-sm-10">{{ $company->representative_role }}</dd>
            </dl>

            <hr/>
            <h3>Endereço da empresa</h3>

            <dl class="row">
                <dt class="col-sm-2">CEP</dt>
                <dd class="col-sm-10">{{ $address->formatted_cep }}</dd>

                <dt class="col-sm-2">UF</dt>
                <dd class="col-sm-10">{{ $address->uf }}</dd>

                <dt class="col-sm-2">Cidade</dt>
                <dd class="col-sm-10">{{ $address->city }}</dd>

                <dt class="col-sm-2">Rua</dt>
                <dd class="col-sm-10">{{ $address->street }}</dd>

                <dt class="col-sm-2">Número</dt>
                <dd class="col-sm-10">{{ $address->number }}</dd>

                <dt class="col-sm-2">Complemento</dt>
                <dd class="col-sm-10">{{ $address->complement ?? '(Não informado)' }}</dd>

                <dt class="col-sm-2">Bairro</dt>
                <dd class="col-sm-10">{{ $address->district }}</dd>
            </dl>

            <hr/>
            <h3>Dados de estágio</h3>

            <dl class="row">
                <dt class="col-sm-2">Alunos estagiando</dt>
                <dd class="col-sm-10">{{ sizeof($company->internships->filter(function ($i) {return $i->state->id == 1;})) }}</dd>

                <dt class="col-sm-2">Estágios concluídos</dt>
                <dd class="col-sm-10">{{ sizeof($company->internships->filter(function ($i) {return $i->state->id == 2;})) }}</dd>

                <dt class="col-sm-12">Alunos de:</dt>
                <dl class="col-sm-0"></dl>

                @foreach($company->courses as $course)

                    <dt class="col-sm-2"> {{ $course->name }}</dt>
                    <dd class="col-sm-10">{{ sizeof($company->internships->filter(function ($i) use ($course) {return $i->student->course->id == $course->id;})) }}</dd>

                @endforeach
            </dl>

            <div class="btn-group">
                <a href="{{ route('coordenador.empresa.pdf', ['id' => $company->id]) }}"
                   target="_blank" class="btn btn-default">Imprimir relatório</a>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('js')
    <script type="text/javascript">

    </script>
@endsection
