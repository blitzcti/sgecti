<div class="modal fade" id="agreementReactivateModal" tabindex="-1" role="dialog"
     aria-labelledby="agreementReactivateModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="deleteModalTitle">Reativar convênio</h4>
            </div>

            <form id="reactivateForm" action="#" class="form-horizontal" method="post">
                <div class="modal-body">
                    @method('PUT')
                    @csrf

                    <p>Deseja realmente reativar o convênio de <span id="reactivateModalCompanyName"
                                                                     class="text-bold"></span>?</p>
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
        function reactivateAgreementId(id) {
            jQuery('#reactivateForm').attr('action', `/coordenador/empresa/convenio/${id}/reativar`);
        }

        function reactivateCompanyName(name) {
            jQuery('#reactivateModalCompanyName').text(name);
        }
    </script>
@endsection
