@extends('adminlte::page')

@section('title', 'Editar usuário')

@section('content_header')
    <h1>Editar usuário</h1>
@stop

@section('content')
    <form class="form-horizontal" action="{{ route('admin.usuario.alterar', ['id' => $user->id]) }}" method="post">
        @method('PUT')
        @csrf

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do usuário</h3>
            </div>

            <div class="box-body">

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group @if($errors->has('name')) has-error @endif">
                            <label for="inputName" class="col-sm-3 control-label">Nome*</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="inputName" name="name"
                                       placeholder="André Castro"
                                       value="{{ old('name') ?? $user->name }}"/>

                                <span class="help-block">{{ $errors->first('name') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('role')) has-error @endif">
                            <label for="inputRole" class="col-sm-2 control-label">Grupo*</label>

                            <div class="col-sm-10">
                                <select class="form-control selection" id="inputRole" name="role">

                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ (old('role') ?? $user->roles->pluck('id')[0]) == $role->id ? 'selected' : '' }}>
                                            {{ $role->friendly_name }}
                                        </option>
                                    @endforeach

                                </select>

                                <span class="help-block">{{ $errors->first('role') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('email')) has-error @endif">
                            <label for="inputEmail" class="col-sm-4 control-label">Email</label>

                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="inputEmail" name="email"
                                       placeholder="andcastro28@gmail.com" value="{{ old('email') ?? $user->email }}"/>

                                <span class="help-block">{{ $errors->first('email') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('phone')) has-error @endif">
                            <label for="inputPhone" class="col-sm-2 control-label">Telefone</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputPhone" name="phone"
                                       placeholder="(14) 3103-6150"
                                       data-inputmask="'mask': ['(99) 9999-9999', '(99) 99999-9999']"
                                       value="{{ old('phone') ?? $user->phone }}"/>

                                <span class="help-block">{{ $errors->first('phone') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary pull-right">Salvar</button>

                <input type="hidden" id="inputPrevious" name="previous"
                       value="{{ old('previous') ?? url()->previous() }}">
                <a href="{{ old('previous') ?? url()->previous() }}" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    </form>
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
