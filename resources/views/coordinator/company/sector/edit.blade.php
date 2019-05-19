@extends('adminlte::page')

@section('title', 'Editar setor - SGE CTI')

@section('content_header')
    <h1>Editar setor</h1>
@stop

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="box box-default">
        <form class="form-horizontal" action="{{ route('coordenador.empresa.setor.salvar') }}" method="post">
            @csrf

            <div class="box-body">
                <h3>Dados do setor</h3>

                <input type="hidden" name="id" value="{{ $sector->id }}">

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nome do setor</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Administrativo"
                               value="{{ $sector->nome }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputDescription" class="col-sm-2 control-label">Descrição</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputDescription" name="description" placeholder=""
                               value="{{ $sector->descricao }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputActive" class="col-sm-2 control-label">Ativo</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                id="inputActive" name="active">
                            <option value="1" {{ $sector->ativo ? 'selected=selected' : '' }}>Sim</option>
                            <option value="0" {{! $sector->ativo ? 'selected=selected' : '' }}>Não</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Alterar</button>
                <button type="submit" name="cancel" class="btn btn-default">Cancelar</button>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('.selection').select2({
                language: "pt-BR"
            });
        });
    </script>
@endsection
