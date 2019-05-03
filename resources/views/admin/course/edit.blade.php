@extends('adminlte::page')

@section('title', 'Editar curso - SGE CTI')

@section('content_header')
    <h1>Editar curso</h1>
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
        <form class="form-horizontal" action="{{ route('admin.curso.salvar') }}" method="post">
            @csrf

            <div class="box-body">
                <input type="hidden" name="id" value="{{ $course->id }}">

                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nome do curso</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Informática"
                               value="{{ $course->name }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputColor" class="col-sm-2 control-label">Cor do curso</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" id="inputColor" name="color">

                            @foreach($colors as $color)

                                <option value="{{ $color->id }}" {{ $course->id_color == $color->id ? 'selected=selected' : '' }}>
                                    {{ __('colors.' . $color->name) }}
                                </option>

                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputActive" class="col-sm-2 control-label">Ativo</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                id="inputActive" name="active">
                            <option value="1" {{ $course->active ? 'selected=selected' : '' }}>Sim</option>
                            <option value="0" {{! $course->active ? 'selected=selected' : '' }}>Não</option>
                        </select>
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

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('.selection').select2();
        });
    </script>
@endsection
