<div class="modal fade" id="internshipCancelModal" tabindex="-1" role="dialog" aria-labelledby="proposalCancelModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="deleteModalTitle">Cancelar proposta de estágio</h4>
            </div>

            <form id="cancelForm" action="#" class="form-horizontal" method="post">
                <div class="modal-body">
                    @method('PUT')
                    @csrf

                    <p>Deseja realmente cancelar essa proposta de estágio?</p>
                    <p>Essa ação não poderá ser desfeita</p>
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
        function proposalId(id) {
            jQuery('#cancelForm').attr('action', `/empresa/proposta/${id}/cancelar`);
        }
    </script>
@endsection

