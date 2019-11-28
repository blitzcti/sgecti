@extends('adminlte::page')

@section('title', 'Propostas de estágio')

@section('content_header')
    <h1>Propostas de estágio</h1>
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
            <table id="proposals" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Remuneração</th>
                    <th>Cursos</th>
                    <th>Data limite</th>
                    <th>Ações</th>
                </tr>
                </thead>

                <tbody>
                @foreach($proposals as $proposal)

                    <tr>
                        <td>{{ $proposal->company->name }} {{ $proposal->company->fantasy_name != null ? "({$proposal->company->fantasy_name})" : '' }}</td>
                        <td>{{ $proposal->remuneration > 0.0 ? 'R$' . number_format($proposal->remuneration, 2, ',', '.') : 'Sem' }}</td>
                        <td>{{ join(', ', $proposal->courses->map(function ($c) { return $c->name; })->toArray()) }}</td>
                        <td>{{ $proposal->deadline->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('aluno.proposta.detalhes', ['id' => $proposal->id]) }}">Detalhes</a>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            let table = jQuery("#proposals").DataTable({
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                },
                lengthChange: true,
            });
        });
    </script>
@endsection
