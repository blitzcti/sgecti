@extends('adminlte::page')

@section('title', 'Editar trabalho')

@section('content_header')
    <h1>Editar trabalho</h1>
@stop

@section('content')
    @include('modals.coordinator.student.search')

    <form class="form-horizontal" action="{{ route('coordenador.trabalho.alterar', ['id' => $job->id]) }}"
          method="post">
        @method('PUT')
        @csrf

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do trabalho</h3>
            </div>

            <div class="box-body">
                <input type="hidden" id="inputDilation" name="dilation"
                       value="{{ (old('dilation') ?? $job->dilation) ? '1' : '0' }}">
                <input type="hidden" id="inputRA" name="ra" value="{{ $job->ra }}">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('ra')) has-error @endif">
                            <label for="inputStudentName" class="col-sm-4 control-label">Aluno*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control input-info" id="inputStudentName" name="student"
                                       readonly value="{{ $job->ra }} - {{ $job->student->nome ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('ra') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('active')) has-error @endif">
                            <label for="inputActive" class="col-sm-4 control-label">Ativo*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection"
                                        data-minimum-results-for-search="Infinity"
                                        id="inputActive" name="active">
                                    <option value="1" {{ (old('active') ?? $job->active) ? 'selected' : '' }}>
                                        Sim
                                    </option>
                                    <option value="0" {{ !(old('active') ?? $job->active) ? 'selected' : '' }}>
                                        Não
                                    </option>
                                </select>

                                <span class="help-block">{{ $errors->first('active') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputCompany" class="col-sm-2 control-label">Empresa*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control input-info" id="inputCompany"
                               name="company" readonly
                               value="{{ $job->company->formatted_cpf_cnpj }} - {{ $job->company->name }} {{ $job->company->fantasy_name != null ? "(". $job->company->fantasy_name. ")" : '' }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputCompanyRepresentative" class="col-sm-2 control-label">Representante*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control input-info" id="inputCompanyRepresentative"
                               name="representative" readonly
                               value="{{ $job->company->representative_name }}"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('sector')) has-error @endif">
                            <label for="inputSector" class="col-sm-4 control-label">Setor*</label>

                            <div class="col-sm-8">
                                <select class="selection" name="sector" id="inputSector"
                                        style="width: 100%">

                                    @foreach((\App\Models\Sector::all() ?? []) as $sector)

                                        <option
                                            value="{{ $sector->id }}" {{ (old('sector') ?? $job->sector->id) == $sector->id ? "selected" : "" }}>
                                            {{ $sector->name }}
                                        </option>

                                    @endforeach

                                </select>

                                <span class="help-block">{{ $errors->first('sector') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('ctps')) has-error @endif">
                            <label for="inputCTPS" class="col-sm-4 control-label">CTPS*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputCTPS" name="ctps"
                                       placeholder="123321/22222" data-inputmask="'mask': '999999/99999'"
                                       value="{{ old('ctps') ?? $job->ctps }}"/>

                                <span class="help-block">{{ $errors->first('ctps') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('startDate')) has-error @endif">
                            <label for="inputStartDate" class="col-sm-4 control-label">Data de início*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputStartDate" name="startDate"
                                       value="{{ old('startDate') ?? $job->start_date->format("Y-m-d") }}"/>

                                <span class="help-block">{{ $errors->first('startDate') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('endDate')) has-error @endif">
                            <label for="inputEndDate" class="col-sm-4 control-label">Data de término*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputEndDate" name="endDate"
                                       value="{{ old('endDate') ?? $job->end_date->format("Y-m-d") }}">

                                <span class="help-block">{{ $errors->first('endDate') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group @if($errors->has('activities')) has-error @endif">
                    <label for="inputActivities" class="col-sm-2 control-label">Atividades*</label>

                    <div class="col-sm-10">
                            <textarea class="form-control" rows="3" id="inputActivities" name="activities"
                                      style="resize: none"
                                      placeholder="O que o aluno fez no trabalho">{{ old('activities') ?? $job->activities }}</textarea>

                        <span class="help-block">{{ $errors->first('activities') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('observation')) has-error @endif">
                    <label for="inputObservation" class="col-sm-2 control-label">Observações</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" id="inputObservation" name="observation"
                                  style="resize: none"
                                  placeholder="Observações adicionais">{{ old('observation') ?? $job->observation ?? '' }}</textarea>

                        <span class="help-block">{{ $errors->first('observation') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados da secretaria</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('planDate')) has-error @endif">
                            <label for="inputPlanDate" class="col-sm-4 control-label">Data do plano*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputPlanDate" name="planDate"
                                       value="{{ old('planDate') ?? $job->plan_date->format("Y-m-d") }}">

                                <span class="help-block">{{ $errors->first('planDate') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('protocol')) has-error @endif">
                            <label for="inputProtocol" class="col-sm-4 control-label">Protocolo*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputProtocol" name="protocol"
                                       placeholder="001/2019" data-inputmask="'mask': '999/9999'"
                                       value="{{ old('protocol') ?? $job->protocol }}"/>

                                <span class="help-block">{{ $errors->first('protocol') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fakeInputDilation" class="col-sm-2 control-label" style="padding-top: 0">Dilação
                        de prazo</label>

                    <div class="col-sm-10">
                        <input type="checkbox" id="fakeInputDilation" name="fakeDilation"
                            {{ old('dilation') ?? $job->dilation ? 'checked="checked"' : '' }}>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary pull-right">Salvar</button>

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

            jQuery('#fakeInputDilation').on('ifChanged', function () {
                jQuery('#inputDilation').val(Number(this.checked));
            }).trigger('ifChanged').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@endsection
