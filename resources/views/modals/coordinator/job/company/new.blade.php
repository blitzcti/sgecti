<div class="modal fade" id="newJobCompanyModal" tabindex="-1" role="dialog" aria-labelledby="newJobCompanyModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="formJobCompany" class="form-horizontal"
                  action="{{ route('api.coordenador.trabalho.empresa.salvar') }}" method="post">
                @csrf

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <h4 class="modal-title" id="deleteModalTitle">Adicionar nova empresa (CTPS)</h4>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="inputCompanyPj" name="pj" value="0">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
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

                                        <input type="text" class="form-control" id="inputCompanyCpfCnpj"
                                               name="cpfCnpj"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputCompanyActive" class="col-sm-4 control-label">Ativo*</label>

                                <div class="col-sm-8">
                                    <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                            id="inputCompanyActive" name="active">
                                        <option value="1" selected="selected">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputCompanyIE" class="col-sm-2 control-label">Inscrição estadual</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputCompanyIE" name="ie"
                                   placeholder="02.232.3355-6" data-inputmask="'mask': '99.999.9999-9'"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputCompanyName" class="col-sm-2 control-label">Nome*</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputCompanyName" name="name"
                                   placeholder="MSTech"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputCompanyFantasyName" class="col-sm-2 control-label">Nome fantasia</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputCompanyFantasyName" name="fantasyName"
                                   placeholder=""/>
                        </div>
                    </div>

                    <hr/>
                    <h4>Representante</h4>

                    <div class="form-group">
                        <label for="inputCompanyRepresentativeName" class="col-sm-2 control-label">Nome*</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputCompanyRepresentativeName"
                                   name="representativeName" placeholder=""/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputCompanyRepresentativeRole" class="col-sm-2 control-label">Cargo*</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputCompanyRepresentativeRole"
                                   name="representativeRole" placeholder="Administração, desenvolvedor..."/>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary pull-right">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
    @parent

    <script type="text/javascript">
        function pj(isPj) {
            if (isPj) {
                jQuery('#CpfCnpjOption').text('CNPJ');

                jQuery("input[id*='inputCompanyCpfCnpj']").inputmask({
                    mask: '99.999.999/9999-99',
                    removeMaskOnSubmit: true
                });

                jQuery('#inputCompanyPj').val(1);
            } else {
                jQuery('#CpfCnpjOption').text('CPF');

                jQuery("input[id*='inputCompanyCpfCnpj']").inputmask({
                    mask: '999.999.999-99',
                    removeMaskOnSubmit: true
                });

                jQuery('#inputCompanyPj').val(0);
            }
        }

        jQuery(document).ready(function () {
            jQuery('#formJobCompany').submit(e => {
                e.preventDefault();

                jQuery.ajax({
                    url: '{{ route('api.coordenador.trabalho.empresa.salvar') }}',
                    data: {
                        cpfCnpj: jQuery('#inputCompanyCpfCnpj').inputmask('unmaskedvalue'),
                        ie: jQuery('#inputCompanyIE').inputmask('unmaskedvalue'),
                        pj: jQuery('#inputCompanyPj').val(),
                        name: jQuery('#inputCompanyName').val(),
                        fantasyName: jQuery('#inputCompanyFantasyName').val(),
                        representativeName: jQuery('#inputCompanyRepresentativeName').val(),
                        representativeRole: jQuery('#inputCompanyRepresentativeRole').val(),
                        active: parseInt(jQuery('#inputCompanyActive').select2('val')),
                    },
                    method: 'POST',
                    success: function (data) {
                        jQuery('#inputCompanyCpfCnpj').val('');
                        jQuery('#inputCompanyIE').val('');
                        jQuery('#inputCompanyPj').val('');
                        jQuery('#inputCompanyName').val('');
                        jQuery('#inputCompanyFantasyName').val('');
                        jQuery('#inputCompanyRepresentativeName').val('');
                        jQuery('#inputCompanyRepresentativeRole').val('');
                        jQuery('#inputCompanyActive').select2('val', '1');

                        jQuery('#newJobCompanyModal').modal('hide');
                    },

                    error: function (data) {
                        let errors = [];
                        for (let key in data.responseJSON.errors) {
                            data.responseJSON.errors[key].forEach(e => {
                                errors.push(e);
                            });
                        }

                        alert(errors.join('\n'));
                    }
                });
            });

            function loadCnpj() {
                if (jQuery('#inputCompanyPj').val() === '1') {
                    jQuery("#cnpjLoadingModal").modal({
                        backdrop: "static",
                        keyboard: false,
                        show: true
                    });

                    jQuery.ajax({
                        url: `{{ config('app.api_prefix') ?? '' }}/api/external/cnpj/${jQuery('#inputCompanyCpfCnpj').inputmask('unmaskedvalue')}`,
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
                            }

                            jQuery('#inputCompanyName').val(company.name);
                            jQuery('#inputCompanyFantasyName').val(company.fantasyName);
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

            jQuery('#inputCompanyCpfCnpj').blur(() => {
                if (jQuery('#inputCompanyCpfCnpj').val() !== "") {
                    loadCnpj();
                }
            });

            pj(1);
        });
    </script>
@endsection
