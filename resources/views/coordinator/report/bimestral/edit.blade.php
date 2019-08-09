@extends('adminlte::page')

@section('title', 'Editar relatório bimestral - SGE CTI')

@section('content_header')
    <h1>Editar relatório bimestral</h1>
@stop

@section('content')
    <form class="form-horizontal" action="{{ route('coordenador.relatorio.bimestral.alterar', $report->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do relatório</h3>
            </div>

            <div class="box-body">
                <div class="form-group @if($errors->has('internship')) has-error @endif">
                    <label for="inputInternship" class="col-sm-2 control-label">Nome do aluno*</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" id="inputInternship" name="internship">

                            @foreach($internships as $internship)

                                <option value="{{ $internship->id }}"
                                        {{ (old('internship') ?? $report->internship->id) == $internship->id ? 'selected=selected' : '' }}>
                                    {{ $internship->student->nome }}
                                </option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('internship') }}</span>
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
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('protocol')) has-error @endif">
                            <label for="inputProtocol" class="col-sm-4 control-label">Protocolo*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputProtocol" name="protocol"
                                       placeholder="001/19" data-inputmask="'mask': '999/99'"
                                       value="{{ old('protocol') ?? $report->protocol }}"/>

                                <span class="help-block">{{ $errors->first('protocol') }}</span>
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
