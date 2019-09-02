<div class="modal fade" id="jobReactivateModal" tabindex="-1" role="dialog"
     aria-labelledby="jobReactivateModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="deleteModalTitle">Reativar trabalho</h4>
            </div>

            <form id="reactivateForm" action="#" class="form-horizontal" method="post">
                <div class="modal-body">
                    @method('PUT')
                    @csrf

                    <p>Deseja realmente reativar o trabalho de <span id="reactivateModalStudentName"
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
        function reactivateJobId(id) {
            jQuery('#reactivateForm').attr('action', `/coordenador/trabalho/${id}/reativar`);
        }

        function reactivateStudentName(name) {
            jQuery('#reactivateModalStudentName').text(name);
        }
    </script>
@endsection
