@extends('adminlte::page')

@section('title', 'Editar curso')

@section('content_header')
    <h1>Editar curso</h1>
@stop

@section('content')
    <form class="form-horizontal" action="{{ route('admin.curso.alterar', ['id' => $course->id]) }}" method="post">
        @method('PUT')
        @csrf

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do curso</h3>
            </div>

            <div class="box-body">
                <div class="form-group @if($errors->has('name')) has-error @endif">
                    <label for="inputName" class="col-sm-2 control-label">Nome*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Informática"
                               value="{{ old('name') ?? $course->name }}"/>

                        <span class="help-block">{{ $errors->first('name') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('color')) has-error @endif">
                            <label for="inputColor" class="col-sm-4 control-label">Cor*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" id="inputColor" name="color">

                                    @foreach($colors as $color)
                                        <option value="{{ $color->id }}"
                                            {{ (old('color') ?? $course->color_id) == $color->id ? 'selected=selected' : '' }}>
                                            {{ __("colors.{$color->name}") }}
                                        </option>
                                    @endforeach

                                </select>

                                <span class="help-block">{{ $errors->first('color') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('active')) has-error @endif">
                            <label for="inputActive" class="col-sm-4 control-label">Ativo*</label>

                            <div class="col-sm-8">
                                <select class="form-control selection" data-minimum-results-for-search="Infinity"
                                        id="inputActive" name="active">
                                    <option value="1"
                                        {{ (old('active') ?? $course->active) ? 'selected=selected' : '' }}>Sim
                                    </option>
                                    <option value="0"
                                        {{ !(old('active') ?? $course->active) ? 'selected=selected' : '' }}>Não
                                    </option>
                                </select>

                                <span class="help-block">{{ $errors->first('active') }}</span>
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
        });
    </script>
@endsection
