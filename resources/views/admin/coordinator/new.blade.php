@extends('adminlte::page')

@section('title', 'Novo coordenador - SGE CTI')

@section('content_header')
    <h1>Adicionar novo Coordenador</h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Dados do coordenador</h3>
        </div>

        <form class="form-horizontal" action="{{ route('admin.coordenador.salvar') }}" method="post">
            @csrf

            <div class="box-body">
                <div class="form-group @if($errors->has('user')) has-error @endif">
                    <label for="inputUser" class="col-sm-2 control-label">Usuário*</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" id="inputUser" name="user">

                            @foreach($users as $user)

                                @if($user->hasRole('teacher'))

                                    <option value="{{ $user->id }}"
                                        {{ (old('user') ?? 1) == $user->id ? 'selected=selected' : '' }}>
                                        {{ __($user->name) }}
                                    </option>

                                @endif

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('user') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('course')) has-error @endif">
                    <label for="inputCourse" class="col-sm-2 control-label">Curso*</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" id="inputCourse" name="course">

                            @foreach($courses as $course)

                                <option
                                    value="{{ $course->id }}" {{ ((old('course') ?? $c) == $course->id) ? 'selected' : '' }}>
                                    {{ __($course->name) }}
                                </option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('course') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('tempOf')) has-error @endif">
                    <label for="inputTempOf" class="col-sm-2 control-label">Temporário de</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" id="inputTempOf" name="tempOf">

                            <option value="0">(Nenhum)</option>
                            @foreach($coordinators as $coord)

                                <option value="{{ $coord->id }}" {{ (old('tempOf') ?? 0) == $coord->id ? 'selected=selected' : '' }}>
                                    {{ __($coord->user->name) }} - {{ $coord->course->name }}
                                </option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('tempOf') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group @if($errors->has('startDate')) has-error @endif">
                            <label for="inputStartDate" class="col-sm-4 control-label">Vigência Início*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputStartDate" name="startDate"
                                       value="{{ old('startDate') ?? date("Y-m-d") }}"/>

                                <span class="help-block">{{ $errors->first('startDate') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputEndDate" class="col-sm-4 control-label">Vigência Fim*</label>

                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default dropdown-toggle"
                                                data-toggle="dropdown">
                                            <span id="EndDateToggle"></span>


                                            <span class="fa fa-caret-down"></span></button>

                                        <ul class="dropdown-menu">
                                            <li><a href="#" onclick="endDate(0); return false;">6 meses</a></li>
                                            <li><a href="#" onclick="endDate(1); return false;">1 ano</a></li>
                                            <li><a href="#" onclick="endDate(2); return false;">2 anos</a></li>
                                            <li><a href="#" onclick="endDate(3); return false;">Indefinido</a></li>
                                        </ul>
                                    </div>

                                    <input type="date" class="form-control" id="inputEndDate" name="endDate"
                                           value="{{ old('endDate') ?? '' }}">
                                </div>

                                <span class="help-block">{{ $errors->first('endDate') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="{{url()->previous()}}" class="btn btn-default">Cancelar</a>
                <button type="submit" class="btn btn-primary pull-right">Adicionar</button>
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

            endDate(0);
        });

        function addDays(date, days) {
            let result = new Date(date);
            result.setDate(result.getDate() + days);
            return result;
        }

        function endDate(id) {
            switch (id) {
                case 0: {
                    jQuery('#EndDateToggle').text('6 meses');
                    let newDate = addDays(jQuery('#inputStartDate').val(), 30 * 6);
                    newDate = newDate.toISOString().slice(0, 10);
                    jQuery('#inputEndDate').val(newDate);
                    break;
                }

                case 1: {
                    jQuery('#EndDateToggle').text('1 ano');
                    let newDate = addDays(jQuery('#inputStartDate').val(), 365);
                    newDate = newDate.toISOString().slice(0, 10);
                    jQuery('#inputEndDate').val(newDate);
                    break;
                }

                case 2: {
                    jQuery('#EndDateToggle').text('2 anos');
                    let newDate = addDays(jQuery('#inputStartDate').val(), 365 * 2);
                    newDate = newDate.toISOString().slice(0, 10);
                    jQuery('#inputEndDate').val(newDate);
                    break;
                }

                case 3: {
                    jQuery('#EndDateToggle').text('Indefinido');
                    jQuery('#inputEndDate').val('');
                    break;
                }
            }
        }
    </script>
@endsection
