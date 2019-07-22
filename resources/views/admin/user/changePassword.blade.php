@extends('adminlte::page')

@section('title', 'Alterar senha - SGE CTI')

@section('content_header')
    <h1>Alterar senha</h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Senha</h3>
        </div>

        <form class="form-horizontal" action="{{ route('admin.usuario.salvarSenha', $user->id) }}" method="post">
            @csrf

            <div class="box-body">
                <div class="form-group  @if($errors->has('oldPassword')) has-error @endif">
                    <label for="inputOldPassword" class="col-sm-2 control-label">Senha atual*</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputOldPassword" name="old_password"
                               placeholder="Senha atualmente em uso"/>

                        <span class="help-block">{{ $errors->first('oldPassword') }}</span>
                    </div>
                </div>

                <div class="form-group  @if($errors->has('password')) has-error @endif">
                    <label for="inputPassword" class="col-sm-2 control-label">Nova senha*</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" name="password"
                               placeholder="Nova senha (Deve ser de no mínimo 8 caracteres)"/>

                        <span class="help-block">{{ $errors->first('password') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('passwordConfirmation')) has-error @endif">
                    <label for="inputPasswordConfirmation" class="col-sm-2 control-label">Confirmar senha*</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPasswordConfirmation"
                               name="password_confirmation" placeholder="Confirme a nova senha"/>

                        <span class="help-block">{{ $errors->first('passwordConfirmation') }}</span>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="{{url()->previous()}}" class="btn btn-default">Cancelar</a>
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
