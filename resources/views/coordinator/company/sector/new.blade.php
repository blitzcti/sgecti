@extends('adminlte::page')

@section('title', 'Novo setor - SGE CTI')

@section('content_header')
    <h1>Adicionar novo setor</h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Dados do setor</h3>
        </div>

        <form class="form-horizontal" action="{{ route('coordenador.empresa.setor.salvar') }}" method="post">
            @csrf

            <div class="box-body">
                <div class="form-group @if($errors->has('name')) has-error @endif">
                    <label for="inputName" class="col-sm-2 control-label">Nome*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name"
                               placeholder="Administrativo" value="{{ old('name') ?? '' }}"/>

                        <span class="help-block">{{ $errors->first('name') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('description')) has-error @endif">
                    <label for="inputDescription" class="col-sm-2 control-label">Descrição</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" id="inputDescription" name="description"
                                  style="resize: none"
                                  placeholder="Descrição do setor">{{ old('description') ?? '' }}</textarea>

                        <span class="help-block">{{ $errors->first('description') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('active')) has-error @endif">
                    <label for="inputActive" class="col-sm-2 control-label">Ativo*</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                id="inputActive" name="active">
                            <option value="1" {{ (old('active') ?? 1) ? 'selected=selected' : '' }}>Sim</option>
                            <option value="0" {{ !(old('active') ?? 1) ? 'selected=selected' : '' }}>Não</option>
                        </select>

                        <span class="help-block">{{ $errors->first('active') }}</span>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Adicionar</button>
                <a href="{{url()->previous()}}" class="btn btn-default">Cancelar</a>
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
