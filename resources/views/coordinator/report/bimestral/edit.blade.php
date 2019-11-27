@extends('adminlte::page')

@section('title', 'Editar relatório bimestral - SGE CTI')

@section('content_header')
    <h1>Editar relatório bimestral</h1>
@stop

@section('content')
    <form class="form-horizontal" action="{{ route('coordenador.relatorio.bimestral.alterar', $report->id) }}"
          method="post">
        @csrf
        @method('PUT')

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do relatório</h3>
            </div>

            <div class="box-body">
                <div class="form-group">
                    <label for="inputInternship" class="col-sm-2 control-label">Aluno*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control input-info" id="inputInternship" name="internship"
                               readonly
                               value="{{ $report->internship->ra }} - {{ $report->internship->student->nome }}"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('date')) has-error @endif">
                            <label for="inputDate" class="col-sm-4 control-label">Data*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputDate" name="date"
                                       value="{{ old('date') ?? $report->date }}"/>

                                <span class="help-block">{{ $errors->first('date') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('protocol')) has-error @endif">
                            <label for="inputProtocol" class="col-sm-4 control-label">Protocolo*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputProtocol" name="protocol"
                                       placeholder="001/2019" data-inputmask="'mask': '999/9999'"
                                       value="{{ old('protocol') ?? $report->protocol }}"/>

                                <span class="help-block">{{ $errors->first('protocol') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary pull-right">Sobre</button>

                <input type="hidden" id="inputPrevious" name="previous"
                       value="{{ old('previous') ?? url()->previous() }}">
                <a href="{{ old('previous') ?? url()->previous() }}" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery(':input').inputmask({removeMaskOnSubmit: true});

            jQuery('.selection').select2({
                language: "pt-BR"
            });
        });
    </script>
@endsection
