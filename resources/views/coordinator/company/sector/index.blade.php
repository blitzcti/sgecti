@extends('adminlte::page')

@section('title', 'Setores empresariais - SGE CTI')

@section('content_header')
    <h1>Setores empresariais</h1>
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
                <a href="{{ route('coordenador.empresa.setor.novo') }}"
                   class="btn btn-success">Adicionar setor</a>
            </div>

            <table id="sectors" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($sectors as $sector)

                    <tr>
                        <th scope="row">{{ $sector->id }}</th>
                        <td>{{ $sector->nome }}</td>
                        <td>{{ $sector->descricao }}</td>
                        <td>{{ ($sector->ativo) ? 'Sim' : 'Não' }}</td>

                        <td>
                            <a href="{{ route('coordenador.empresa.setor.editar', ['id' => $sector->id]) }}">Editar</a>
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
            jQuery("#sectors").DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>
@endsection
