<div class="modal fade" id="reportWarningModal" tabindex="-1" role="dialog" aria-labelledby="reportWarningModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="warningModalTitle">Aviso</h4>
            </div>

            <div class="modal-body">
                <p>Deseja realmente cadastrar esse relatório final?</p>
                <p id="warningMessage"></p>
            </div>

            <div class="modal-footer">
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                    <button type="button" class="btn btn-warning"
                            onclick="ignore = true; jQuery('#formReport').submit();">
                        Sim
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
    @parent

    <script type="text/javascript">
        function warningMessage(str) {
            jQuery('#warningMessage').text(str);
        }
    </script>
@endsection

