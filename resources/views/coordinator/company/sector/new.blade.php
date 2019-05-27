@extends('adminlte::page')

@section('title', 'Novo setor - SGE CTI')

@section('content_header')
    <h1>Adicionar novo setor</h1>
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
                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nome do setor*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name"
                               placeholder="Administrativo"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputDescription" class="col-sm-2 control-label">Descrição</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputDescription" name="description"
                               placeholder=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputActive" class="col-sm-2 control-label">Ativo*</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                id="inputActive" name="active">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Adicionar</button>
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
