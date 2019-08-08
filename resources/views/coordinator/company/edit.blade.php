@extends('adminlte::page')

@section('title', 'Editar empresa - SGE CTI')

@section('content_header')
    <h1>Editar empresa</h1>
@stop

@section('content')
    @include('modals.cep.loading')
    @include('modals.cep.error')

    @include('modals.cnpj.loading')
    @include('modals.cnpj.error')

    @include('modals.coordinator.company.sector.new')

    <form class="form-horizontal" action="{{ route('coordenador.empresa.alterar', $company->id) }}" method="post">
        @method('PUT')
        @csrf


        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados da empresa</h3>
            </div>

            <div class="box-body">
                <input type="hidden" id="inputPj" name="pj" value="{{ old('pj') ?? $company->pj }}">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('cpfCnpj')) has-error @endif">
                            <label for="inputCpfCnpj" class="col-sm-4 control-label">CPF / CNPJ*</label>

                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default">
                                            <span id="CpfCnpjOption"></span></button>
                                    </div>

                                    <input type="text" class="form-control" id="inputCpfCnpj" name="cpfCnpj"
                                           value="{{ old('cpfCnpj') ?? $company->cpf_cnpj }}" readonly>
                                </div>

                                <span class="help-block">{{ $errors->first('cpfCnpj') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('active')) has-error @endif">
                            <label for="inputActive" class="col-sm-4 control-label">Ativo*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                        id="inputActive" name="active">
                                    <option value="1"
                                            {{ (old('active') ?? $company->active) ? 'selected=selected' : '' }}>Sim
                                    </option>
                                    <option value="0"
                                            {{ !(old('active') ?? $company->active) ? 'selected=selected' : '' }}>Não
                                    </option>
                                </select>

                                <span class="help-block">{{ $errors->first('active') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group @if($errors->has('name')) has-error @endif">
                    <label for="inputName" class="col-sm-2 control-label">Nome da empresa*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="MSTech"
                               value="{{ old('name') ?? $company->name }}"/>

                        <span class="help-block">{{ $errors->first('name') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('fantasyName')) has-error @endif">
                    <label for="inputFantasyName" class="col-sm-2 control-label">Nome fantasia</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputFantasyName" name="fantasyName"
                               value="{{ old('fantasyName') ?? $company->fantasy_name }}"/>

                        <span class="help-block">{{ $errors->first('fantasyName') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('email')) has-error @endif">
                    <label for="inputEmail" class="col-sm-2 control-label">Email*</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" name="email"
                               placeholder="dir_cti@feb.unesp.com.br" value="{{ old('email') ?? $company->email }}"/>

                        <span class="help-block">{{ $errors->first('email') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('phone')) has-error @endif">
                    <label for="inputPhone" class="col-sm-2 control-label">Telefone*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputPhone" name="phone"
                               placeholder="(14) 3103-6150" data-inputmask="'mask': '(99) 9999-9999'"
                               value="{{ old('phone') ?? $company->phone }}"/>

                        <span class="help-block">{{ $errors->first('phone') }}</span>
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
                <h3 class="box-title">Dados do representante</h3>
            </div>

            <div class="box-body">
                <div class="form-group @if($errors->has('representativeName')) has-error @endif">
                    <label for="inputRepresentativeName" class="col-sm-2 control-label">Nome do representante*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRepresentativeName" name="representativeName"
                               value="{{ old('representativeName') ?? $company->representative_name }}"/>

                        <span class="help-block">{{ $errors->first('representativeName') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('representativeRole')) has-error @endif">
                    <label for="inputRepresentativeRole" class="col-sm-2 control-label">Cargo*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRepresentativeRole" name="representativeRole"
                               placeholder="Administração, desenvolvedor..."
                               value="{{ old('representativeRole') ?? $company->representative_role }}"/>

                        <span class="help-block">{{ $errors->first('representativeRole') }}</span>
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
                <h3 class="box-title">Endereço da empresa</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('cep')) has-error @endif">
                            <label for="inputCep" class="col-sm-6 control-label">CEP*</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="inputCep" name="cep"
                                       placeholder="17033-260" data-inputmask="'mask': '99999-999'"
                                       value="{{ old('cep') ?? $address->cep }}"/>

                                <span class="help-block">{{ $errors->first('cep') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('uf')) has-error @endif">
                            <label for="inputUf" class="col-sm-4 control-label">UF*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" id="inputUf" name="uf"></select>

                                <span class="help-block">{{ $errors->first('uf') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('city')) has-error @endif">
                            <label for="inputCity" class="col-sm-4 control-label">Cidade*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" id="inputCity" name="city"></select>

                                <span class="help-block">{{ $errors->first('city') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group @if($errors->has('street')) has-error @endif">
                            <label for="inputStreet" class="col-sm-3 control-label">Rua*</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="inputStreet" name="street"
                                       placeholder="Avenida Nações Unidas"
                                       value="{{ old('street') ?? $address->street }}"/>

                                <span class="help-block">{{ $errors->first('street') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('number')) has-error @endif">
                            <label for="inputNumber" class="col-sm-4 control-label">Número*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputNumber" name="number"
                                       placeholder="58-50" value="{{ old('number') ?? $address->number }}"/>

                                <span class="help-block">{{ $errors->first('number') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group @if($errors->has('complement')) has-error @endif">
                    <label for="inputComplement" class="col-sm-2 control-label">Complemento</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputComplement" name="complement"
                               placeholder="Casa A1, Apartamento 15..."
                               value="{{ old('complement') ?? $address->complement }}"/>

                        <span class="help-block">{{ $errors->first('complement') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('district')) has-error @endif">
                    <label for="inputDistrict" class="col-sm-2 control-label">Bairro*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputDistrict" name="district"
                               placeholder="Vargem Limpa" value="{{ old('district') ?? $address->district }}"/>

                        <span class="help-block">{{ $errors->first('district') }}</span>
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
                <h3 class="box-title">Setores e cursos</h3>
            </div>

            <div class="box-body">
                <div class="form-group @if($errors->has('sectors')) has-error @endif">
                    <label for="inputSectors" class="col-sm-2 control-label">Setores*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="sectors[]" multiple="multiple" id="inputSectors"
                                style="width: 100%">

                            @foreach($sectors as $sector)

                                <option value="{{ $sector->id }}" {{ in_array($sector->id, old('sectors') ?? array_column($company->sectors->toArray(), 'id')) ? "selected" : "" }}>
                                    {{ $sector->name }}
                                </option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('sectors') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('courses')) has-error @endif">
                    <label for="inputCourses" class="col-sm-2 control-label">Cursos*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="courses[]" multiple="multiple" id="inputCourses"
                                style="width: 100%">

                            @foreach($courses as $course)

                                <option value="{{ $course->id }}" {{ in_array($course->id, old('courses') ?? array_column($company->courses->toArray(), 'id')) ? "selected" : "" }}>
                                    {{ $course->name }}
                                </option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('courses') }}</span>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="btn-group pull-right">
                    <a href="#" class="btn btn-success" id="aAddSector" data-toggle="modal"
                       data-target="#newCompanySectorModal">Novo setor</a>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>

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

            jQuery('#inputSectors').select2({
                language: "pt-BR",
                ajax: {
                    url: '{{ route('api.empresa.setor.get') }}',
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

            jQuery('#inputUf').select2({
                language: "pt-BR",
                ajax: {
                    url: '/api/external/ufs',
                    dataType: 'json',
                    method: 'GET',
                    cache: true,
                    data: function (params) {
                        return {
                            q: params.term // search term
                        };
                    },

                    processResults: function (response) {
                        ufs = [];
                        response.forEach(uf => {
                            ufs.push({id: uf.sigla, text: uf.sigla});
                        });

                        return {
                            results: ufs
                        };
                    },
                },
            });

            jQuery('#inputUf').on('change', e => {
                jQuery('#inputCity').select2({
                    language: "pt-BR",
                    ajax: {
                        url: `/api/external/cities/${jQuery('#inputUf').val()}`,
                        dataType: 'json',
                        method: 'GET',
                        cache: true,
                        data: function (params) {
                            return {
                                q: params.term // search term
                            };
                        },

                        processResults: function (response) {
                            cities = [];
                            response.forEach(city => {
                                cities.push({id: city.nome, text: city.nome});
                            });

                            return {
                                results: cities
                            };
                        },
                    },
                });
            });

            function loadCnpj() {
                if (jQuery('#inputPj').val() === '1') {
                    $("#cnpjLoadingModal").modal({
                        backdrop: "static",
                        keyboard: false,
                        show: true
                    });

                    jQuery.ajax({
                        url: `/api/external/cnpj/${jQuery('#inputCpfCnpj').inputmask('unmaskedvalue')}`,
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
                                company.email = '';
                                company.phone = '';
                                company.cep = '';
                                company.uf = '';
                                company.city = '';
                                company.street = '';
                                company.number = '';
                                company.complement = '';
                                company.district = '';
                            }

                            jQuery('#inputName').val(company.name);
                            jQuery('#inputFantasyName').val(company.fantasyName);
                            jQuery('#inputEmail').val(company.email);
                            jQuery('#inputPhone').val(company.phone);
                            jQuery('#inputCep').val(company.cep);

                            loadCep({
                                uf: company.uf,
                                city: company.city,
                                street: company.street,
                                number: company.number,
                                complement: company.complement,
                                district: company.district
                            });
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

            function loadCep(data = null) {
                $("#cepLoadingModal").modal({
                    backdrop: "static",
                    keyboard: false,
                    show: true
                });

                jQuery.ajax({
                    url: `/api/external/cep/${jQuery('#inputCep').inputmask('unmaskedvalue')}`,
                    dataType: 'json',
                    type: 'GET',
                    success: function (address) {
                        $("#cepLoadingModal").modal("hide");

                        let fields = [
                            'street', 'number', 'complement', 'district', 'city', 'uf'
                        ];

                        if (address.error) {
                            $("#cepErrorModal").modal({
                                backdrop: "static",
                                keyboard: false,
                                show: true
                            });

                            fields.forEach(f => {
                                address[f] = '';
                            });
                        }

                        if (data !== null && typeof data === "object") {
                            if (!address.hasOwnProperty('number')) {
                                address.number = '';
                            }

                            fields.forEach(f => {
                                if (address[f] === '') {
                                    address[f] = data[f];
                                }
                            });

                            jQuery('#inputNumber').val(address.number);
                        }

                        jQuery('#inputStreet').val(address.street);
                        jQuery('#inputComplement').val(address.complement);
                        jQuery('#inputDistrict').val(address.district);

                        if (address.city !== '') {
                            jQuery('#inputCity').append(new Option(address.city, address.city, false, true));
                        } else {
                            jQuery('#inputCity').val(address.city);
                        }


                        if (address.uf !== '') {
                            jQuery('#inputUf').append(new Option(address.uf, address.uf, false, true)).change();
                        } else {
                            jQuery('#inputUf').val(address.uf);
                        }
                    },

                    error: function () {
                        $("#cepLoadingModal").modal("hide");

                        $("#cepErrorModal").modal({
                            backdrop: "static",
                            keyboard: false,
                            show: true
                        });
                    }
                });
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

            pj(jQuery('#inputPj').val() === '1');

            //jQuery('#inputCpfCnpj').blur();

            jQuery('#inputUf').append(new Option('{{ old('uf') ?? $address->uf }}', '{{ old('uf') ?? $address->uf }}', false, true)).change();
            jQuery('#inputCity').append(new Option('{{ old('city') ?? $address->city }}', '{{ old('city') ?? $address->city }}', false, true));
        });
    </script>
@endsection
