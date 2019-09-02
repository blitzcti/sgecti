@extends('adminlte::page')

@section('title', 'Editar convênio - SGE CTI')

@section('content_header')
    <h1>Editar convênio</h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Dados do convênio</h3>
        </div>

        <form class="form-horizontal" action="{{ route('coordenador.empresa.convenio.alterar', $agreement->id) }}"
              method="post">
            @method('PUT')
            @csrf

            <input type="hidden" id="inputCanceled" name="canceled" value="{{ old('canceled') ?? 0 }}"/>

            <div class="box-body">
                <div class="form-group @if($errors->has('companyName')) has-error @endif">
                    <label for="inputCompanyName" class="col-sm-2 control-label">Empresa conveniada*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control input-info" id="inputCompanyName" name="companyName"
                               readonly
                               value="{{ $agreement->company->cpf_cnpj }} - {{ $agreement->company->name }} {{ $agreement->company->fantasy_name != null ? " (" . $agreement->company->fantasy_name . ")" : '' }}"/>
                    </div>
                </div>

                <div class="form-group @if($errors->has('startDate')) has-error @endif">
                    <label for="inputStartDate" class="col-sm-2 control-label">Data de início*</label>

                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="inputStartDate" name="startDate"
                               value="{{ old('startDate') ?? $agreement->start_date }}"/>

                        <span class="help-block">{{ $errors->first('startDate') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('observation')) has-error @endif">
                    <label for="inputObservation" class="col-sm-2 control-label">Observações</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" id="inputObservation" name="observation"
                                  style="resize: none"
                                  placeholder="Observações adicionais">{{ old('observation') ?? $internship->observation ?? '' }}</textarea>

                        <span class="help-block">{{ $errors->first('observation') }}</span>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="btn-group pull-right">
                    <button id="btnCancelAgreement" type="button" class="btn btn-danger">Cancelar convênio</button>
                    <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                </div>

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

            jQuery('#btnCancelAgreement').on('click', () => {
                jQuery('#inputCanceled').val(1);
            });
        });
    </script>
@endsection
