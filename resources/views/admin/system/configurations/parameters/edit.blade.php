@extends('adminlte::page')

@section('title', 'Editar parâmetros do sistema - SGE CTI')

@section('content_header')
    <h1>Editar parâmetros do sistema</h1>
@stop

@section('content')
    @include('modals.cepLoadingModal')
    @include('modals.cepErrorModal')

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Dados do parâmetro</h3>
        </div>

        <form class="form-horizontal" action="{{ route('admin.configuracoes.parametros.alterar', $systemConfig->id) }}" method="post">
            @method('PUT')
            @csrf

            <div class="box-body">
                <div class="form-group @if($errors->has('name')) has-error @endif">
                    <label for="inputName" class="col-sm-2 control-label">Nome do colégio*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name"
                               placeholder="Colégio Técnico Industrial" value="{{ old('name') ?? $systemConfig->name }}"/>

                        <span class="help-block">{{ $errors->first('name') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('cep')) has-error @endif">
                            <label for="inputCep" class="col-sm-6 control-label">CEP*</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="inputCep" name="cep"
                                       placeholder="17033-260" data-inputmask="'mask': '99999-999'"
                                       value="{{ old('cep') ?? $systemConfig->cep }}"/>

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
                                       placeholder="Avenida Nações Unidas" value="{{ old('street') ?? $systemConfig->street }}"/>

                                <span class="help-block">{{ $errors->first('street') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('number')) has-error @endif">
                            <label for="inputNumber" class="col-sm-4 control-label">Número*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputNumber" name="number"
                                       placeholder="58-50" value="{{ old('number') ?? $systemConfig->number }}"/>

                                <span class="help-block">{{ $errors->first('number') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group @if($errors->has('district')) has-error @endif">
                    <label for="inputDistrict" class="col-sm-2 control-label">Bairro*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputDistrict" name="district"
                               placeholder="Vargem Limpa" value="{{ old('district') ?? $systemConfig->district }}"/>

                        <span class="help-block">{{ $errors->first('district') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('email')) has-error @endif">
                    <label for="inputEmail" class="col-sm-2 control-label">Email*</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" name="email"
                               placeholder="dir_cti@feb.unesp.com.br" value="{{ old('email') ?? $systemConfig->email }}"/>

                        <span class="help-block">{{ $errors->first('email') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('phone')) has-error @endif">
                            <label for="inputPhone" class="col-sm-6 control-label">Telefone*</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="inputPhone" name="phone"
                                       placeholder="(14) 3103-6150" data-inputmask="'mask': '(99) 9999-9999'"
                                       value="{{ old('phone') ?? $systemConfig->phone }}"/>

                                <span class="help-block">{{ $errors->first('phone') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group @if($errors->has('extension')) has-error @endif">
                            <label for="inputExtension" class="col-sm-4 control-label">Ramal</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputExtension" name="extension"
                                       placeholder="3845" data-inputmask="'mask': '9999'"
                                       value="{{ old('extension') ?? $systemConfig->extension }}"/>

                                <span class="help-block">{{ $errors->first('extension') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('agreementExpiration')) has-error @endif">
                            <label for="inputAgreementExpiration" class="col-sm-4 control-label">Validade do convênio*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputAgreementExpiration"
                                       name="agreementExpiration" placeholder="5"
                                       value="{{ old('agreementExpiration') ?? $systemConfig->agreement_expiration }}"/>

                                <span class="help-block">{{ $errors->first('agreementExpiration') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                <a href="{{url()->previous()}}" class="btn btn-default">Cancelar</a>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(() => {
            jQuery(':input').inputmask({removeMaskOnSubmit: true});

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

            function loadCep() {
                $("#cepLoadingModal").modal({
                    backdrop: "static",
                    keyboard: false,
                    show: true
                });

                let xhttp = new XMLHttpRequest();
                xhttp.open("GET", `/api/external/cep/${jQuery('#inputCep').inputmask('unmaskedvalue')}`, true);
                xhttp.onreadystatechange = function () {
                    $("#cepLoadingModal").modal("hide");

                    if (this.readyState === 4) {
                        if (this.status === 200) {
                            let address = JSON.parse(xhttp.responseText);
                            if (address.error) {
                                $("#cepErrorModal").modal({
                                    backdrop: "static",
                                    keyboard: false,
                                    show: true
                                });

                                address.street = '';
                                address.district = '';
                                address.city = '';
                                address.uf = '';
                            }

                            jQuery('#inputStreet').val(address.street);
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

            jQuery('#inputUf').append(new Option('{{ old('uf') ?? $systemConfig->uf }}', '{{ old('uf') ?? $systemConfig->uf }}', false, true)).change();
            jQuery('#inputCity').append(new Option('{{ old('city') ?? $systemConfig->city }}', '{{ old('city') ?? $systemConfig->city }}', false, true));

            loadCep();
        });
    </script>
@endsection

