@extends('adminlte::page')

@section('title', 'Editar parâmetros do sistema - SGE CTI')

@section('content_header')
    <h1>Editar parâmetros do sistema</h1>
@stop

@section('content')
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
                    <label for="inputName" class="col-sm-2 control-label">Nome do curso</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="nome" placeholder="Informática"
                               value="{{ $systemConfig->nome }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">CEP</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputCep" name="cep" placeholder="Informática"
                               value="{{ $systemConfig->cep }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">UF</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputUf" name="uf" placeholder="Informática"
                               value="{{ $systemConfig->uf }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Cidade</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputCidade" name="cidade" placeholder="Informática"
                               value="{{ $systemConfig->cidade }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Rua</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRua" name="rua" placeholder="Informática"
                               value="{{ $systemConfig->rua }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Número</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputNumero" name="numero" placeholder="Informática"
                               value="{{ $systemConfig->numero }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Bairro</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputBairro" name="bairro" placeholder="Informática"
                               value="{{ $systemConfig->bairro }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Telefone</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputFone" name="fone" placeholder="Informática"
                               value="{{ $systemConfig->fone }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputEmail" name="email" placeholder="Informática"
                               value="{{ $systemConfig->email }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Ramal</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRamal" name="ramal" placeholder="Informática"
                               value="{{ $systemConfig->ramal }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Validade do Convênio</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputValidade_convenio" name="validade_convenio" placeholder="Informática"
                               value="{{ $systemConfig->validade_convenio }}"/>
                    </div>
                </div>


            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="cancel" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-primary pull-right">Salvar</button>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
@endsection
