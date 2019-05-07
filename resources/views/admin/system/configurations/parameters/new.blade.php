@extends('adminlte::page')

@section('title', 'Novo parâmetro do sistema - SGE CTI')

@section('content_header')
    <h1>Novo parâmetro do sistema</h1>
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
                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nome do curso</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="nome" placeholder="Informática"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">CEP</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputCep" name="cep" placeholder="Informática"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">UF</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputUf" name="uf" placeholder="Informática"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Cidade</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputCidade" name="cidade"
                               placeholder="Informática"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Rua</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRua" name="rua" placeholder="Informática"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Número</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputNumero" name="numero"
                               placeholder="Informática"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Bairro</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputBairro" name="bairro"
                               placeholder="Informática"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Telefone</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputFone" name="fone" placeholder="Informática"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputEmail" name="email" placeholder="Informática"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Ramal</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRamal" name="ramal" placeholder="Informática"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Validade do Convênio</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputValidade_convenio" name="validade_convenio"
                               placeholder="Informática"/>
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
