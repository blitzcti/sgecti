<div class="modal fade" id="viewStudentsModal" tabindex="-1" role="dialog" aria-labelledby="viewStudentsModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="deleteModalTitle">Alunos que não entregaram relatório bimestral</h4>
            </div>

            <form action="{{ route('coordenador.relatorio.bimestral.pdf') }}" target="_blank" method="post"
                  id="viewStudentsForm" class="form-horizontal">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputStartDate" class="control-label col-sm-3">Início</label>

                                <div class="col-sm-9">
                                    <input name="startDate" id="inputStartDate" type="date" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEndDate" class="control-label col-sm-3">Término</label>

                                <div class="col-sm-9">
                                    <input name="endDate" id="inputEndDate" type="date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Visualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
    @parent

    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('#viewStudentsForm').submit(e => {
                $('#viewStudentsModal').modal('hide');
            });
        });
    </script>
@endsection
