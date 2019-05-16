@extends('adminlte::page')

@section('title', 'Empresas - SGE CTI')

@section('content_header')
    <h1>Empresas</h1>
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
                <a href="{{ route('coordenador.empresa.novo') }}"
                   class="btn btn-success">Adicionar empresa</a>
            </div>

            <table id="companies" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>CPF / CNPJ</th>
                    <th>Nome</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($companies as $company)

                    <tr>
                        <th scope="row">{{ $company->id }}</th>
                        <td>{{ $company->cpf_cnpj }}</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ ($company->active) ? 'Sim' : 'Não' }}</td>

                        <td>
                            <a href="{{ route('coordenador.empresa.editar', ['id' => $company->id]) }}">Editar</a>
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
            jQuery("#companies").DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>
@endsection
