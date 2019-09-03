@extends('adminlte::page')

@section('title', 'Nova empresa (CTPS) - SGE CTI')

@section('content_header')
    <h1>Adicionar nova empresa (CTPS)</h1>
@stop

@section('content')
    @include('modals.cnpj.loading')
    @include('modals.cnpj.error')

    @include('modals.coordinator.company.sector.new')

    <form class="form-horizontal" action="{{ route('coordenador.trabalho.empresa.salvar') }}" method="post">
        @csrf

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados da empresa</h3>
            </div>

            <div class="box-body">
                <input type="hidden" id="inputPj" name="pj" value="{{ old('pj') ?? '0' }}">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('cpfCnpj')) has-error @endif">
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

                                    <input type="text" class="form-control" id="inputCpfCnpj" name="cpfCnpj"
                                           value="{{ old('cpfCnpj') ?? '' }}">
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
                                    <option value="1" {{ (old('active') ?? 1) ? 'selected=selected' : '' }}>Sim</option>
                                    <option value="0" {{ !(old('active') ?? 1) ? 'selected=selected' : '' }}>Não
                                    </option>
                                </select>

                                <span class="help-block">{{ $errors->first('active') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group @if($errors->has('ie')) has-error @endif">
                    <label for="inputIE" class="col-sm-2 control-label">Inscrição estadual</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputIE" name="ie" placeholder="02.232.3355-6"
                               data-inputmask="'mask': '99.999.9999-9'" value="{{ old('ie') ?? '' }}"/>

                        <span class="help-block">{{ $errors->first('ie') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('name')) has-error @endif">
                    <label for="inputName" class="col-sm-2 control-label">Nome*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="MSTech"
                               value="{{ old('name') ?? '' }}"/>

                        <span class="help-block">{{ $errors->first('name') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('fantasyName')) has-error @endif">
                    <label for="inputFantasyName" class="col-sm-2 control-label">Nome fantasia</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputFantasyName" name="fantasyName"
                               placeholder="" value="{{ old('fantasyName') ?? '' }}"/>

                        <span class="help-block">{{ $errors->first('fantasyName') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do representante</h3>
            </div>

            <div class="box-body">
                <div class="form-group @if($errors->has('representativeName')) has-error @endif">
                    <label for="inputRepresentativeName" class="col-sm-2 control-label">Nome*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRepresentativeName" name="representativeName"
                               placeholder="" value="{{ old('representativeName') ?? '' }}"/>

                        <span class="help-block">{{ $errors->first('representativeName') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('representativeRole')) has-error @endif">
                    <label for="inputRepresentativeRole" class="col-sm-2 control-label">Cargo*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRepresentativeRole" name="representativeRole"
                               placeholder="Administração, desenvolvedor..."
                               value="{{ old('representativeRole') ?? '' }}"/>

                        <span class="help-block">{{ $errors->first('representativeRole') }}</span>
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
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        function pj(isPj) {
            if (isPj) {
                jQuery('#CpfCnpjOption').text('CNPJ');

                jQuery("input[id*='inputCpfCnpj']").inputmask({
                    mask: '99.999.999/9999-99',
                    removeMaskOnSubmit: true
                });

                jQuery('#inputPj').val(1);
            } else {
                jQuery('#CpfCnpjOption').text('CPF');

                jQuery("input[id*='inputCpfCnpj']").inputmask({
                    mask: '999.999.999-99',
                    removeMaskOnSubmit: true
                });

                jQuery('#inputPj').val(0);
            }
        }

        jQuery(document).ready(function () {
            jQuery('.selection').select2({
                language: "pt-BR"
            });

            jQuery(':input').inputmask({removeMaskOnSubmit: true});

            function loadCnpj() {
                if (jQuery('#inputPj').val() === '1') {
                    jQuery("#cnpjLoadingModal").modal({
                        backdrop: "static",
                        keyboard: false,
                        show: true
                    });

                    jQuery.ajax({
                        url: `/api/external/cnpj/${jQuery('#inputCpfCnpj').inputmask('unmaskedvalue')}`,
                        dataType: 'json',
                        type: 'GET',
                        success: function (company) {
                            jQuery("#cnpjLoadingModal").modal("hide");

                            if (company.error) {
                                jQuery("#cnpjErrorModal").modal({
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
                            jQuery("#cnpjLoadingModal").modal("hide");

                            jQuery("#cnpjErrorModal").modal({
                                backdrop: "static",
                                keyboard: false,
                                show: true
                            });
                        }
                    });
                }
            }

            jQuery('#inputCpfCnpj').blur(() => {
                if (jQuery('#inputCpfCnpj').val() !== "") {
                    loadCnpj();
                }
            });

            pj({{ (old('pj') ?? 1) == 1 }});
        });
    </script>
@endsection
