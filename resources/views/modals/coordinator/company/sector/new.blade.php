<div class="modal fade" id="newCompanySectorModal" tabindex="-1" role="dialog" aria-labelledby="newCompanySectorModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formSetor" class="form-horizontal" action="{{ route('api.empresa.setor.salvar') }}"
                  method="post">
                @csrf

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <h4 class="modal-title" id="deleteModalTitle">Adicionar novo setor</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group @if($errors->has('sectorName')) has-error @endif">
                        <label for="inputSectorName" class="col-sm-3 control-label">Nome</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputSectorName" name="name"
                                   placeholder="Administrativo"/>
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('sectorDescription')) has-error @endif">
                        <label for="inputSectorDescription" class="col-sm-3 control-label">Descrição</label>

                        <div class="col-sm-9">
                            <textarea class="form-control" rows="3" id="inputSectorDescription" name="sectorDescription"
                                      style="resize: none" placeholder="Descrição do setor"></textarea>
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('active')) has-error @endif">
                        <label for="inputSectorActive" class="col-sm-3 control-label">Ativo</label>

                        <div class="col-sm-9">
                            <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                    id="inputSectorActive" name="active">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
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
            jQuery('#formSetor').submit(e => {
                e.preventDefault();

                jQuery.ajax({
                    url: '{{ route('api.empresa.setor.salvar') }}',
                    data: {
                        'name': jQuery('#inputSectorName').val(),
                        'description': jQuery('#inputSectorDescription').val(),
                        'active': parseInt(jQuery('#inputSectorActive').select2('val'))
                    },
                    method: 'POST',
                    success: function (data) {
                        jQuery('#inputSectorName').val('');
                        jQuery('#inputSectorDescription').val('');
                        jQuery('#inputSectorActive').select2('val', '1');

                        jQuery('#newCompanySectorModal').modal('hide');
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
        });
    </script>
@endsection
