@extends('adminlte::page')

@section('title', 'Editar parâmetros do sistema - SGE CTI')

@section('content_header')
    <h1>Editar parâmetros do sistema</h1>
@stop

@section('content')
    @include('modals.cepLoadingModal')
    @include('modals.cepErrorModal')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="box box-default">
        <form class="form-horizontal" action="{{ route('admin.configuracoes.parametros.salvar') }}" method="post">
            @csrf

            <div class="box-body">
                <input type="hidden" name="id" value="{{ $systemConfig->id }}">

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nome do colégio</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name"
                               placeholder="Colégio Técnico Industrial" value="{{ $systemConfig->nome }}"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputCep" class="col-sm-6 control-label">CEP</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="inputCep" name="cep"
                                       placeholder="17033-260" data-inputmask="'mask': '99999-999'"
                                       value="{{ $systemConfig->cep }}"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputUf" class="col-sm-4 control-label">UF</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputUf" name="uf" placeholder="SP"
                                       value="{{ $systemConfig->uf }}"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputCidade" class="col-sm-4 control-label">Cidade</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputCidade" name="cidade"
                                       placeholder="Bauru" value="{{ $systemConfig->cidade }}"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputRua" class="col-sm-3 control-label">Rua</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="inputRua" name="rua"
                                       placeholder="Avenida Nações Unidas" value="{{ $systemConfig->rua }}"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputNumero" class="col-sm-4 control-label">Número</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputNumero" name="numero"
                                       placeholder="58-50" value="{{ $systemConfig->numero }}"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputBairro" class="col-sm-2 control-label">Bairro</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputBairro" name="bairro"
                               placeholder="Vargem Limpa" value="{{ $systemConfig->bairro }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" name="email"
                               placeholder="dir_cti@feb.unesp.com.br" value="{{ $systemConfig->email }}"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputFone" class="col-sm-6 control-label">Telefone</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="inputFone" name="fone"
                                       placeholder="(14) 3103-6150" data-inputmask="'mask': '(99) 9999-9999'"
                                       value="{{ $systemConfig->fone }}"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="inputRamal" class="col-sm-4 control-label">Ramal</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputRamal" name="ramal"
                                       placeholder="3845" data-inputmask="'mask': '9999'"
                                       value="{{ $systemConfig->ramal }}"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputValidadeConvenio" class="col-sm-4 control-label">Validade do
                                convênio</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputValidadeConvenio"
                                       name="validade_convenio" placeholder="5"
                                       value="{{ $systemConfig->validade_convenio }}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                <button type="submit" name="cancel" class="btn btn-default">Cancelar</button>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(() => {
            jQuery(':input').inputmask({removeMaskOnSubmit: true});

            function loadCep() {
                $("#cepLoadingModal").modal({
                    backdrop: "static",
                    keyboard: false,
                    show: true
                });

                let xhttp = new XMLHttpRequest();
                xhttp.open("GET", `https://viacep.com.br/ws/${jQuery('#inputCep').inputmask('unmaskedvalue')}/json/`, true);
                xhttp.onreadystatechange = function () {
                    $("#cepLoadingModal").modal("hide");

                    if (this.readyState === 4) {
                        if (this.status === 200 && this.responseText !== "ViaCEP Bad Request (400)") {
                            let address = JSON.parse(xhttp.responseText);
                            if (address.erro) {
                                $("#cepErrorModal").modal({
                                    backdrop: "static",
                                    keyboard: false,
                                    show: true
                                });

                                address.logradouro = '';
                                address.bairro = '';
                                address.localidade = '';
                                address.uf = '';
                            }

                            jQuery('#inputRua').val(address.logradouro).change();
                            jQuery('#inputBairro').val(address.bairro).change();
                            jQuery('#inputCidade').val(address.localidade).change();
                            jQuery('#inputUf').val(address.uf).change();
                        } else {
                            $("#cepErrorModal").modal({
                                backdrop: "static",
                                keyboard: false,
                                show: true
                            });
                        }
                    }
                };

                xhttp.send();
            }

            jQuery('#inputCep').blur(() => {
                if (jQuery('#inputCep').val() !== "") {
                    loadCep();
                }
            });

            loadCep();
        });
    </script>
@endsection

