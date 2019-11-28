@extends('adminlte::page')

@section('title', 'Backup e restauração')

@section('content_header')
    <h1>Backup e restauração</h1>
@stop

@section('content')
    <div class="modal fade" id="restaurarModal" tabindex="-1" role="dialog"
         aria-labelledby="restaurarModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="formRestaurar" class="form-horizontal"
                      action="{{ route('admin.configuracao.backup.restaurar') }}"
                      method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <h4 class="modal-title" id="deleteModalTitle">Restaurar de arquivo</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group @if($errors->has('file')) has-error @endif">
                            <label for="inputSectorName" class="col-sm-3 control-label">Arquivo</label>

                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="inputFile" name="file" accept=".json,.zip"/>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary pull-right">Restaurar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


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
        <div class="box-header with-border">
            <h3 class="box-title">Fazer backup / restaurar</h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-sm-6 text-center">
                    <p>Baixe o banco de dados em formato JSON</p>

                    <a href="{{ route('admin.configuracao.backup.download') }}" class="btn btn-success">
                        <span class="fa fa-download"></span> Fazer backup</a>
                </div>

                <div class="col-sm-6 text-center">
                    <p>Restaure o banco de dados de um arquivo JSON</p>

                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#restaurarModal">
                        <span class="fa fa-upload"></span> Restaurar</a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.configuracao.backup.salvarConfig') }}" method="post">
        @csrf
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Agendar backup</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group  @if($errors->has('days')) has-error @endif">
                            <label for="weekDays" class="control-label">Dias da semana</label>

                            <table id="weekDays" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>
                                        <label for="inputSunday" class="control-label">Dom</label>
                                    </th>

                                    <th>
                                        <label for="inputMonday" class="control-label">Seg</label>
                                    </th>

                                    <th>
                                        <label for="inputTuesday" class="control-label">Ter</label>
                                    </th>

                                    <th>
                                        <label for="inputWednesday" class="control-label">Qua</label>
                                    </th>

                                    <th>
                                        <label for="inputThursday" class="control-label">Qui</label>
                                    </th>

                                    <th>
                                        <label for="inputFriday" class="control-label">Sex</label>
                                    </th>

                                    <th>
                                        <label for="inputSaturday" class="control-label">Sab</label>
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td>
                                        <input name="days[]" value="sunday" id="inputSunday" type="checkbox"
                                               class="iCheckbox">
                                    </td>

                                    <td>
                                        <input name="days[]" value="monday" id="inputMonday" type="checkbox"
                                               class="iCheckbox">
                                    </td>

                                    <td>
                                        <input name="days[]" value="tuesday" id="inputTuesday" type="checkbox"
                                               class="iCheckbox">
                                    </td>

                                    <td>
                                        <input name="days[]" value="wednesday" id="inputWednesday" type="checkbox"
                                               class="iCheckbox">
                                    </td>

                                    <td>
                                        <input name="days[]" value="thursday" id="inputThursday" type="checkbox"
                                               class="iCheckbox">
                                    </td>

                                    <td>
                                        <input name="days[]" value="friday" id="inputFriday" type="checkbox"
                                               class="iCheckbox">
                                    </td>

                                    <td>
                                        <input name="days[]" value="saturday" id="inputSaturday" type="checkbox"
                                               class="iCheckbox">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('hour')) has-error @endif">
                            <label for="inputHour" class="control-label">Horário</label>

                            <div>
                                <input type="text" class="form-control" id="inputHour" name="hour"
                                       placeholder="00:00" value="{{ old('hour') ?? $hour }}"/>

                                <span class="help-block">{{ $errors->first('hour') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" name="save">Salvar</button>

                <input type="hidden" id="inputPrevious" name="previous"
                       value="{{ old('previous') ?? url()->previous() }}">
                <a href="{{ old('previous') ?? url()->previous() }}" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery('.iCheckbox').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        jQuery(':input').inputmask({removeMaskOnSubmit: true});

        jQuery('#inputHour').inputmask('hh:mm', {
            removeMaskOnSubmit: false
        });

        @foreach($days as $day)

        jQuery('#input{{ ucfirst($day) }}').iCheck('check');

        @endforeach
    </script>
@endsection
