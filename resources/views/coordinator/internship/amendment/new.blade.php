@extends('adminlte::page')

@section('title', 'Novo termo aditivo - SGE CTI')

@section('content_header')
    <h1>Adicionar termo aditivo</h1>
@stop

@section('content')
    @include('modals.coordinator.cloneSchedule')

    <form class="form-horizontal" action="{{ route('coordenador.estagio.aditivo.salvar') }}" method="post">
        @csrf
        @include('modals.coordinator.internship.amendment.changeEndDate')

        <input type="hidden" id="inputHasSchedule" name="hasSchedule"
               value="{{ (old('hasSchedule') ?? 0) ? '1' : '0' }}">

        <input type="hidden" id="inputHas2Schedules" name="has2Schedules"
               value="{{ (old('has2Schedules') ?? 0) ? '1' : '0' }}">

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
                                       placeholder="001/2019" data-inputmask="'mask': '999/9999'"
                                       value="{{ old('protocol') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('protocol') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group @if($errors->has('observation')) has-error @endif">
                    <label for="inputObservation" class="col-sm-2 control-label">Observações</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" id="inputObservation" name="observation"
                                  style="resize: none"
                                  placeholder="Observações adicionais">{{ old('observation') ?? '' }}</textarea>

                        <span class="help-block">{{ $errors->first('observation') }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($internships->first() != null)

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
                            {{ date("d/m/Y", strtotime((App\Models\Internship::find($i) ?? $internships->first())->start_date->format("Y-m-d"))) }}
                        </span>
                        </dd>

                        <dt class="col-sm-2">Data de término</dt>
                        <dd class="col-sm-10">
                        <span class="form-group" style="margin: 0;">
                            <span id="internshipEndDate" class="@if($errors->has('newEndDate')) text-red @endif">
                            {{ date("d/m/Y", strtotime(old('newEndDate') ?? (App\Models\Internship::find($i) ?? $internships->first())->end_date->format("Y-m-d"))) }}
                            </span>

                            <a href="#" data-target="#changeInternshipEndDateModal" data-toggle="modal"
                               class="text-blue">Alterar</a>
                        </span>
                        </dd>

                        <dt class="col-sm-2">Horas estimadas</dt>
                        <dd class="col-sm-10">
                        <span id="internshipEstimatedHours">
                            {{ round((App\Models\Internship::find($i) ?? $internships->first())->estimated_hours) }}
                        </span>
                        </dd>
                    </dl>
                </div>
            </div>

        @endif

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <input type="checkbox" id="fakeInputHasSchedule" name="fakeHasSchedule"
                        {{ (old('hasSchedule') ?? 0) ? 'checked="checked"' : '' }}/>

                    Editar horário?
                </h3>
            </div>

            <div id="schedule">
                <div class="box-body">
                    @foreach($fields as $field)
                        @if($errors->has("{$field}S") || $errors->has("{$field}E") || $errors->has("{$field}S2") || $errors->has("{$field}E2"))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                @foreach($fields as $f)
                                    <p>{{ $errors->first("{$f}S") }}</p>
                                    <p>{{ $errors->first("{$f}E") }}</p>
                                    <p>{{ $errors->first("{$f}S2") }}</p>
                                    <p>{{ $errors->first("{$f}E2") }}</p>
                                @endforeach
                            </div>
                            @break
                        @endif
                    @endforeach

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group @if($errors->has('startDate')) has-error @endif">
                                <label for="inputStartDate" class="col-sm-4 control-label">Data de início</label>

                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="inputStartDate" name="startDate"
                                           value="{{ old('startDate') ?? '' }}"/>

                                    <span class="help-block">{{ $errors->first('startDate') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group @if($errors->has('endDate')) has-error @endif">
                                <label for="inputEndDate" class="col-sm-4 control-label">Data de término</label>

                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default dropdown-toggle"
                                                    data-toggle="dropdown">
                                                <span id="EndDateToggle"></span>
                                                <span class="fa fa-caret-down"></span></button>

                                            <ul class="dropdown-menu">
                                                <li><a href="#" onclick="endDate(0); return false;">Do estágio</a></li>
                                                <li><a href="#" onclick="endDate(1); return false;">Personalizado</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <input type="date" class="form-control" id="inputEndDate" name="endDate"
                                               value="{{ old('endDate') ?? '' }}"/>
                                    </div>

                                    <span class="help-block">{{ $errors->first('endDate') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputWeekDays" class="col-sm-2 control-label">Horário</label>

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
                                            <input name="monS" id="inputMonS" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('monS') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('tueS')) has-error @endif">
                                            <input name="tueS" id="inputTueS" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('tueS') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('wedS')) has-error @endif">
                                            <input name="wedS" id="inputWedS" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('wedS') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('thuS')) has-error @endif">
                                            <input name="thuS" id="inputThuS" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('thuS') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('friS')) has-error @endif">
                                            <input name="friS" id="inputFriS" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('friS') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('satS')) has-error @endif">
                                            <input name="satS" id="inputSatS" type="text"
                                                   class="form-control input-time"
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
                                            <input name="monE" id="inputMonE" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('monE') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('tueE')) has-error @endif">
                                            <input name="tueE" id="inputTueE" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('tueE') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('wedE')) has-error @endif">
                                            <input name="wedE" id="inputWedE" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('wedE') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('thuE')) has-error @endif">
                                            <input name="thuE" id="inputThuE" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('thuE') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('friE')) has-error @endif">
                                            <input name="friE" id="inputFriE" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('friE') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('satE')) has-error @endif">
                                            <input name="satE" id="inputSatE" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('satE') ?? '' }}">
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
                                {{ old('has2Schedules') ?? 0 ? 'checked="checked"' : '' }}>
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
                                            <input name="monS2" id="inputMonS2" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('monS2') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('tueS2')) has-error @endif">
                                            <input name="tueS2" id="inputTueS2" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('tueS2') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('wedS2')) has-error @endif">
                                            <input name="wedS2" id="inputWedS2" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('wedS2') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('thuS2')) has-error @endif">
                                            <input name="thuS2" id="inputThuS2" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('thuS2') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('friS2')) has-error @endif">
                                            <input name="friS2" id="inputFriS2" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('friS2') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('satS2')) has-error @endif">
                                            <input name="satS2" id="inputSatS2" type="text"
                                                   class="form-control input-time"
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
                                            <input name="monE2" id="inputMonE2" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('monE2') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('tueE2')) has-error @endif">
                                            <input name="tueE2" id="inputTueE2" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('tueE2') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('wedE2')) has-error @endif">
                                            <input name="wedE2" id="inputWedE2" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('wedE2') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('thuE2')) has-error @endif">
                                            <input name="thuE2" id="inputThuE2" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('thuE2') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('friE2')) has-error @endif">
                                            <input name="friE2" id="inputFriE2" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('friE2') ?? '' }}">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group @if($errors->has('satE2')) has-error @endif">
                                            <input name="satE2" id="inputSatE2" type="text"
                                                   class="form-control input-time"
                                                   value="{{ old('satE2') ?? '' }}">
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary pull-right">Adicionar</button>

                <input type="hidden" id="inputPrevious" name="previous"
                       value="{{ old('previous') ?? url()->previous() }}">
                <a href="{{ old('previous') ?? url()->previous() }}" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        let endDateFromInternship = false;

        function changeEndDate() {
            let newEndDate = jQuery('#inputNewEndDate').val();
            if (newEndDate !== "") {
                jQuery('#internshipEndDate').text(new Date(`${newEndDate} `).toLocaleDateString());
                jQuery('#internshipEndDate').removeClass('text-red');

                if (endDateFromInternship) {
                    endDate(0);
                }
            }
        }

        function endDate(id) {
            switch (id) {
                case -1:
                    if (jQuery('#inputEndDate').val() !== '' && jQuery('#inputEndDate').val() !== jQuery('#internshipEndDate').text().trim().split("/").reverse().join("-")) {
                        jQuery('#EndDateToggle').text('Personalizado');
                        break;
                    }

                case 0:
                    jQuery('#EndDateToggle').text('Do estágio');
                    let newDate = jQuery('#internshipEndDate').text().trim().split("/").reverse().join("-");
                    jQuery('#inputEndDate').val(newDate);
                    endDateFromInternship = true;
                    break;

                case 1:
                    jQuery('#EndDateToggle').text('Personalizado');
                    jQuery('#inputEndDate').val('');
                    endDateFromInternship = false;
                    break;
            }
        }

        jQuery(document).ready(function () {
            jQuery(':input').inputmask({removeMaskOnSubmit: true});

            jQuery('.selection').select2({
                language: "pt-BR"
            });

            jQuery('.input-time').inputmask('hh:mm', {
                removeMaskOnSubmit: false
            }).parent().css('margin', '0');

            jQuery('#inputEndDate').on('change', e => {
                endDate(-1);
            });

            jQuery('#fakeInputHasSchedule').on('ifChanged', function () {
                jQuery('#schedule').toggle(this.checked);
                jQuery('#inputHasSchedule').val(Number(this.checked));
            }).trigger('ifChanged').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            jQuery('#fakeInputHas2Schedules').on('ifChanged', function () {
                jQuery('#weekDays2').toggle(this.checked);
                jQuery('#inputHas2Schedules').val(Number(this.checked));
            }).trigger('ifChanged').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            jQuery('#inputInternship').on('change', e => {
                jQuery.ajax({
                    url: `{{ config('app.url') }}/api/coordenador/estagio/${jQuery('#inputInternship').val()}`,
                    dataType: 'json',
                    method: 'GET',
                    success: function (data) {
                        jQuery('#internshipCompanyName').text(data.company.name);
                        jQuery('#internshipSector').text(data.sector.name);
                        jQuery('#internshipSupervisorName').text(data.supervisor.name);
                        jQuery('#internshipStartDate').text(new Date(`${data.start_date} `).toLocaleDateString());
                        jQuery('#internshipEndDate').text(new Date(`${data.end_date} `).toLocaleDateString());
                        jQuery('#internshipEstimatedHours').text(data.estimated_hours.toFixed(0));
                    },
                    error: function () {

                    },
                });
            });

            endDate(-1);
        });
    </script>
@endsection
