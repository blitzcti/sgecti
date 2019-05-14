@extends('adminlte::page')

@section('title', 'Alterar senha - SGE CTI')

@section('content_header')
    <h1>Alterar senha</h1>
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
        <form class="form-horizontal" action="{{ route('admin.usuario.salvarSenha') }}" method="post">
            @csrf

            <div class="box-body">
                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="form-group">
                    <label for="inputOldPassword" class="col-sm-2 control-label">Senha atual</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputOldPassword" name="old_password"
                               placeholder="Senha atualmente em uso"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">Nova senha</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" name="password"
                               placeholder="Nova senha (Deve ser de no mínimo 8 caracteres)"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPasswordConfirmation" class="col-sm-2 control-label">Confirmar senha</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPasswordConfirmation"
                               name="password_confirmation" placeholder="Confirme a nova senha"/>
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
