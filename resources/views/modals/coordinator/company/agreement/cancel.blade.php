<div class="modal fade" id="agreementCancelModal" tabindex="-1" role="dialog" aria-labelledby="agreementCancelModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="deleteModalTitle">Cancelar convênio</h4>
            </div>

            <form id="cancelForm" action="#" class="form-horizontal" method="post">
                <div class="modal-body">
                    @method('PUT')
                    @csrf

                    <p>Deseja realmente cancelar o convênio de <span id="cancelModalCompanyName"
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
        function agreementId(id) {
            jQuery('#cancelForm').attr('action', `{{ config('app.url') }}/coordenador/empresa/convenio/${id}/cancelar`);
        }

        function companyName(name) {
            jQuery('#cancelModalCompanyName').text(name);
        }
    </script>
@endsection
