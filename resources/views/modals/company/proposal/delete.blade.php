<div class="modal fade" id="proposalDeleteModal" tabindex="-1" role="dialog" aria-labelledby="proposalDeleteModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="deleteModalTitle">Excluir proposta de estágio</h4>
            </div>

            <form id="deleteForm" action="#" class="form-horizontal" method="post">
                <div class="modal-body">
                    @method('DELETE')
                    @csrf

                    <p>Deseja realmente excluir essa proposta de estágio?</p>
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
            jQuery('#deleteForm').attr('action', `/empresa/proposta/${id}/`);
        }
    </script>
@endsection

