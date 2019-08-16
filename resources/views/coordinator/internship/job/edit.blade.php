@extends('adminlte::page')

@section('title', 'Editar trabalho - SGE CTI')

@section('content_header')
    <h1>Editar trabalho</h1>
@stop

@section('content')

    @include('modals.coordinator.company.supervisor.new')
    @include('modals.coordinator.student.search')

    <form class="form-horizontal" action="{{ route('coordenador.estagio.trabalho.alterar', $job->id) }}" method="post">
        @method('PUT')
        @csrf

        <input type="hidden" id="inputCompanyPJ" name="companyPJ" value="{{ old('companyPJ') ?? $job->company_pj }}">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados da empresa</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('companyCpfCnpj')) has-error @endif">
                            <label for="inputCompanyCpfCnpj" class="col-sm-4 control-label">CPF / CNPJ*</label>

                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default dropdown-toggle"
                                                data-toggle="dropdown">
                                            <span id="CpfCnpjOption"></span>


                                            <span class="fa fa-caret-down"></span></button>

                                        <ul class="dropdown-menu">
                                            <li><a href="#" onclick="pj(true); return false;">CNPJ</a></li>
                                            <li><a href="#" onclick="pj(false); return false;">CPF</a></li>
                                        </ul>
                                    </div>

                                    <input type="text" class="form-control" id="inputCompanyCpfCnpj" name="companyCpfCnpj"
                                           value="{{ old('companyCpfCnpj') ?? $job->company_cpf_cnpj }}">
                                </div>

                                <span class="help-block">{{ $errors->first('companyCpfCnpj') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('companyIE')) has-error @endif">
                            <label for="inputCompanyIE" class="col-sm-4 control-label">Inscrição estadual</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputCompanyIE" name="companyIE" placeholder="02.232.3355-6"
                                       data-inputmask="'mask': '99.999.9999-9'" value="{{ old('companyIE') ?? $job->company_ie }}"/>

                                <span class="help-block">{{ $errors->first('companyIE') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group @if($errors->has('companyName')) has-error @endif">
                    <label for="inputCompanyName" class="col-sm-2 control-label">Nome da empresa*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputCompanyName" name="companyName" placeholder="MSTech"
                               value="{{ old('companyName') ?? $job->company_name }}"/>

                        <span class="help-block">{{ $errors->first('companyName') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('companyFantasyName')) has-error @endif">
                    <label for="inputCompanyFantasyName" class="col-sm-2 control-label">Nome fantasia</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputCompanyFantasyName" name="companyFantasyName"
                               placeholder="" value="{{ old('companyFantasyName') ?? $job->company_fantasy_name }}"/>

                        <span class="help-block">{{ $errors->first('companyFantasyName') }}</span>
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
                                           readonly data-inputmask="'mask': '9999999'"
                                           value="{{ old('ra') ?? $job->ra }}">

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
                    <label for="inputStudentName" class="col-sm-2 control-label">Aluno</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputStudentName" name="student" readonly
                               value="{{ App\Models\NSac\Student::find(old('ra') ?? $job->ra)->nome ?? '' }}"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('startDate')) has-error @endif">
                            <label for="inputStartDate" class="col-sm-4 control-label">Data Início*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputStartDate" name="startDate"
                                       value="{{ old('startDate') ?? $job->start_date }}"/>

                                <span class="help-block">{{ $errors->first('startDate') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('endDate')) has-error @endif">
                            <label for="inputEndDate" class="col-sm-4 control-label">Data Fim*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputEndDate" name="endDate"
                                       value="{{ old('endDate') ?? $job->end_date }}">

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
                                       value="{{ old('protocol') ?? $job->protocol }}"/>

                                <span class="help-block">{{ $errors->first('protocol') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('ctps')) has-error @endif">
                            <label for="inputCTPS" class="col-sm-4 control-label">Número da CTPS</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputCTPS" name="ctps"
                                       data-inputmask="'mask': '999999/99999'" value="{{ old('ctps') ?? $job->ctps }}"/>

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
                                      placeholder="O que o aluno fez no trabalho">{{ old('activities') ?? $job->activities }}</textarea>

                        <span class="help-block">{{ $errors->first('activities') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('observation')) has-error @endif">
                    <label for="inputObservation" class="col-sm-2 control-label">Obervação</label>

                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" id="inputObservation" name="observation"
                                  style="resize: none"
                                  placeholder="Observações adicionais">{{ old('observation') ?? $job->observation ?? '' }}</textarea>

                        <span class="help-block">{{ $errors->first('observation') }}</span>
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
        function pj(isPj) {
            if (isPj) {
                jQuery('#CpfCnpjOption').text('CNPJ');

                $("input[id*='inputCompanyCpfCnpj']").inputmask({
                    mask: '99.999.999/9999-99',
                    removeMaskOnSubmit: true
                });

                jQuery('#inputCompanyPJ').val(1);
            } else {
                jQuery('#CpfCnpjOption').text('CPF');

                $("input[id*='inputCompanyCpfCnpj']").inputmask({
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

            function loadCnpj() {
                if (jQuery('#inputCompanyPJ').val() === '1') {
                    $("#cnpjLoadingModal").modal({
                        backdrop: "static",
                        keyboard: false,
                        show: true
                    });

                    jQuery.ajax({
                        url: `/api/external/cnpj/${jQuery('#inputCompanyCpfCnpj').inputmask('unmaskedvalue')}`,
                        dataType: 'json',
                        type: 'GET',
                        success: function (company) {
                            $("#cnpjLoadingModal").modal("hide");

                            if (company.error) {
                                $("#cnpjErrorModal").modal({
                                    backdrop: "static",
                                    keyboard: false,
                                    show: true
                                });

                                company.name = '';
                                company.fantasyName = '';
                            }

                            jQuery('#inputCompanyName').val(company.name);
                            jQuery('#inputCompanyFantasyName').val(company.fantasyName);
                        },

                        error: function () {
                            $("#cnpjLoadingModal").modal("hide");

                            $("#cnpjErrorModal").modal({
                                backdrop: "static",
                                keyboard: false,
                                show: true
                            });
                        }
                    });
                }
            }

            jQuery('#inputCompanyCpfCnpj').blur(() => {
                if (jQuery('#inputCompanyCpfCnpj').val() !== "") {
                    loadCnpj();
                }
            });

            pj(jQuery('#inputCompanyPJ').val() === '1');
        });
    </script>
@endsection
