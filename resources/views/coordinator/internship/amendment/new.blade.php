@extends('adminlte::page')

@section('title', 'Novo termo aditivo - SGE CTI')

@section('content_header')
    <h1>Adicionar termo aditivo</h1>
@stop

@section('content')
    <form class="form-horizontal" action="{{ route('coordenador.estagio.aditivo.salvar') }}" method="post">
        @csrf

        <input type="hidden" id="inputHas2Turnos" name="has2Turnos"
               value="{{ (old('has2Turnos') ?? 0) ? '1' : '0' }}">

        <input type="hidden" id="inputInternshipStartDate" name="internshipStartDate"
               value="{{ (App\Models\Internship::find($i) ?? $internships->first())->start_date }}">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do termo</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('internship')) has-error @endif">
                            <label for="inputInternship" class="col-sm-4 control-label">Aluno*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" id="inputInternship" name="internship">

                                    @foreach($internships as $internship)

                                        <option value="{{ $internship->id }}"
                                            {{ (old('internship') ?? $i) == $internship->id ? 'selected=selected' : '' }}>
                                            {{ $internship->ra }} - {{ $internship->student->nome }}
                                        </option>

                                    @endforeach

                                </select>

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
                                       value="{{ old('protocol') ?? '' }}"/>

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
                                       value="{{ old('startDate') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('startDate') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('endDate')) has-error @endif">
                            <label for="inputEndDate" class="col-sm-4 control-label">Data de Término*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputEndDate" name="endDate"
                                       value="{{ old('endDate') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('endDate') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group @if($errors->has('observation')) has-error @endif">
                    <label for="inputObservation" class="col-sm-2 control-label">Obervação</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" id="inputObservation" name="observation"
                                  style="resize: none"
                                  placeholder="Observações adicionais">{{ old('observation') ?? '' }}</textarea>

                        <span class="help-block">{{ $errors->first('observation') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do estágio</h3>
            </div>

            <div class="box-body">
                <dl class="row">
                    <dt class="col-sm-2">Empresa</dt>
                    <dd class="col-sm-10">
                        <span id="internshipCompanyName">
                            {{ (App\Models\Internship::find($i) ?? $internships->first())->company->name }}
                        </span>
                    </dd>

                    <dt class="col-sm-2">Setor</dt>
                    <dd class="col-sm-10">
                        <span id="internshipSector">
                            {{ (App\Models\Internship::find($i) ?? $internships->first())->sector->name }}
                        </span>
                    </dd>

                    <dt class="col-sm-2">Supervisor</dt>
                    <dd class="col-sm-10">
                        <span id="internshipSupervisorName">
                            {{ (App\Models\Internship::find($i) ?? $internships->first())->supervisor->name }}
                        </span>
                    </dd>

                    <dt class="col-sm-2">Data de início</dt>
                    <dd class="col-sm-10">
                        <span id="internshipStartDate">
                            {{ date("d/m/Y", strtotime((App\Models\Internship::find($i) ?? $internships->first())->start_date)) }}
                        </span>
                    </dd>

                    <dt class="col-sm-2">Data de término</dt>
                    <dd class="col-sm-10">
                        <span id="internshipEndDate">
                            {{ date("d/m/Y", strtotime((App\Models\Internship::find($i) ?? $internships->first())->end_date)) }}
                        </span>
                    </dd>

                    <dt class="col-sm-2">Horas estimadas</dt>
                    <dd class="col-sm-10">
                        <span id="internshipEstimatedHours">
                            {{ (App\Models\Internship::find($i) ?? $internships->first())->estimated_hours }}
                        </span>
                    </dd>

                    <div class="form-group @if($errors->has('newEndDate')) has-error @endif" style="margin: 0;">
                        <dt class="col-sm-2">
                            <label for="inputNewEndDate">Nova data de término</label>
                        </dt>

                        <dd class="col-sm-10">
                            <div>
                                <input type="date" class="form-control" id="inputNewEndDate" name="newEndDate"
                                       value="{{ old('newEndDate') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('newEndDate') }}</span>
                            </div>
                        </dd>
                    </div>
                </dl>
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
                                <th></th>

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
                                               value="{{ old('monS') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('tueS')) has-error @endif">
                                        <input name="tueS" id="inputTueS" type="text" class="form-control input-time"
                                               value="{{ old('tueS') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('wedS')) has-error @endif">
                                        <input name="wedS" id="inputWedS" type="text" class="form-control input-time"
                                               value="{{ old('wedS') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('thuS')) has-error @endif">
                                        <input name="thuS" id="inputThuS" type="text" class="form-control input-time"
                                               value="{{ old('thuS') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('friS')) has-error @endif">
                                        <input name="friS" id="inputFriS" type="text" class="form-control input-time"
                                               value="{{ old('friS') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('satS')) has-error @endif">
                                        <input name="satS" id="inputSatS" type="text" class="form-control input-time"
                                               value="{{ old('satS') ?? '' }}">
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
                                               value="{{ old('monE') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('tueE')) has-error @endif">
                                        <input name="tueE" id="inputTueE" type="text" class="form-control input-time"
                                               value="{{ old('tueE') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('wedE')) has-error @endif">
                                        <input name="wedE" id="inputWedE" type="text" class="form-control input-time"
                                               value="{{ old('wedE') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('thuE')) has-error @endif">
                                        <input name="thuE" id="inputThuE" type="text" class="form-control input-time"
                                               value="{{ old('thuE') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('friE')) has-error @endif">
                                        <input name="friE" id="inputFriE" type="text" class="form-control input-time"
                                               value="{{ old('friE') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('satE')) has-error @endif">
                                        <input name="satE" id="inputSatE" type="text" class="form-control input-time"
                                               value="{{ old('satE') ?? '' }}">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fakeInputHas2Turnos" class="col-sm-2 control-label" style="padding-top: 0">2
                        turnos?</label>

                    <div class="col-sm-10">
                        <input type="checkbox" id="fakeInputHas2Turnos" name="fakeHas2Turnos"
                            {{ old('has2Turnos') ?? 0 ? 'checked="checked"' : '' }}>
                    </div>
                </div>

                <div class="form-group" id="weekDays2" style="display: none">
                    <label for="inputWeekDays2" class="col-sm-2 control-label">2º horário</label>

                    <div class="col-sm-10">
                        <table id="inputWeekDays" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th></th>

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
                                               value="{{ old('monS2') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('tueS2')) has-error @endif">
                                        <input name="tueS2" id="inputTueS2" type="text" class="form-control input-time"
                                               value="{{ old('tueS2') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('wedS2')) has-error @endif">
                                        <input name="wedS2" id="inputWedS2" type="text" class="form-control input-time"
                                               value="{{ old('wedS2') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('thuS2')) has-error @endif">
                                        <input name="thuS2" id="inputThuS2" type="text" class="form-control input-time"
                                               value="{{ old('thuS2') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('friS2')) has-error @endif">
                                        <input name="friS2" id="inputFriS2" type="text" class="form-control input-time"
                                               value="{{ old('friS2') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('satS2')) has-error @endif">
                                        <input name="satS2" id="inputSatS2" type="text" class="form-control input-time"
                                               value="{{ old('satS2') ?? '' }}">
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
                                               value="{{ old('monE2') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('tueE2')) has-error @endif">
                                        <input name="tueE2" id="inputTueE2" type="text" class="form-control input-time"
                                               value="{{ old('tueE2') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('wedE2')) has-error @endif">
                                        <input name="wedE2" id="inputWedE2" type="text" class="form-control input-time"
                                               value="{{ old('wedE2') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('thuE2')) has-error @endif">
                                        <input name="thuE2" id="inputThuE2" type="text" class="form-control input-time"
                                               value="{{ old('thuE2') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('friE2')) has-error @endif">
                                        <input name="friE2" id="inputFriE2" type="text" class="form-control input-time"
                                               value="{{ old('friE2') ?? '' }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group @if($errors->has('satE2')) has-error @endif">
                                        <input name="satE2" id="inputSatE2" type="text" class="form-control input-time"
                                               value="{{ old('satE2') ?? '' }}">
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
                <button type="submit" class="btn btn-primary pull-right">Adicionar</button>
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

            jQuery('#fakeInputHas2Turnos').on('ifChanged', function () {
                if (this.checked) {
                    jQuery('#weekDays2').css('display', 'initial');
                    jQuery('#inputHas2Turnos').val(1);
                } else {
                    jQuery('#weekDays2').css('display', 'none');
                    jQuery('#inputHas2Turnos').val(0);
                }
            }).trigger('ifChanged').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            jQuery('#inputInternship').on('change', e => {
                jQuery.ajax({
                    url: `/api/estagio/${jQuery('#inputInternship').val()}`,
                    dataType: 'json',
                    method: 'GET',
                    success: function (data) {
                        jQuery.ajax({
                            url: `/api/empresa/${data.company_id}`,
                            dataType: 'json',
                            method: 'GET',
                            success: function (data) {
                                jQuery('#internshipCompanyName').text(data.name);
                            },
                            error: function () {

                            },
                        });

                        jQuery.ajax({
                            url: `/api/empresa/setor/${data.sector_id}`,
                            dataType: 'json',
                            method: 'GET',
                            success: function (data) {
                                jQuery('#internshipSector').text(data.name);
                            },
                            error: function () {

                            },
                        });

                        jQuery.ajax({
                            url: `/api/empresa/supervisor/${data.supervisor_id}`,
                            dataType: 'json',
                            method: 'GET',
                            success: function (data) {
                                jQuery('#internshipSupervisorName').text(data.name);
                            },
                            error: function () {

                            },
                        });

                        jQuery('#internshipStartDate').text(data.start_date);
                        jQuery('#internshipEndDate').text(data.end_date);
                        jQuery('#internshipEstimatedHours').text(data.estimated_hours);
                    },
                    error: function () {

                    },
                });
            });
        });
    </script>
@endsection
