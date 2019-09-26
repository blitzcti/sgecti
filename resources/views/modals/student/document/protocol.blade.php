<div class="modal fade" id="documentProtocol" tabindex="-1" role="dialog" aria-labelledby="documentProtocol"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="documentProtocolTitle">Protocolo de estágio</h4>
            </div>

            <form id="protocolForm" action="{{ route('aluno.documento.protocolo') }}" target="_blank"
                  class="form-horizontal" method="get">
                <div class="modal-body">
                    <p>Qual tipo de protocolo de estágio você precisa?</p>

                    <p><b>Plano de estágio:</b> entrada nos documentos para <b>iniciar</b> um estágio</p>
                    <p><b>Relatório final:</b> entrada nos documentos para <b>finalizar</b> um estágio</p>

                    <br>

                    <input type="radio" name="id" value="0" checked> Plano de estágio
                    &nbsp;
                    <input type="radio" name="id" value="1"> Relatório final
                </div>

                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Gerar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

