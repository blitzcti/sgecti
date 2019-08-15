@extends('adminlte::page')

@section('title', 'Novo convênio - SGE CTI')

@section('content_header')
    <h1>Adicionar novo conênio</h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Dados do convênio</h3>
        </div>

        <form class="form-horizontal" action="{{ route('coordenador.empresa.convenio.salvar') }}" method="post">
            @csrf

            <div class="box-body">
                <div class="form-group @if($errors->has('company')) has-error @endif">
                    <label for="inputCompany" class="col-sm-2 control-label">Empresa conveniada*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="company" id="inputCompany"
                                style="width: 100%">

                            @foreach($companies as $company)

                                <option value="{{ $company->id }}" {{ (old('company') ?? 1) == $company->id ? 'selected=selected' : '' }}>
                                    {{ $company->name }}</option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('company') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('observation')) has-error @endif">
                    <label for="inputObservation" class="col-sm-2 control-label">Observação</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" id="inputObservation" name="observation" style="resize: none"
                                  placeholder="Observações adicionais">{{ old('observation') ?? '' }}</textarea>

                        <span class="help-block">{{ $errors->first('observation') }}</span>
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
