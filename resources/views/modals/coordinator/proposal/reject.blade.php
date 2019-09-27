<div class="modal fade" id="proposalRejectModal" tabindex="-1" role="dialog" aria-labelledby="proposalRejectModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="deleteModalTitle">Rejeitar proposta de estágio</h4>
            </div>

            <form id="rejectForm" action="#" class="form-horizontal" method="post">
                @method('PUT')
                @csrf

                @if(isset($redirect_to))
                    <input type="hidden" name="redirectTo" value="{{ $redirect_to }}"/>
                @endif

                <div class="modal-body">
                    <p>Deseja realmente rejeitar essa proposta de estágio?</p>

                    <div class="form-group">
                        <label for="inputReasonToReject" class="col-sm-2 control-label">Motivo*</label>

                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" id="inputReasonToReject" name="reasonToReject"
                                      style="resize: none" required
                                      placeholder="O motivo da rejeição da proposta"></textarea>
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
        function rejectProposalId(id) {
            jQuery('#rejectForm').attr('action', `/coordenador/proposta/${id}/rejeitar`);
        }
    </script>
@endsection

