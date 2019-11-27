<div class="modal fade" id="newInternshipSupervisorModal" tabindex="-1" role="dialog"
     aria-labelledby="newInternshipSupervisorModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formSupervisor" class="form-horizontal" action="{{ route('api.coordenador.empresa.supervisor.salvar') }}"
                  method="post">
                @csrf

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <h4 class="modal-title" id="deleteModalTitle">Adicionar novo supervisor</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputSupervisorCompany" class="col-sm-3 control-label">Empresa*</label>

                        <div class="col-sm-9">
                            <select class="selection" name="company" id="inputSupervisorCompany"
                                    style="width: 100%">

                                @foreach($companies as $company)

                                    <option value="{{ $company->id }}">
                                        {{ $company->formatted_cpf_cnpj }} - {{ $company->name }} {{ $company->fantasy_name != null ? " ($company->fantasy_name)" : '' }}
                                    </option>

                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputSupervisorName" class="col-sm-3 control-label">Nome*</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputSupervisorName" name="supervisorName"
                                   placeholder="André Castro"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputSupervisorEmail" class="col-sm-3 control-label">Email*</label>

                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="inputSupervisorEmail" name="supervisorEmail"
                                   placeholder="andcastro28@gmail.com"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputSupervisorPhone" class="col-sm-3 control-label">Telefone*</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputSupervisorPhone" name="supervisorPhone"
                                   placeholder="(14) 93103-6150"
                                   data-inputmask="'mask': ['(99) 9999-9999', '(99) 99999-9999']"/>
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
        jQuery(document).ready(function () {
            jQuery('#inputSupervisorCompany').select2({
                language: "pt-BR",
                tags: true,
                dropdownParent: jQuery("#newInternshipSupervisorModal"),
                ajax: {
                    url: `{{ config('app.url') }}/api/coordenador/empresa?agreement=${jQuery('#inputStartDate').val()}`,
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

            jQuery('#formSupervisor').submit(e => {
                e.preventDefault();

                jQuery.ajax({
                    url: '{{ route('api.coordenador.empresa.supervisor.salvar') }}',
                    data: {
                        company: parseInt(jQuery('#inputSupervisorCompany').select2('val')),
                        name: jQuery('#inputSupervisorName').val(),
                        email: jQuery('#inputSupervisorEmail').val(),
                        phone: jQuery('#inputSupervisorPhone').val(),
                    },
                    method: 'POST',
                    success: function (data) {
                        jQuery('#inputSupervisor').append(new Option(`${jQuery('#inputSupervisorName').val()}`, `${data.id}`, false, true));

                        jQuery('#inputSupervisorName').val('');
                        jQuery('#inputSupervisorEmail').val('');
                        jQuery('#inputSupervisorPhone').val('');
                        jQuery('#inputSupervisorCompany').select2('val', '1');

                        jQuery('#newInternshipSupervisorModal').modal('hide');
                    },

                    error: function () {
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
        });
    </script>
@endsection
