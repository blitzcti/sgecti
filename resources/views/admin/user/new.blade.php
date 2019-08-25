@extends('adminlte::page')

@section('title', 'Novo usuário - SGE CTI')

@section('content_header')
    <h1>Adicionar novo usuário</h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Dados do usuário</h3>
        </div>

        <form class="form-horizontal" action="{{ route('admin.usuario.salvar') }}" method="post">
            @csrf

            <div class="box-body">
                <div class="form-group @if($errors->has('name')) has-error @endif">
                    <label for="inputName" class="col-sm-2 control-label">Nome*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="André Castro"
                               value="{{ old('name') ?? '' }}"/>

                        <span class="help-block">{{ $errors->first('name') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('email')) has-error @endif">
                    <label for="inputEmail" class="col-sm-2 control-label">Email*</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" name="email"
                               placeholder="andcastro28@gmail.com" value="{{ old('email') ?? '' }}"/>

                        <span class="help-block">{{ $errors->first('email') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('phone')) has-error @endif">
                    <label for="inputPhone" class="col-sm-2 control-label">Telefone</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputPhone" name="phone"
                               placeholder="(14) 3103-6150" data-inputmask="'mask': ['(99) 9999-9999', '(99) 9 9999-9999']"
                               value="{{ old('phone') ?? '' }}"/>

                        <span class="help-block">{{ $errors->first('phone') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('password')) has-error @endif">
                    <label for="inputPassword" class="col-sm-2 control-label">Senha*</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" name="password"
                               placeholder="Deve ser de no mínimo 8 caracteres"/>

                        <span class="help-block">{{ $errors->first('password') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('password_confirmation')) has-error @endif">
                    <label for="inputPasswordConfirmation" class="col-sm-2 control-label">Confirmar senha*</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPasswordConfirmation" name="password_confirmation"
                               placeholder="Confirme a nova senha"/>

                        <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('role')) has-error @endif">
                    <label for="inputRole" class="col-sm-2 control-label">Grupo*</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" id="inputRole" name="role">

                            @foreach($roles as $role)

                                <option value="{{ $role->id }}"
                                        {{ (old('role') ?? 1) == $role->id ? 'selected' : '' }}>
                                    {{ $role->friendlyName }}
                                </option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('role') }}</span>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Adicionar</button>
                <a href="{{url()->previous()}}" class="btn btn-default">Cancelar</a>
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

            jQuery(':input').inputmask({removeMaskOnSubmit: true});
        });
    </script>
@endsection
