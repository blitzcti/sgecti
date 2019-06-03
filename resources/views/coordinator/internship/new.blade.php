@extends('adminlte::page')

@section('title', 'Novo estágio - SGE CTI')

@section('content_header')
    <h1>Adicionar novo estágio</h1>
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

                <h5>Adicionar botao CTPS</h5>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputRA" class="col-sm-4 control-label">RA*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputRA" name="ra"
                                    placeholder="1757047">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputActive" class="col-sm-4 control-label">Ativo*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                        id="inputActive" name="active">
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
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

                                <option value="{{ $company->id }}">{{ $company->cpf_cnpj }}
                                    - {{ $company->nome }}</option>

                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputSectors" class="col-sm-2 control-label">Setor*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="sectors" id="inputSectors"
                                style="width: 100%">
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
                                    <input name="seg_e" id="inputSegE" type="text" class="form-control input-time">
                                </td>

                                <td>
                                    <input name="ter_e" id="inputTerE" type="text" class="form-control input-time">
                                </td>

                                <td>
                                    <input name="qua_e" id="inputQuaE" type="text" class="form-control input-time">
                                </td>

                                <td>
                                    <input name="qui_e" id="inputQuiE" type="text" class="form-control input-time">
                                </td>

                                <td>
                                    <input name="sex_e" id="inputSexE" type="text" class="form-control input-time">
                                </td>

                                <td>
                                    <input name="sab_e" id="inputSabE" type="text" class="form-control input-time">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="control-label">Saída</label>
                                </td>

                                <td>
                                    <input name="seg_s" id="inputSegS" type="text" class="form-control input-time">
                                </td>

                                <td>
                                    <input name="ter_s" id="inputTerS" type="text" class="form-control input-time">
                                </td>

                                <td>
                                    <input name="qua_s" id="inputQuaS" type="text" class="form-control input-time">
                                </td>

                                <td>
                                    <input name="qui_s" id="inputQuiS" type="text" class="form-control input-time">
                                </td>

                                <td>
                                    <input name="sex_s" id="inputSexS" type="text" class="form-control input-time">
                                </td>

                                <td>
                                    <input name="sab_s" id="inputSabS" type="text" class="form-control input-time">
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
                                <input type="date" class="form-control" id="inputStart" name="start"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputEnd" class="col-sm-4 control-label">Data Fim*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputEnd" name="end"/>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="box-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputState" class="col-sm-4 control-label">Estado*</label>

                                <div class="col-sm-8">
                                    <select class="selection" name="state" id="inputState"
                                            style="width: 100%">

                                        @foreach($states as $state)

                                            <option value="{{ $state->id }}">{{ $state->descricao }}</option>

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
                                        placeholder="001/19"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputActivities" class="col-sm-2 control-label">Atividades*</label>

                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" id="inputActivities" name="activities"
                                      placeholder="O que o aluno fará no estágio"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputObservation" class="col-sm-2 control-label">Obervação</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputObservation" name="observation"/>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Adicionar</button>
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

            jQuery('#inputRA').inputmask('9999999', {
                removeMaskOnSubmit: false
            });

            jQuery('#inputProtocol').inputmask('999/99', {
                removeMaskOnSubmit: false
            });

            jQuery('#inputSectors').select2({
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
        });
    </script>
@endsection
