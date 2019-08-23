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

        <form class="form-horizontal" action="{{ route('coordenador.empresa.convenio.alterar', $agreement->id) }}" method="post">
            @method('PUT')
            @csrf

            <div class="box-body">
                <div class="form-group @if($errors->has('companyName')) has-error @endif">
                    <label for="inputCompanyName" class="col-sm-2 control-label">Empresa conveniada*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control input-info" id="inputCompanyName" name="companyName"
                               value="{{ $agreement->company->name }}" readonly/>
                    </div>
                </div>

                <div class="form-group @if($errors->has('expirationDate')) has-error @endif">
                    <label for="inputExpirationDate" class="col-sm-2 control-label">Validade*</label>

                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="date" class="form-control input-info" id="inputExpirationDate" name="expirationDate"
                                   value="{{ old('expirationDate') ?? $agreement->expiration_date }}" readonly/>

                            <span class="input-group-btn">
                                <button id="btnCancelAgreement" type="button"
                                        class="btn btn-danger">Cancelar convênio</button>
                            </span>
                        </div>

                        <span class="help-block">{{ $errors->first('expirationDate') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('observation')) has-error @endif">
                    <label for="inputObservation" class="col-sm-2 control-label">Observação</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" id="inputObservation" name="observation" style="resize: none"
                                  placeholder="Observações adicionais">{{ old('observation') ?? $internship->observation ?? '' }}</textarea>

                        <span class="help-block">{{ $errors->first('observation') }}</span>
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
        jQuery(document).ready(function () {
            jQuery('.selection').select2({
                language: "pt-BR"
            });

            jQuery('#btnCancelAgreement').on('click', () => {
                jQuery('#inputExpirationDate').val('{{ date("Y-m-d") }}');
            });
        });
    </script>
@endsection
