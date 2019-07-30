<div class="modal fade" id="newInternshipSupervisorModal" tabindex="-1" role="dialog"
     aria-labelledby="newInternshipSupervisorModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formSupervisor" class="form-horizontal" action="{{ route('api.empresa.supervisor.salvar') }}"
                  method="post">
                @csrf

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <h4 class="modal-title" id="deleteModalTitle">Adicionar novo supervisor</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group @if($errors->has('supervisorName')) has-error @endif">
                        <label for="inputSupervisorName" class="col-sm-4 control-label">Nome do supervisor*</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputSupervisorName" name="supervisorName"
                                   placeholder="André Castro"/>
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('supervisorEmail')) has-error @endif">
                        <label for="inputSupervisorEmail" class="col-sm-4 control-label">Email*</label>

                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="inputSupervisorEmail" name="supervisorEmail"
                                   placeholder="andcastro28@gmail.com"/>
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('supervisorPhone')) has-error @endif">
                        <label for="inputSupervisorPhone" class="col-sm-4 control-label">Telefone*</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputSupervisorPhone" name="supervisorPhone"
                                   placeholder="(14) 93103-6150" data-inputmask="'mask': '(99) 99999-9999'"/>
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('company')) has-error @endif">
                        <label for="inputSupervisorCompany" class="col-sm-4 control-label">Empresa*</label>

                        <div class="col-sm-8">
                            <select class="selection" name="company" id="inputSupervisorCompany"
                                    style="width: 100%">

                                @foreach($companies as $company)

                                    <option value="{{ $company->id }}">{{ $company->name }}</option>

                                @endforeach

                            </select>
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
        jQuery(document).ready(() => {
            jQuery('#formSupervisor').submit(e => {
                e.preventDefault();

                jQuery.ajax({
                    url: '{{ route('api.empresa.supervisor.salvar') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'supervisorName': jQuery('#inputSupervisorName').val(),
                        'supervisorEmail': jQuery('#inputSupervisorEmail').val(),
                        'supervisorPhone': jQuery('#inputSupervisorPhone').val(),
                        'company': parseInt(jQuery('#inputSupervisorCompany').select2('val'))
                    },
                    method: 'POST',
                    success: function (data) {
                        if (data.saved) {
                            jQuery('#inputSupervisorName').val('');
                            jQuery('#inputSupervisorEmail').val('');
                            jQuery('#inputSupervisorPhone').val('');
                            jQuery('#inputSupervisorCompany').select2('val', '1');

                            jQuery('#newInternshipSupervisorModal').modal('hide');
                        } else {
                            alert(data.errors.join('\n'));
                        }
                    },

                    error: function () {

                    }
                });
            });
        });
    </script>
@endsection