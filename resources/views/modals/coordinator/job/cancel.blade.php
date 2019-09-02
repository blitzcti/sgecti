<div class="modal fade" id="jobCancelModal" tabindex="-1" role="dialog" aria-labelledby="jobCancelModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="deleteModalTitle">Cancelar trabalho</h4>
            </div>

            <form id="cancelForm" action="#" class="form-horizontal" method="post">
                <div class="modal-body">
                    @method('PUT')
                    @csrf

                    <p>Deseja realmente cancelar o trabalho de <span id="cancelModalStudentName"
                                                                     class="text-bold"></span>?</p>

                    <div class="form-group @if($errors->has('canceledAt')) has-error @endif">
                        <label class="control-label col-sm-2" for="inputCanceledAt">Data*</label>

                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="inputCanceledAt" name="canceledAt"
                                   value="{{ old('canceledAt') ?? '' }}"/>

                            <span class="help-block">{{ $errors->first('canceledAt') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputReasonToCancel" class="col-sm-2 control-label">Motivo*</label>

                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" id="inputReasonToCancel" name="reasonToCancel"
                                      style="resize: none" required
                                      placeholder="O motivo do cancelamento do trabalho"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                        <button type="submit" class="btn btn-danger">Sim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
    @parent

    <script type="text/javascript">
        function jobId(id) {
            jQuery('#cancelForm').attr('action', `/coordenador/trabalho/${id}/cancelar`);
        }

        function studentName(name) {
            jQuery('#cancelModalStudentName').text(name);
        }
    </script>
@endsection
