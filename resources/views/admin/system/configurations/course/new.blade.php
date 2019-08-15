@extends('adminlte::page')

@section('title', 'Editar configurações gerais de curso - SGE CTI')

@section('content_header')
    <h1>Editar configurações gerais de curso</h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Dados da configuração</h3>
        </div>

        <form class="form-horizontal" action="{{ route('admin.configuracao.curso.salvar') }}"
              method="post">
            @method('PUT')
            @csrf

            <div class="box-body">
                <div class="form-group @if($errors->has('maxYears')) has-error @endif">
                    <label for="inputMaxYears" class="col-sm-2 control-label">Anos máximos*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputMaxYears"
                               name="maxYears" placeholder="5" value="{{ old('maxYears') ?? '' }}"/>

                        <span class="help-block">{{ $errors->first('maxYears') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('startDate')) has-error @endif">
                            <label for="inputStartDate" class="col-sm-4 control-label">Data de início*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputStartDate" name="startDate"
                                       value="{{ old('startDate') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('startDate') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputEndDate" class="col-sm-4 control-label">Data de término*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputEndDate" name="endDate"
                                       value="{{ old('endDate') ?? '' }}">

                                <span class="help-block">{{ $errors->first('endDate') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                <a href="{{url()->previous()}}" class="btn btn-default">Cancelar</a>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(() => {
            jQuery(':input').inputmask({removeMaskOnSubmit: true});
        });
    </script>
@endsection

