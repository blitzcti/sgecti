<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="deleteModalTitle">Excluir curso</h4>
            </div>

            <form action="{{ route('admin.curso.excluir', $course->id) }}" method="post">
                <div class="modal-body">
                    @csrf

                    <p>Deseja realmente excluir o curso <span id="deleteModalCourseName" class="text-bold"></span>?</p>
                    <p>Tenha em mente que, fazendo isso, serão excluídos também todos os registros que referenciam este
                        curso.</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>
