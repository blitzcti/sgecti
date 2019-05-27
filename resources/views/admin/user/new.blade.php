@extends('adminlte::page')

@section('title', 'Novo usuário - SGE CTI')

@section('content_header')
    <h1>Adicionar novo usuário</h1>
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
        <form class="form-horizontal" action="{{ route('admin.usuario.salvar') }}" method="post">
            @csrf

            <div class="box-body">
                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nome do usuário*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="André Castro"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email*</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" name="email"
                               placeholder="andcastro28@gmail.com"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">Senha*</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" name="password"
                               placeholder="Deve ser de no mínimo 8 caracteres"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputRole" class="col-sm-2 control-label">Grupo do usuário*</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" id="inputRole" name="role">

                            @foreach($roles as $role)

                                <option value="{{ $role->id }}">
                                    {{ $role->friendlyName }}
                                </option>

                            @endforeach

                        </select>
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
