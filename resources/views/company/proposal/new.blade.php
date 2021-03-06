@extends('adminlte::page')

@section('title', 'Nova proposta - SGE CTI')

@section('content_header')
    <h1>Adicionar nova proposta de estágio</h1>
@stop

@section('content')
    @include('modals.coordinator.cloneSchedule')

    <form class="form-horizontal" action="{{ route('empresa.proposta.salvar') }}" method="post">
        @csrf

        <input type="hidden" id="inputHasSchedule" name="hasSchedule"
               value="{{ (old('hasSchedule') ?? 0) ? '1' : '0' }}">

        <input type="hidden" id="inputHas2Schedules" name="has2Schedules"
               value="{{ (old('has2Schedules') ?? 0) ? '1' : '0' }}">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do estágio</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('type')) has-error @endif">
                            <label for="inputType" class="col-sm-4 control-label">Tipo de estágio*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                        id="inputType" name="type">
                                    <option value="0" {{ (old('type') ?? 1) ? 'selected=selected' : '' }}>Estágio
                                        padrão
                                    </option>
                                    <option value="1" {{ !(old('type') ?? 1) ? 'selected=selected' : '' }}>Iniciação
                                        científica
                                    </option>
                                </select>

                                <span class="help-block">{{ $errors->first('type') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('remuneration')) has-error @endif">
                            <label for="inputRemuneration" class="col-sm-4 control-label">Remuneração*</label>

                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="inputRemuneration" name="remuneration"
                                       placeholder="0.00" step="0.01" min="0.00"
                                       value="{{ old('remuneration') ?? '0.00' }}"/>

                                <span class="help-block">{{ $errors->first('remuneration') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group @if($errors->has('description')) has-error @endif">
                    <label for="inputDescription" class="col-sm-2 control-label">Descrição*</label>

                    <div class="col-sm-10">
                            <textarea class="form-control" rows="3" id="inputDescription" name="description"
                                      style="resize: none"
                                      placeholder="Descrição do estágio">{{ old('description') ?? '' }}</textarea>

                        <span class="help-block">{{ $errors->first('description') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('requirements')) has-error @endif">
                    <label for="inputRequirements" class="col-sm-2 control-label">Requisitos*</label>

                    <div class="col-sm-10">
                            <textarea class="form-control" rows="3" id="inputRequirements" name="requirements"
                                      style="resize: none"
                                      placeholder="O que o aluno precisará para realizar o estágio">{{ old('requirements') ?? '' }}</textarea>

                        <span class="help-block">{{ $errors->first('requirements') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('benefits')) has-error @endif">
                    <label for="inputBenefits" class="col-sm-2 control-label">Benefícios</label>

                    <div class="col-sm-10">
                            <textarea class="form-control" rows="3" id="inputBenefits" name="benefits"
                                      style="resize: none"
                                      placeholder="O que o aluno ganhará ao estágio">{{ old('benefits') ?? '' }}</textarea>

                        <span class="help-block">{{ $errors->first('benefits') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('deadline')) has-error @endif">
                            <label for="inputDeadline" class="col-sm-4 control-label">Data limite*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputDeadline" name="deadline"
                                       value="{{ old('deadline') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('deadline') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('observation')) has-error @endif">
                            <label for="inputObservation" class="col-sm-3 control-label">Observações</label>

                            <div class="col-sm-9">
                        <textarea class="form-control" rows="2" id="inputObservation" name="observation"
                                  style="resize: none"
                                  placeholder="Observações adicionais">{{ old('observation') ?? '' }}</textarea>

                                <span class="help-block">{{ $errors->first('observation') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Contato</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('email')) has-error @endif">
                            <label for="inputEmail" class="col-sm-4 control-label">Email*</label>

                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="inputEmail" name="email"
                                       placeholder="andcastro28@gmail.com" value="{{ old('email') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('email') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('subject')) has-error @endif">
                            <label for="inputSubject" class="col-sm-4 control-label">Assunto do email*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputSubject" name="subject"
                                       placeholder="Estágio/CTI" value="{{ old('subject') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('subject') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('phone')) has-error @endif">
                            <label for="inputPhone" class="col-sm-4 control-label">Telefone</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputPhone" name="phone"
                                       placeholder="(14) 3103-6150"
                                       data-inputmask="'mask': ['(99) 9999-9999', '(99) 99999-9999']"
                                       value="{{ old('phone') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('phone') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('other')) has-error @endif">
                            <label for="inputOther" class="col-sm-4 control-label">Outra forma</label>

                            <div class="col-sm-8">
                            <textarea class="form-control" rows="2" id="inputOther" name="other"
                                      style="resize: none">{{ old('other') ?? '' }}</textarea>

                                <span class="help-block">{{ $errors->first('other') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Cursos abrangentes</h3>
            </div>

            <div class="box-body">
                <div class="form-group @if($errors->has('courses')) has-error @endif">
                    <label for="inputCourses" class="col-sm-2 control-label">Cursos*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="courses[]" multiple="multiple" id="inputCourses"
                                style="width: 100%">

                            @foreach($courses as $course)

                                <option
                                    value="{{ $course->id }}" {{ in_array($course->id, (old('courses') ?? [])) ? "selected" : "" }}>
                                    {{ $course->name }}</option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('courses') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <input type="checkbox" id="fakeInputHasSchedule" name="fakeHasSchedule"
                        {{ (old('hasSchedule') ?? 0) ? 'checked="checked"' : '' }}/>

                    Horário pré-definido?
                </h3>
            </div>

            <div id="schedule">
                <div class="box-body">
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
        jQuery(document).ready(function () {
            jQuery(':input').inputmask({removeMaskOnSubmit: true});

            jQuery('.input-time').inputmask('hh:mm', {
                removeMaskOnSubmit: false
            }).parent().css('margin', '0');

            jQuery('.selection').select2({
                language: "pt-BR"
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
        });
    </script>
@endsection
