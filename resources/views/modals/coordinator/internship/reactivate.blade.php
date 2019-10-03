<div class="modal fade" id="internshipReactivateModal" tabindex="-1" role="dialog"
     aria-labelledby="internshipReactivateModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="deleteModalTitle">Reativar estágio</h4>
            </div>

            <form id="reactivateForm" action="#" class="form-horizontal" method="post">
                <div class="modal-body">
                    @method('PUT')
                    @csrf

                    <p>Deseja realmente reativar o estágio de <span id="reactivateModalStudentName"
                                                                    class="text-bold"></span>?</p>
                </div>

                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                        <button type="submit" class="btn btn-primary">Sim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
    @parent

    <script type="text/javascript">
        function reactivateInternshipId(id) {
            jQuery('#reactivateForm').attr('action', `/coordenador/estagio/${id}/reativar`);
        }

        function reactivateStudentName(name) {
            jQuery('#reactivateModalStudentName').text(name);
        }
    </script>
@endsection
