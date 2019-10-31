@extends('adminlte::page')

@section('title', 'Novo trabalho - SGE CTI')

@section('content_header')
    <h1>Adicionar novo trabalho</h1>
@stop

@section('content')
    @include('modals.coordinator.job.company.new')
    @include('modals.coordinator.student.search')
    @include('modals.coordinator.internship.studentError')
    @include('modals.coordinator.job.studentError')
    @include('modals.coordinator.student.error')
    @include('modals.coordinator.job.company.error')

    <form class="form-horizontal" action="{{ route('coordenador.trabalho.salvar') }}" method="post">
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
                                           data-inputmask="'mask': '9999999'" value="{{ old('ra') ?? $s }}">

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
                        <input type="text" class="form-control input-info" id="inputStudentName" name="student" readonly
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
                                    {{ $company->formatted_cpf_cnpj }} - {{ $company->name }} {{ $company->fantasy_name != null ? " ($company->fantasy_name)" : '' }}
                                </option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('company') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputCompanyRepresentative" class="col-sm-2 control-label">Representante</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control input-info" id="inputCompanyRepresentative"
                               name="representative" readonly
                               value="{{ (App\Models\JobCompany::find(old('company')) ?? $companies->first())->representative_name ?? '' }}"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('startDate')) has-error @endif">
                            <label for="inputStartDate" class="col-sm-4 control-label">Data de início*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputStartDate" name="startDate"
                                       value="{{ old('startDate') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('startDate') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('endDate')) has-error @endif">
                            <label for="inputEndDate" class="col-sm-4 control-label">Data de término*</label>

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
                                       placeholder="001/2019" data-inputmask="'mask': '999/9999'"
                                       value="{{ old('protocol') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('protocol') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('ctps')) has-error @endif">
                            <label for="inputCTPS" class="col-sm-4 control-label">CTPS*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputCTPS" name="ctps"
                                       placeholder="123321/22222" data-inputmask="'mask': '999999/99999'"
                                       value="{{ old('ctps') ?? '' }}"/>

                                <span class="help-block">{{ $errors->first('ctps') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group @if($errors->has('activities')) has-error @endif">
                    <label for="inputActivities" class="col-sm-2 control-label">Atividades*</label>

                    <div class="col-sm-10">
                            <textarea class="form-control" rows="3" id="inputActivities" name="activities"
                                      style="resize: none"
                                      placeholder="O que o aluno fez no trabalho">{{ old('activities') ?? '' }}</textarea>

                        <span class="help-block">{{ $errors->first('activities') }}</span>
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
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="btn-group pull-right">
                    <a href="#" class="btn btn-success" id="aAddCompany" data-toggle="modal"
                       data-target="#newJobCompanyModal">Nova empresa</a>
                </div>
            </div>
            <!-- /.box-footer -->
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
        function pj(isPj) {
            if (isPj) {
                jQuery('#CpfCnpjOption').text('CNPJ');

                jQuery("input[id*='inputCompanyCpfCnpj']").inputmask({
                    mask: '99.999.999/9999-99',
                    removeMaskOnSubmit: true
                });

                jQuery('#inputCompanyPJ').val(1);
            } else {
                jQuery('#CpfCnpjOption').text('CPF');

                jQuery("input[id*='inputCompanyCpfCnpj']").inputmask({
                    mask: '999.999.999-99',
                    removeMaskOnSubmit: true
                });

                jQuery('#inputCompanyPJ').val(0);
            }
        }

        jQuery(document).ready(function () {
            jQuery(':input').inputmask({removeMaskOnSubmit: true});

            jQuery('.selection').select2({
                language: "pt-BR"
            });

            function loadStudent() {
                jQuery.ajax({
                    url: `{{ config('app.url') }}/api/alunos/${jQuery('#inputRA').inputmask('unmaskedvalue')}`,
                    dataType: 'json',
                    type: 'GET',
                    success: function (student) {
                        jQuery('#inputStudentName').val(student.nome);

                        if (student.internship_state === 0) {
                            jQuery("#studentInternshipErrorModal").modal({
                                backdrop: "static",
                                keyboard: false,
                                show: true
                            });

                            jQuery('#inputRA').val('');
                            jQuery('#inputStudentName').val('');
                        } else if (student.job_state === 0) {
                            jQuery("#studentJobErrorModal").modal({
                                backdrop: "static",
                                keyboard: false,
                                show: true
                            });

                            jQuery('#inputRA').val('');
                            jQuery('#inputStudentName').val('');
                        }
                    },

                    error: function () {
                        jQuery("#studentErrorModal").modal({
                            backdrop: "static",
                            keyboard: false,
                            show: true
                        });

                        jQuery('#inputRA').val('');
                    }
                });
            }

            jQuery('#inputRA').blur(() => {
                if (jQuery('#inputCpfCnpj').val() !== "") {
                    loadStudent();
                }
            });

            jQuery('#inputCompany').select2({
                language: "pt-BR",
                ajax: {
                    url: `{{ config('app.url') }}/api/coordenador/trabalho/empresa`,
                    dataType: 'json',
                    method: 'GET',
                    cache: true,
                    data: function (params) {
                        return {
                            q: params.term // search term
                        };
                    },

                    processResults: function (response) {
                        companies = [];
                        response.forEach(company => {
                            if (company.active) {
                                let formatted_cpf_cnpj;
                                if (company.pj) {
                                    let p1 = company.cpf_cnpj.substring(0, 2);
                                    let p2 = company.cpf_cnpj.substring(2, 5);
                                    let p3 = company.cpf_cnpj.substring(5, 8);
                                    let p4 = company.cpf_cnpj.substring(8, 12);
                                    let p5 = company.cpf_cnpj.substring(12, 14);
                                    formatted_cpf_cnpj = `${p1}.${p2}.${p3}/${p4}-${p5}`;
                                } else {
                                    let p1 = company.cpf_cnpj.substring(0, 3);
                                    let p2 = company.cpf_cnpj.substring(3, 6);
                                    let p3 = company.cpf_cnpj.substring(6, 9);
                                    let p4 = company.cpf_cnpj.substring(9, 11);
                                    formatted_cpf_cnpj = `${p1}.${p2}.${p3}-${p4}`;
                                }

                                let text = `${formatted_cpf_cnpj} - ${company.name}`;
                                if (company.fantasy_name !== null) {
                                    text = `${text} (${company.fantasy_name})`;
                                }

                                companies.push({id: company.id, text: text});
                            }
                        });

                        return {
                            results: companies
                        };
                    },
                }
            });

            jQuery('#inputCompany').on('change', e => {
                jQuery.ajax({
                    url: `{{ config('app.url') }}/api/coordenador/trabalho/empresa/${jQuery('#inputCompany').val()}`,
                    dataType: 'json',
                    method: 'GET',
                    success: function (data) {
                        jQuery('#inputCompanyRepresentative').val(data.representative_name);
                    },
                    error: function () {

                    },
                });
            });
        });
    </script>
@endsection
