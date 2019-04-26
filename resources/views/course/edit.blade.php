@extends('adminlte::page')

@section('title', 'Editar curso - SGE CTI')

@section('content_header')
    <h1>Editar curso</h1>
@stop

@section('content')
    <div class="box box-default">
        <form class="form-horizontal" action="/curso/salvar" method="post">
            <div class="box-body">
                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nome do curso</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Informática"
                               required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputColor" class="col-sm-2 control-label">Cor do curso</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" id="inputColor" name="color">
                            <option value="red">Vermelho</option>
                            <option value="green">Verde</option>
                            <option value="aqua">Aqua</option>
                            <option value="blue">Azul</option>
                            <option value="yellow">Amarelo</option>
                            <option value="black">Preto</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputActive" class="col-sm-2 control-label">Ativo</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" id="inputActive" name="active">
                            <option value="true">Sim</option>
                            <option value="false">Não</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-default">Cancelar</button>
                <button type="submit" class="btn btn-info pull-right">Adicionar</button>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('.selection').select2();
        });
    </script>
@endsection
