{{--
    TODO: empresa
    TODO: => insc municipal, estadual (mei, pf)
--}}

@extends('adminlte::page')

@section('title', 'Nova empresa - SGE CTI')

@section('content_header')
    <h1>Adicionar nova empresa</h1>
@stop

@section('css')

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">

@endsection

@section('content')
    @include('modals.cnpjLoadingModal')
    @include('modals.cnpjErrorModal')

    @include('modals.cepLoadingModal')
    @include('modals.cepErrorModal')

    @include('modals.newCompanySectorModal')

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
        <form class="form-horizontal" action="{{ route('coordenador.empresa.salvar') }}" method="post">
            @csrf

            <div class="box-body">
                <h3>Dados da empresa</h3>

                <input type="hidden" id="inputPj" name="pj" value="0">
                <input type="hidden" id="inputHasConvenio" name="hasConvenio" value="0">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputCpfCnpj" class="col-sm-4 control-label">CPF / CNPJ*</label>

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

                                    <input type="text" class="form-control" id="inputCpfCnpj" name="cpf_cnpj">
                                </div>
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
                    <label for="inputName" class="col-sm-2 control-label">Nome da empresa*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="MSTech"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputFantasyName" class="col-sm-2 control-label">Nome fantasia</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputFantasyName" name="fantasyName" placeholder=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email*</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" name="email"
                               placeholder="dir_cti@feb.unesp.com.br"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputFone" class="col-sm-2 control-label">Telefone*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputFone" name="fone"
                               placeholder="(14) 3103-6150" data-inputmask="'mask': '(99) 9999-9999'"/>
                    </div>
                </div>

                <hr/>
                <h3>Representante</h3>

                <div class="form-group">
                    <label for="inputRepresentative" class="col-sm-2 control-label">Nome do representante*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRepresentative" name="representative"
                               placeholder=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputRepresentativeRole" class="col-sm-2 control-label">Cargo*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRepresentativeRole" name="representativeRole"
                               placeholder="Administração, desenvolvedor..."/>
                    </div>
                </div>

                <hr/>
                <h3>Endereço da empresa</h3>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputCep" class="col-sm-6 control-label">CEP*</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="inputCep" name="cep"
                                       placeholder="17033-260" data-inputmask="'mask': '99999-999'"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputUf" class="col-sm-4 control-label">UF*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputUf" name="uf" placeholder="SP"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputCidade" class="col-sm-4 control-label">Cidade*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputCidade" name="cidade"
                                       placeholder="Bauru"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputRua" class="col-sm-3 control-label">Rua*</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="inputRua" name="rua"
                                       placeholder="Avenida Nações Unidas"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputNumero" class="col-sm-4 control-label">Número*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputNumero" name="numero"
                                       placeholder="58-50"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputComplemento" class="col-sm-2 control-label">Complemento</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputComplemento" name="complemento"
                               placeholder="Casa A1, Apartamento 15..."/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputBairro" class="col-sm-2 control-label">Bairro*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputBairro" name="bairro"
                               placeholder="Vargem Limpa"/>
                    </div>
                </div>

                <hr/>

                <div>
                    <div class="btn-group pull-right" style="display: inline-flex; margin: -5px 0 0 0">
                        <a href="#" class="btn btn-success" id="aAddSector" data-toggle="modal"
                           data-target="#newCompanySectorModal">Adicionar
                            setor</a>
                    </div>

                    <h3>Setores</h3>
                </div>

                <div class="form-group">
                    <label for="inputSectors" class="col-sm-2 control-label">Setores*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="sectors[]" multiple="multiple" id="inputSectors"
                                style="width: 100%">
                            @foreach($sectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr/>
                <h3>Cursos para estágio</h3>

                <div class="form-group">
                    <label for="inputCourses" class="col-sm-2 control-label">Cursos*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="courses[]" multiple="multiple" id="inputCourses"
                                style="width: 100%">
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr/>

                <div class="form-group">
                    <label for="inputHasConvenioDeMentira" class="col-sm-2 control-label" style="padding-top: 0">Registrar
                        convênio?</label>

                    <div class="col-sm-10">
                        <input type="checkbox" id="inputHasConvenioDeMentira" name="hasConvenioDeMentira">
                    </div>
                </div>

                <div id="div-convenio" style="display: none">
                    <h3>Convênio</h3>

                    <div class="form-group">
                        <label for="inputExpirationDate" class="col-sm-2 control-label">Validade*</label>

                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="inputExpirationDate" name="expirationDate"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputObservation" class="col-sm-2 control-label">Observação</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputObservation" name="observation"/>
                        </div>
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
        function pj(isPj) {
            if (isPj) {
                jQuery('#CpfCnpjOption').text('CNPJ');

                $("input[id*='inputCpfCnpj']").inputmask({
                    mask: '99.999.999/9999-99',
                    removeMaskOnSubmit: true
                });

                jQuery('#inputPj').val(1);
            } else {
                jQuery('#CpfCnpjOption').text('CPF');

                $("input[id*='inputCpfCnpj']").inputmask({
                    mask: '999.999.999-99',
                    removeMaskOnSubmit: true
                });

                jQuery('#inputPj').val(0);
            }
        }

        jQuery(document).ready(function () {
            jQuery('#aAddSector').on('click', () => {
                setTimeout(() => {
                    jQuery('#inputSectorActive').select2({
                        language: "pt-BR"
                    });
                }, 250);
            });

            jQuery('.selection').select2({
                language: "pt-BR"
            });

            jQuery(':input').inputmask({removeMaskOnSubmit: true});

            jQuery('#inputHasConvenioDeMentira').on('ifChanged', function () {
                if (this.checked) {
                    jQuery('#div-convenio').css('display', 'initial');
                    jQuery('#inputHasConvenio').val(1);
                } else {
                    jQuery('#div-convenio').css('display', 'none');
                    jQuery('#inputHasConvenio').val(0);
                }
            });

            jQuery('#inputSectors').select2({
                language: "pt-BR",
                ajax: {
                    url: '{{ route('coordenador.empresa.setor.getAjax') }}',
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

            function loadCnpj() {
                if (jQuery('#inputPj').val() === '1') {
                    $("#cnpjLoadingModal").modal({
                        backdrop: "static",
                        keyboard: false,
                        show: true
                    });

                    jQuery.ajax({
                        url: `https://receitaws.com.br/v1/cnpj/${jQuery('#inputCpfCnpj').inputmask('unmaskedvalue')}`,
                        dataType: 'jsonp',
                        type: 'GET',
                        success: function (company) {
                            $("#cnpjLoadingModal").modal("hide");

                            if (company.status === 'ERROR') {
                                $("#cnpjErrorModal").modal({
                                    backdrop: "static",
                                    keyboard: false,
                                    show: true
                                });

                                company.nome = '';
                                company.fantasia = '';
                                company.email = '';
                                company.telefone = '';
                                company.cep = '';
                                company.uf = '';
                                company.municipio = '';
                                company.logradouro = '';
                                company.numero = '';
                                company.complemento = '';
                                company.bairro = '';
                            }

                            console.log(company);
                            jQuery('#inputName').val(company.nome);
                            jQuery('#inputFantasyName').val(company.fantasia);
                            jQuery('#inputEmail').val(company.email);
                            jQuery('#inputFone').val(company.telefone);
                            jQuery('#inputCep').val(company.cep).blur();
                            jQuery('#inputUf').val(company.uf);
                            jQuery('#inputCidade').val(company.municipio);
                            jQuery('#inputRua').val(company.logradouro);
                            jQuery('#inputNumero').val(company.numero);
                            jQuery('#inputComplemento').val(company.complemento);
                            jQuery('#inputBairro').val(company.bairro);
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

            function loadCep() {
                $("#cepLoadingModal").modal({
                    backdrop: "static",
                    keyboard: false,
                    show: true
                });

                let xhttp = new XMLHttpRequest();
                xhttp.open("GET", `https://viacep.com.br/ws/${jQuery('#inputCep').inputmask('unmaskedvalue')}/json/`, true);
                xhttp.onreadystatechange = function () {
                    $("#cepLoadingModal").modal("hide");

                    if (this.readyState === 4) {
                        if (this.status === 200 && this.responseText !== "ViaCEP Bad Request (400)") {
                            let address = JSON.parse(xhttp.responseText);
                            if (address.erro) {
                                $("#cepErrorModal").modal({
                                    backdrop: "static",
                                    keyboard: false,
                                    show: true
                                });

                                address.logradouro = '';
                                address.complemento = '';
                                address.bairro = '';
                                address.localidade = '';
                                address.uf = '';
                            }

                            jQuery('#inputRua').val(address.logradouro).change();
                            jQuery('#inputComplemento').val(address.complemento).change();
                            jQuery('#inputBairro').val(address.bairro).change();
                            jQuery('#inputCidade').val(address.localidade).change();
                            jQuery('#inputUf').val(address.uf).change();
                        } else {
                            $("#cepErrorModal").modal({
                                backdrop: "static",
                                keyboard: false,
                                show: true
                            });
                        }
                    }
                };

                xhttp.send();
            }

            jQuery('#inputCep').blur(() => {
                if (jQuery('#inputCep').val() !== "") {
                    loadCep();
                }
            });

            jQuery('#inputCpfCnpj').blur(() => {
                if (jQuery('#inputCpfCnpj').val() !== "") {
                    loadCnpj();
                }
            });

            pj(true);

            jQuery('#inputHasConvenioDeMentira').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@endsection
