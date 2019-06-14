@extends('adminlte::page')

@section('title', 'Editar estágio - SGE CTI')

@section('content_header')
    <h1>Editar estágio</h1>
@stop

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="box box-default">
        <form class="form-horizontal" action="{{ route('coordenador.estagio.salvar') }}" method="post">
            @csrf

            <div class="box-body">

                <h3>Dados do estágio</h3>

                <input type="hidden" id="inputId" name="id" value="{{ $internship->id }}">
                <input type="hidden" id="inputHasCTPS" name="hasCTPS" value="{{ ($internship->ctps_id == null) ? '0' : '1' }}">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputRA" class="col-sm-4 control-label">RA*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputRA" name="ra"
                                       value="{{ $internship->ra }}" data-inputmask="'mask': '9999999'">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputActive" class="col-sm-4 control-label">Ativo*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                        id="inputActive" name="active">
                                    <option value="1" {{ ($internship->ativo) ? 'selected' : '' }}>Sim</option>
                                    <option value="0" {{ ($internship->ativo) ? '' : 'selected' }}>Não</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputCompany" class="col-sm-2 control-label">Empresa*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="company" id="inputCompany"
                                style="width: 100%">

                            @foreach($companies as $company)

                                <option value="{{ $company->id }}" {{ ($internship->company == $company) ? 'selected' : '' }}>
                                    {{ $company->cpf_cnpj }} - {{ $company->nome }}
                                </option>

                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputSector" class="col-sm-2 control-label">Setor*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="sector" id="inputSector"
                                style="width: 100%">

                            @foreach($internship->company->sectors as $sector)

                                <option value="{{ $sector->id }}" {{ ($internship->company->sector == $sector) ? "selected" : "" }}>
                                    {{ $sector->nome }}
                                </option>

                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputRA" class="col-sm-2 control-label">Horário*</label>

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
                                <td>
                                    <label class="control-label">Entrada</label>
                                </td>

                                <td>
                                    <input name="seg_e" id="inputSegE" type="text" class="form-control input-time"
                                           value="{{ $internship->schedule->seg_e }}">
                                </td>

                                <td>
                                    <input name="ter_e" id="inputTerE" type="text" class="form-control input-time"
                                           value="{{ $internship->schedule->ter_e }}">
                                </td>

                                <td>
                                    <input name="qua_e" id="inputQuaE" type="text" class="form-control input-time"
                                           value="{{ $internship->schedule->qua_e }}">
                                </td>

                                <td>
                                    <input name="qui_e" id="inputQuiE" type="text" class="form-control input-time"
                                           value="{{ $internship->schedule->qui_e }}">
                                </td>

                                <td>
                                    <input name="sex_e" id="inputSexE" type="text" class="form-control input-time"
                                           value="{{ $internship->schedule->sex_e }}">
                                </td>

                                <td>
                                    <input name="sab_e" id="inputSabE" type="text" class="form-control input-time"
                                           value="{{ $internship->schedule->sab_e }}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="control-label">Saída</label>
                                </td>

                                <td>
                                    <input name="seg_s" id="inputSegS" type="text" class="form-control input-time"
                                           value="{{ $internship->schedule->seg_s }}">
                                </td>

                                <td>
                                    <input name="ter_s" id="inputTerS" type="text" class="form-control input-time"
                                           value="{{ $internship->schedule->ter_s }}">
                                </td>

                                <td>
                                    <input name="qua_s" id="inputQuaS" type="text" class="form-control input-time"
                                           value="{{ $internship->schedule->qua_s }}">
                                </td>

                                <td>
                                    <input name="qui_s" id="inputQuiS" type="text" class="form-control input-time"
                                           value="{{ $internship->schedule->qui_s }}">
                                </td>

                                <td>
                                    <input name="sex_s" id="inputSexS" type="text" class="form-control input-time"
                                           value="{{ $internship->schedule->sex_s }}">
                                </td>

                                <td>
                                    <input name="sab_s" id="inputSabS" type="text" class="form-control input-time"
                                           value="{{ $internship->schedule->sab_s }}">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputStart" class="col-sm-4 control-label">Data Início*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputStart" name="start"
                                       value="{{ $internship->data_ini }}"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputEnd" class="col-sm-4 control-label">Data Fim*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputEnd" name="end"
                                       value="{{ $internship->data_fim }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputActivities" class="col-sm-2 control-label">Atividades*</label>

                    <div class="col-sm-10">
                            <textarea class="form-control" rows="3" id="inputActivities" name="activities"
                                      placeholder="O que o aluno fará no estágio">{{ $internship->atividades }}</textarea>
                    </div>
                </div>

                <hr/>

                <div>
                    <div class="btn-group pull-right" style="display: inline-flex; margin: -5px 0 0 0">
                        <a href="#" class="btn btn-success" id="aAddSupervisor" data-toggle="modal"
                           data-target="#newInternshipSupervisorModal">Adicionar
                            supervisor</a>
                    </div>

                    <h3>Supervisor</h3>
                </div>

                <div class="form-group">
                    <label for="inputSupervisor" class="col-sm-2 control-label">Supervisor*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="supervisor" id="inputSupervisor"
                                style="width: 100%">

                            @foreach($internship->company->supervisors as $supervisor)

                                <option value="{{ $supervisor->id }}" {{ ($internship->company->supervisors == $supervisor) ? "selected" : "" }}>
                                    {{ $supervisor->nome }}
                                </option>

                            @endforeach

                        </select>
                    </div>
                </div>

                <hr>

                <h3>Dados da secretaria</h3>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputState" class="col-sm-4 control-label">Estado*</label>

                            <div class="col-sm-8">
                                <select class="selection" name="state" id="inputState"
                                        style="width: 100%">

                                    @foreach($states as $state)

                                        <option value="{{ $state->id }}" {{ ($state->id == $internship->state_id) ? 'selected' : '' }}>
                                            {{ $state->descricao }}
                                        </option>

                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputProtocol" class="col-sm-4 control-label">Protocolo*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputProtocol" name="protocol"
                                       placeholder="001/19" data-inputmask="'mask': '999/99'"
                                       value="{{ $internship->protocolo }}"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputObservation" class="col-sm-2 control-label">Obervação</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputObservation" name="observation"
                               value={{ $internship->observacao }}/>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label for="inputHasCTPSDeMentira" class="col-sm-2 control-label" style="padding-top: 0">O
                        estágio é CTPS?</label>

                    <div class="col-sm-10">
                        <input type="checkbox" id="inputHasCTPSDeMentira" name="hasCTPSDeMentira">
                    </div>
                </div>

                <div id="div-convenio" style="display: none">
                    <h3>CTPS</h3>

                    <div class="form-group">
                        <label for="inputCTPS" class="col-sm-2 control-label">Número da CTPS</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputCTPS" name="ctps"
                                   data-inputmask="'mask': '999999/99999'"/>
                        </div>
                    </div>
                </div>

                <!-- NAO ESQUECER -->
                <input type="hidden" id="inputReasonToCancel" name="reason_to_cancel" value="">
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                <button type="submit" name="cancel" class="btn btn-default">Cancelar</button>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('.selection').select2({
                language: "pt-BR"
            });

            jQuery(':input').inputmask({removeMaskOnSubmit: true});

            jQuery('.input-time').inputmask('hh:mm', {
                removeMaskOnSubmit: false
            });

            jQuery('#inputHasCTPSDeMentira').on('ifChanged', function () {
                if (this.checked) {
                    jQuery('#div-convenio').css('display', 'initial');
                    jQuery('#inputHasCTPS').val(1);
                } else {
                    jQuery('#div-convenio').css('display', 'none');
                    jQuery('#inputHasCTPS').val(0);
                }
            });

            jQuery('#inputSector').select2({
                language: "pt-BR",
                ajax: {
                    url: `/api/empresa/setor/getFromCompany/${jQuery('#inputCompany').val()}`,
                    dataType: 'json',
                    method: 'GET',
                    cache: true,
                    data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },

                    processResults: function (response) {
                        sectors = [];
                        response.sectors.forEach(sector => {
                            if (sector.ativo) {
                                sectors.push({id: sector.id, text: sector.nome});
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
                    url: `/api/empresa/supervisor/getFromCompany/${jQuery('#inputCompany').val()}`,
                    dataType: 'json',
                    method: 'GET',
                    cache: true,
                    data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },

                    processResults: function (response) {
                        supervisors = [];
                        response.supervisors.forEach(supervisor => {
                            if (supervisor.ativo) {
                                supervisors.push({id: supervisor.id, text: supervisor.nome});
                            }
                        });

                        return {
                            results: supervisors
                        };
                    },
                }
            });

            jQuery('#inputHasCTPSDeMentira').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@endsection
