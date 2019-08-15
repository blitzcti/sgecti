@extends('adminlte::page')

@section('title', 'Novo trabalho - SGE CTI')

@section('content_header')
    <h1>Adicionar novo trabalho</h1>
@stop

@section('content')

    @include('modals.coordinator.company.supervisor.new')
    @include('modals.coordinator.student.search')

    <form class="form-horizontal" action="{{ route('coordenador.estagio.trabalho.salvar') }}" method="post">
        @csrf

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do trabalho</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('ra')) has-error @endif">
                            <label for="inputRA" class="col-sm-4 control-label">RA*</label>

                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inputRA" name="ra" placeholder="1757047"
                                           data-inputmask="'mask': '9999999'" value="{{ old('ra') ?? $s }}" readonly>

                                    <div class="input-group-btn">
                                        <a href="#" data-toggle="modal" data-target="#searchStudentModal"
                                           class="btn btn-default"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>

                                <span class="help-block">{{ $errors->first('ra') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('active')) has-error @endif">
                            <label for="inputActive" class="col-sm-4 control-label">Ativo*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                        id="inputActive" name="active">
                                    <option value="1" {{ (old('active') ?? 1) ? 'selected' : '' }}>Sim</option>
                                    <option value="0" {{ !(old('active') ?? 1) ? 'selected' : '' }}>Não</option>
                                </select>

                                <span class="help-block">{{ $errors->first('active') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputStudentName" class="col-sm-2 control-label">Aluno</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputStudentName" name="student" readonly
                               value="{{ App\Models\NSac\Student::find(old('ra') ?? $s)->nome ?? '' }}"/>
                    </div>
                </div>

                <div class="form-group @if($errors->has('company')) has-error @endif">
                    <label for="inputCompany" class="col-sm-2 control-label">Empresa*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="company" id="inputCompany"
                                style="width: 100%">

                            @foreach($companies as $company)

                                <option
                                    value="{{ $company->id }}" {{ (old('company') ?? 1) == $company->id ? 'selected' : '' }}>
                                    {{ $company->cpf_cnpj }} - {{ $company->name }}</option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('company') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputCompanyRepresentative" class="col-sm-2 control-label">Representante</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputCompanyRepresentative" name="representative"
                               readonly
                               value="{{ (App\Models\Company::find(old('company')) ?? $companies->first())->representative_name ?? '' }}"/>
                    </div>
                </div>

                <div class="form-group @if($errors->has('sector')) has-error @endif">
                    <label for="inputSector" class="col-sm-2 control-label">Setor*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="sector" id="inputSector"
                                style="width: 100%">

                            @foreach((\App\Models\Company::find(old('company'))->sectors ?? $companies->first()->sectors ?? []) as $sector)

                                <option
                                    value="{{ $sector->id }}" {{ (old('sector') ?? 1) == $sector->id ? "selected" : "" }}>
                                    {{ $sector->name }}
                                </option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('sector') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('startDate')) has-error @endif">
                            <label for="inputStartDate" class="col-sm-4 control-label">Data Início*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputStartDate" name="startDate"
                                       value="{{ old('startDate') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('startDate') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('endDate')) has-error @endif">
                            <label for="inputEndDate" class="col-sm-4 control-label">Data Fim*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputEndDate" name="endDate"
                                       value="{{ old('endDate') ?? '' }}">

                                <span class="help-block">{{ $errors->first('endDate') }}</span>
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
                                       value="{{ old('protocol') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('protocol') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('ctps')) has-error @endif">
                            <label for="inputCTPS" class="col-sm-4 control-label">Número da CTPS</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputCTPS" name="ctps"
                                       data-inputmask="'mask': '999999/99999'" value="{{ old('ctps') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('ctps') }}</span>
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
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Adicionar</button>
                <a href="{{url()->previous()}}" class="btn btn-default">Cancelar</a>
            </div>
            <!-- /.box-footer -->
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Supervisor</h3>
            </div>

            <div class="box-body">
                <div class="form-group @if($errors->has('supervisor')) has-error @endif">
                    <label for="inputSupervisor" class="col-sm-2 control-label">Supervisor*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="supervisor" id="inputSupervisor"
                                style="width: 100%">

                            @foreach(((\App\Models\Company::find(old('company')) ?? $companies->first())->supervisors ?? []) as $supervisor)

                                <option
                                    value="{{ $supervisor->id }}" {{ (old('supervisor') ?? 1) == $supervisor->id ? "selected" : "" }}>
                                    {{ $supervisor->name }}
                                </option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('supervisor') }}</span>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="btn-group pull-right">
                    <a href="#" class="btn btn-success" id="aAddSupervisor" data-toggle="modal"
                       data-target="#newInternshipSupervisorModal">Novo supervisor</a>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
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

            jQuery('#inputCompany').on('change', e => {
                jQuery.ajax({
                    url: `/api/empresa/${jQuery('#inputCompany').val()}`,
                    dataType: 'json',
                    method: 'GET',
                    success: function (data) {
                        jQuery('#inputCompanyRepresentative').val(data.representative_name);
                    },
                    error: function () {

                    },
                });

                jQuery('#inputSector').select2({
                    language: "pt-BR",
                    ajax: {
                        url: `/api/empresa/${jQuery('#inputCompany').val()}/setor/`,
                        dataType: 'json',
                        method: 'GET',
                        cache: true,
                        data: function (params) {
                            return {
                                q: params.term // search term
                            };
                        },

                        processResults: function (response) {
                            sectors = [];
                            response.forEach(sector => {
                                if (sector.active) {
                                    sectors.push({id: sector.id, text: sector.name});
                                }
                            });

                            return {
                                results: sectors
                            };
                        },
                    }
                });

                jQuery('#inputSupervisor').select2({
                    language: "pt-BR",
                    ajax: {
                        url: `/api/empresa/${jQuery('#inputCompany').val()}/supervisor/`,
                        dataType: 'json',
                        method: 'GET',
                        cache: true,
                        data: function (params) {
                            return {
                                q: params.term // search term
                            };
                        },

                        processResults: function (response) {
                            supervisors = [];
                            response.forEach(supervisor => {
                                if (supervisor.active) {
                                    supervisors.push({id: supervisor.id, text: supervisor.name});
                                }
                            });

                            return {
                                results: supervisors
                            };
                        },
                    }
                });
            });
        });
    </script>
@endsection
