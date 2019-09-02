<div class="modal fade" id="changeInternshipEndDateModal" tabindex="-1" role="dialog"
     aria-labelledby="changeInternshipEndDateModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="deleteModalTitle">Editar data de término</h4>
            </div>

            <div class="modal-body">
                <div class="form-group @if($errors->has('newEndDate')) has-error @endif">
                    <label class="control-label col-sm-4" for="inputNewEndDate">Nova data de término</label>

                    <div class="col-sm-8">
                        <input type="date" class="form-control" id="inputNewEndDate" name="newEndDate"
                               value="{{ old('newEndDate') ?? '' }}"/>

                        <span class="help-block">{{ $errors->first('newEndDate') }}</span>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"
                        onclick="changeEndDate(); return false;">Aplicar</button>
            </div>
        </div>
    </div>
</div>
