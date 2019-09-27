<div class="modal fade" id="proposalApproveModal" tabindex="-1" role="dialog" aria-labelledby="proposalApproveModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="approveModalTitle">Aprovar proposta de estágio</h4>
            </div>

            <form id="approveForm" action="#" class="form-horizontal" method="post">
                <div class="modal-body">
                    @method('PUT')
                    @csrf

                    @if(isset($redirect_to))
                        <input type="hidden" name="redirectTo" value="{{ $redirect_to }}"/>
                    @endif

                    <p>Deseja realmente aprovar essa proposta de estágio?</p>
                </div>

                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                        <button type="submit" class="btn btn-success">Sim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
    @parent

    <script type="text/javascript">
        function approveProposalId(id) {
            jQuery('#approveForm').attr('action', `/coordenador/proposta/${id}/aprovar`);
        }
    </script>
@endsection

