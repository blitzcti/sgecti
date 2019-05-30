@extends('adminlte::page')

@section('title', 'Novo estágio - SGE CTI')

@section('content_header')
    <h1>Adicionar novo estágio</h1>
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
        <form class="form-horizontal" action="{{ route('coordenador.estagio.salvar') }}" method="post">
            @csrf

            <div class="box-body">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputRA" class="col-sm-4 control-label">RA*</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputRA" name="ra" placeholder="mascaraaa">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputActive" class="col-sm-4 control-label">Ativo*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                        id="inputActive" name="active">
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputCompany" class="col-sm-2 control-label">Empresa*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="company" id="inputCompany"
                                style="width: 100%">

                            @foreach($companies as $company)

                                <option value="{{ $company->id }}">{{ $company->cpf_cnpj }} - {{ $company->nome }}</option>

                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputRA" class="col-sm-2 control-label">Setor*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRA" name="ra"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputRA" class="col-sm-2 control-label">HORARIO*</label>
                </div>

                <div class="form-group">
                    <label for="inputRA" class="col-sm-2 control-label">Data ini e fim*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRA" name="ra"/>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label for="inputRA" class="col-sm-2 control-label">Estado*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRA" name="ra"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputRA" class="col-sm-2 control-label">Protocolo*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRA" name="ra"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputRA" class="col-sm-2 control-label">Atividades*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRA" name="ra"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputRA" class="col-sm-2 control-label">Obervação</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputRA" name="ra"/>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Adicionar</button>
                <button type="submit" name="cancel" class="btn btn-default">Cancelar</button>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('.selection').select2({
                language: "pt-BR"
            });
        });
    </script>
@endsection
