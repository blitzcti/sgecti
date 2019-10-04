<div class="modal fade" id="graduateModal" tabindex="-1" role="dialog" aria-labelledby="graduateModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="graduateModalTitle">Graduar aluno</h4>
            </div>

            <form id="graduateForm" action="#" class="form-horizontal" method="post">
                @method('PUT')
                @csrf

                <div class="modal-body">
                    <p>O aluno <span id="graduateModalStudentName" class="text-bold"></span> relamente colou grau?</p>
                    <p>Essa ação não poderá ser desfeita.</p>
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
        function graduateStudent(id) {
            jQuery('#graduateForm').attr('action', `/admin/colacao/${id}/graduar`);
        }

        function studentName(name) {
            jQuery('#graduateModalStudentName').text(name);
        }
    </script>
@endsection

