@extends('adminlte::page')

@section('title', 'Editar termo aditivo - SGE CTI')

@section('content_header')
    <h1>Editar termo aditivo</h1>
@stop

@section('content')
    @include('modals.coordinator.cloneSchedule')

    <form class="form-horizontal" action="{{ route('coordenador.estagio.aditivo.alterar', $amendment->id) }}" method="post">
        @method('PUT')
        @csrf

        <input type="hidden" id="inputHas2Schedules" name="has2Schedules"
               value="{{ (old('has2Schedules') ?? ($amendment->schedule2 != null)) ? '1' : '0' }}">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do termo</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('internship')) has-error @endif">
                            <label for="inputInternship" class="col-sm-4 control-label">Nome do aluno*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control input-info" id="inputInternship" name="internship" readonly
                                       value="{{ $amendment->internship->student->nome }}"/>

                                <span class="help-block">{{ $errors->first('internship') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('protocol')) has-error @endif">
                            <label for="inputProtocol" class="col-sm-4 control-label">Protocolo*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputProtocol" name="protocol"
                                       placeholder="001/19" data-inputmask="'mask': '999/99'"
                                       value="{{ old('protocol') ?? $amendment->protocol }}"/>

                                <span class="help-block">{{ $errors->first('protocol') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('startDate')) has-error @endif">
                            <label for="inputStartDate" class="col-sm-4 control-label">Data de Início*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputStartDate" name="startDate"
                                       value="{{ old('startDate') ?? $amendment->start_date }}"/>

                                <span class="help-block">{{ $errors->first('startDate') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('endDate')) has-error @endif">
                            <label for="inputEndDate" class="col-sm-4 control-label">Data de Término*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputEndDate" name="endDate"
                                       value="{{ old('endDate') ?? $amendment->end_date }}"/>

                                <span class="help-block">{{ $errors->first('endDate') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group @if($errors->has('observation')) has-error @endif">
                    <label for="inputObservation" class="col-sm-2 control-label">Observação</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" id="inputObservation" name="observation"
                                  style="resize: none"
                                  placeholder="Observações adicionais">{{ old('observation') ?? $amendment->observation }}</textarea>

                        <span class="help-block">{{ $errors->first('observation') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Novos horários</h3>
            </div>

            <div class="box-body">
                <div class="form-group">
                    <label for="inputWeekDays" class="col-sm-2 control-label">Horário*</label>

                    <div class="col-sm-10">
                        <table id="inputWeekDays" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>
                                    <a href="#" data-toggle="modal" data-target="#cloneScheduleModal"
                                       onclick="schedule2 = false;">
                                        <i class="fa fa-copy"></i>
                                    </a>
                                </th>

                                <th>
                                    <label class="control-label">Seg</label>
                                </th>

                                <th>
                                    <label class="control-label">Ter</label>
                                </th>

                                <th>
                                    <label class="control-label">Qua</label>
                                </th>

                                <th>
                                    <label class="control-label">Qui</label>
                                </th>

                                <th>
                                    <label class="control-label">Sex</label>
                                </th>

                                <th>
                                    <label class="control-label">Sab</label>
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td style="min-width: 100px;">
                                    <label class="control-label">Entrada</label>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('monS')) has-error @endif">
                                        <input name="monS" id="inputMonS" type="text" class="form-control input-time"
                                               value="{{ old('monS') ?? $amendment->schedule->mon_s }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('tueS')) has-error @endif">
                                        <input name="tueS" id="inputTueS" type="text" class="form-control input-time"
                                               value="{{ old('tueS') ?? $amendment->schedule->tue_s }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('wedS')) has-error @endif">
                                        <input name="wedS" id="inputWedS" type="text" class="form-control input-time"
                                               value="{{ old('wedS') ?? $amendment->schedule->wed_s }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('thuS')) has-error @endif">
                                        <input name="thuS" id="inputThuS" type="text" class="form-control input-time"
                                               value="{{ old('thuS') ?? $amendment->schedule->thu_s }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('friS')) has-error @endif">
                                        <input name="friS" id="inputFriS" type="text" class="form-control input-time"
                                               value="{{ old('friS') ?? $amendment->schedule->fri_s }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('satS')) has-error @endif">
                                        <input name="satS" id="inputSatS" type="text" class="form-control input-time"
                                               value="{{ old('satS') ?? $amendment->schedule->sat_s }}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="control-label">Saída</label>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('monE')) has-error @endif">
                                        <input name="monE" id="inputMonE" type="text" class="form-control input-time"
                                               value="{{ old('monE') ?? $amendment->schedule->mon_e }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('tueE')) has-error @endif">
                                        <input name="tueE" id="inputTueE" type="text" class="form-control input-time"
                                               value="{{ old('tueE') ?? $amendment->schedule->tue_e }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('wedE')) has-error @endif">
                                        <input name="wedE" id="inputWedE" type="text" class="form-control input-time"
                                               value="{{ old('wedE') ?? $amendment->schedule->wed_e }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('thuE')) has-error @endif">
                                        <input name="thuE" id="inputThuE" type="text" class="form-control input-time"
                                               value="{{ old('thuE') ?? $amendment->schedule->thu_e }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('friE')) has-error @endif">
                                        <input name="friE" id="inputFriE" type="text" class="form-control input-time"
                                               value="{{ old('friE') ?? $amendment->schedule->fri_e }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('satE')) has-error @endif">
                                        <input name="satE" id="inputSatE" type="text" class="form-control input-time"
                                               value="{{ old('satE') ?? $amendment->schedule->sat_e }}">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fakeInputHas2Schedules" class="col-sm-2 control-label" style="padding-top: 0">2
                        turnos?</label>

                    <div class="col-sm-10">
                        <input type="checkbox" id="fakeInputHas2Schedules" name="fakeHas2Schedules"
                            {{ old('has2Schedules') ?? ($amendment->schedule2 != null) ? 'checked="checked"' : '' }}>
                    </div>
                </div>

                <div class="form-group" id="weekDays2" style="display: none">
                    <label for="inputWeekDays2" class="col-sm-2 control-label">2º horário</label>

                    <div class="col-sm-10">
                        <table id="inputWeekDays" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>
                                    <a href="#" data-toggle="modal" data-target="#cloneScheduleModal"
                                       onclick="schedule2 = true;">
                                        <i class="fa fa-copy"></i>
                                    </a>
                                </th>

                                <th>
                                    <label class="control-label">Seg</label>
                                </th>

                                <th>
                                    <label class="control-label">Ter</label>
                                </th>

                                <th>
                                    <label class="control-label">Qua</label>
                                </th>

                                <th>
                                    <label class="control-label">Qui</label>
                                </th>

                                <th>
                                    <label class="control-label">Sex</label>
                                </th>

                                <th>
                                    <label class="control-label">Sab</label>
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td style="min-width: 100px;">
                                    <label class="control-label">Entrada</label>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('monS2')) has-error @endif">
                                        <input name="monS2" id="inputMonS2" type="text" class="form-control input-time"
                                               value="{{ old('monS2') ?? $amendment->schedule2->mon_s ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('tueS2')) has-error @endif">
                                        <input name="tueS2" id="inputTueS2" type="text" class="form-control input-time"
                                               value="{{ old('tueS2') ?? $amendment->schedule2->tue_s ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('wedS2')) has-error @endif">
                                        <input name="wedS2" id="inputWedS2" type="text" class="form-control input-time"
                                               value="{{ old('wedS2') ?? $amendment->schedule2->wed_s ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('thuS2')) has-error @endif">
                                        <input name="thuS2" id="inputThuS2" type="text" class="form-control input-time"
                                               value="{{ old('thuS2') ?? $amendment->schedule2->thu_s ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('friS2')) has-error @endif">
                                        <input name="friS2" id="inputFriS2" type="text" class="form-control input-time"
                                               value="{{ old('friS2') ?? $amendment->schedule2->fri_s ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('satS2')) has-error @endif">
                                        <input name="satS2" id="inputSatS2" type="text" class="form-control input-time"
                                               value="{{ old('satS2') ?? $amendment->schedule2->sat_s ?? '' }}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="control-label">Saída</label>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('monE2')) has-error @endif">
                                        <input name="monE2" id="inputMonE2" type="text" class="form-control input-time"
                                               value="{{ old('monE2') ?? $amendment->schedule2->mon_e ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('tueE2')) has-error @endif">
                                        <input name="tueE2" id="inputTueE2" type="text" class="form-control input-time"
                                               value="{{ old('tueE2') ?? $amendment->schedule2->tue_e ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('wedE2')) has-error @endif">
                                        <input name="wedE2" id="inputWedE2" type="text" class="form-control input-time"
                                               value="{{ old('wedE2') ?? $amendment->schedule2->wed_e ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('thuE2')) has-error @endif">
                                        <input name="thuE2" id="inputThuE2" type="text" class="form-control input-time"
                                               value="{{ old('thuE2') ?? $amendment->schedule2->thu_e ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('friE2')) has-error @endif">
                                        <input name="friE2" id="inputFriE2" type="text" class="form-control input-time"
                                               value="{{ old('friE2') ?? $amendment->schedule2->fri_e ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('satE2')) has-error @endif">
                                        <input name="satE2" id="inputSatE2" type="text" class="form-control input-time"
                                               value="{{ old('satE2') ?? $amendment->schedule2->sat_e ?? '' }}">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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

            jQuery('.input-time').inputmask('hh:mm', {
                removeMaskOnSubmit: false
            }).parent().css('margin', '0');

            jQuery('#fakeInputHas2Schedules').on('ifChanged', function () {
                if (this.checked) {
                    jQuery('#weekDays2').css('display', 'initial');
                    jQuery('#inputHas2Schedules').val(1);
                } else {
                    jQuery('#weekDays2').css('display', 'none');
                    jQuery('#inputHas2Schedules').val(0);
                }
            }).trigger('ifChanged').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@endsection
