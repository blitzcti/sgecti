@extends('adminlte::page')

@section('title', 'Detalhes da proposta de estágio - SGE CTI')

@section('content_header')
    <h1>Detalhes da proposta de estágio</h1>
@stop

@section('content')
    @include('modals.company.proposals.cancel')

    <div class="box box-default">
        <div class="box-body">
            <div class="btn-group" style="display: inline-flex; margin: 0">
                <a href="{{ route('empresa.proposta.editar', $proposal->id) }}"
                   class="btn btn-primary">Editar proposta</a>

                <a href="#"
                   onclick="proposalId('{{ $proposal->id }}'); return false;"
                   data-toggle="modal" class="btn btn-danger" data-target="#internshipReactivateModal">Excluir
                    proposta</a>
            </div>

            <h3>Dados da proposta</h3>

            <dl class="row">
                <dt class="col-sm-2">Empresa</dt>
                <dd class="col-sm-10">{{ $proposal->company->name }}</dd>

                <dt class="col-sm-2">Tipo de estágio</dt>
                <dd class="col-sm-10">{{ ($proposal->type == 1) ? "Estágio padrão" : "Iniciação Científica" }}</dd>

                <dt class="col-sm-2">Remuneração</dt>
                <dd class="col-sm-10">{{ $proposal->remuneration }}</dd>

                <dt class="col-sm-2">Descrição</dt>
                <dd class="col-sm-10">{{ $proposal->description }}</dd>

                <dt class="col-sm-2">Requisitos</dt>
                <dd class="col-sm-10">{{ $proposal->requirements }}</dd>

                <dt class="col-sm-2">Benefícios</dt>
                <dd class="col-sm-10">{{ $proposal->benefits }}</dd>

                <dt class="col-sm-2">Contato</dt>
                <dd class="col-sm-10">{{ $proposal->contact }}</dd>

                <dt class="col-sm-2">Data limite</dt>
                <dd class="col-sm-10">{{ $proposal->deadline }}</dd>

                @if($proposal->observation != null)

                    <dt class="col-sm-2">Data limite</dt>
                    <dd class="col-sm-10">{{ $proposal->deadline }}</dd>

                @endif
            </dl>

            <hr/>
            <h3>Cursos abrangentes</h3>

            <dl>
                @foreach($proposal->courses as $course)

                    <dt class="col-sm-12">{{ $course->name }}</dt>
                    <dd class="col-sm-0"></dd>

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
