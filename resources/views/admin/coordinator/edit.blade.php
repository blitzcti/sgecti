@extends('adminlte::page')

@section('title', 'Editar coordenador - SGE CTI')

@section('content_header')
    <h1>Editar coordenador</h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Dados do coordenador</h3>
        </div>

        <form class="form-horizontal" action="{{ route('admin.coordenador.alterar', $coordinator->id) }}" method="post">
            @method('PUT')
            @csrf

            <div class="box-body">
                <div class="form-group @if($errors->has('user')) has-error @endif">
                    <label for="inputUser" class="col-sm-2 control-label">Usuário</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" id="inputUser" name="user">

                            @foreach($users as $user)

                                <option value="{{ $user->id }}" {{ (old('user') ?? $user->id) == $coordinator->user->id ? 'selected=selected' : '' }}>
                                    {{ __($user->name) }}
                                </option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('user') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('course')) has-error @endif">
                    <label for="inputCourse" class="col-sm-2 control-label">Curso</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" id="inputCourse" name="course">

                            @foreach($courses as $course)

                                <option value="{{ $course->id }}" {{ (old('course') ?? $coordinator->course->id) == $course->id ? 'selected=selected' : '' }}>
                                    {{ __($course->name) }}
                                </option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('course') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('startDate')) has-error @endif">
                            <label for="inputStartDate" class="col-sm-4 control-label">Vigência Início</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputStartDate" name="startDate"
                                       value="{{ old('startDate') ?? $coordinator->start_date }}"/>

                                <span class="help-block">{{ $errors->first('startDate') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('endDate')) has-error @endif">
                            <label for="inputEndDate" class="col-sm-4 control-label">Vigência Fim</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputEndDate" name="endDate"
                                       value="{{ old('endDate') ?? $coordinator->end_date }}"/>

                                <span class="help-block">{{ $errors->first('endDate') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <h4>Botoes de hoje, ano que vem, ...</h4>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="{{url()->previous()}}" class="btn btn-default">Cancelar</a>
                <button type="submit" class="btn btn-primary pull-right">Salvar</button>
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
