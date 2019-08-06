@extends('adminlte::page')

@section('title', 'Editar usuário - SGE CTI')

@section('content_header')
    <h1>Editar usuário</h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Dados do usuário</h3>
        </div>

        <form class="form-horizontal" action="{{ route('admin.usuario.alterar', $user->id) }}" method="post">
            @method('PUT')
            @csrf

            <div class="box-body">
                <div class="form-group @if($errors->has('name')) has-error @endif">
                    <label for="inputName" class="col-sm-2 control-label">Nome*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="André Castro"
                               value="{{ old('name') ?? $user->name }}"/>

                        <span class="help-block">{{ $errors->first('name') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('email')) has-error @endif">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" name="email"
                               placeholder="andcastro28@gmail.com" value="{{ old('email') ?? $user->email }}"/>

                        <span class="help-block">{{ $errors->first('email') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('phone')) has-error @endif">
                    <label for="inputPhone" class="col-sm-2 control-label">Telefone*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputPhone" name="phone"
                               placeholder="(14) 3103-6150" data-inputmask="'mask': '(99) 9999-9999'"
                               value="{{ old('phone') ?? $user->phone }}"/>

                        <span class="help-block">{{ $errors->first('phone') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('role')) has-error @endif">
                    <label for="inputRole" class="col-sm-2 control-label">Grupo*</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" id="inputRole" name="role">

                            @foreach($roles as $role)

                                <option value="{{ $role->id }}"
                                        {{ (old('role') ?? $user->roles->pluck('id')[0]) == $role->id ? 'selected' : '' }}>
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
                <button type="submit" class="btn btn-primary pull-right">Salvar</button>
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
        });
    </script>
@endsection
