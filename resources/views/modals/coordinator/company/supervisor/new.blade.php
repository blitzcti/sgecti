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
                    <div class="form-group @if($errors->has('company')) has-error @endif">
                        <label for="inputSupervisorCompany" class="col-sm-3 control-label">Empresa*</label>

                        <div class="col-sm-9">
                            <select class="selection" name="company" id="inputSupervisorCompany"
                                    style="width: 100%">

                                @foreach($companies as $company)

                                    <option value="{{ $company->id }}">{{ $company->cpf_cnpj }}
                                        - {{ $company->name }} {{ $company->fantasy_name != null ? " ($company->fantasy_name)" : '' }}
                                    </option>

                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('supervisorName')) has-error @endif">
                        <label for="inputSupervisorName" class="col-sm-3 control-label">Nome*</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputSupervisorName" name="supervisorName"
                                   placeholder="André Castro"/>
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('supervisorEmail')) has-error @endif">
                        <label for="inputSupervisorEmail" class="col-sm-3 control-label">Email*</label>

                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="inputSupervisorEmail" name="supervisorEmail"
                                   placeholder="andcastro28@gmail.com"/>
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('supervisorPhone')) has-error @endif">
                        <label for="inputSupervisorPhone" class="col-sm-3 control-label">Telefone*</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputSupervisorPhone" name="supervisorPhone"
                                   placeholder="(14) 93103-6150"
                                   data-inputmask="'mask': ['(99) 9999-9999', '(99) 9 9999-9999']"/>
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
            });

            jQuery('#formSupervisor').submit(e => {
                e.preventDefault();

                jQuery.ajax({
                    url: '{{ route('api.coordenador.empresa.supervisor.salvar') }}',
                    data: {
                        'supervisorName': jQuery('#inputSupervisorName').val(),
                        'supervisorEmail': jQuery('#inputSupervisorEmail').val(),
                        'supervisorPhone': jQuery('#inputSupervisorPhone').val(),
                        'company': parseInt(jQuery('#inputSupervisorCompany').select2('val'))
                    },
                    method: 'POST',
                    success: function (data) {
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
