<div class="modal fade" id="internshipCancelModal" tabindex="-1" role="dialog" aria-labelledby="internshipCancelModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="deleteModalTitle">Cancelar estágio</h4>
            </div>

            <form id="cancelForm" action="#" class="form-horizontal" method="post">
                <div class="modal-body">
                    @method('PUT')
                    @csrf

                    <p>Deseja realmente cancelar o estágio de <span id="cancelModalStudentName"
                                                                    class="text-bold"></span>?</p>

                    <div class="form-group">
                        <label for="inputReasonToCancel" class="col-sm-4 control-label">Motivo do cancelamento*</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputReasonToCancel" name="reasonToCancel"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                    <button type="submit" class="btn btn-danger">Sim</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
    @parent

    <script type="text/javascript">
        function internshipId(id) {
            jQuery('#cancelForm').attr('action', `/coordenador/estagio/${id}/cancelar`);
        }

        function studentName(name) {
            jQuery('#cancelModalStudentName').text(name);
        }
    </script>
@endsection
