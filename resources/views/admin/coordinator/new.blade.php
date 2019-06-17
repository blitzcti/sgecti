@extends('adminlte::page')

@section('title', 'Novo coordenador - SGE CTI')

@section('content_header')
    <h1>Adicionar novo Coordenador</h1>
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
        <form class="form-horizontal" action="{{ route('admin.coordenador.salvar') }}" method="post">
            @csrf

            <div class="box-body">
                <h3>Dados do coordenador</h3>
                <hr/>

                <div class="form-group">
                    <label for="inputUser" class="col-sm-2 control-label">Coordenador*</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" id="inputUser" name="user">

                            @foreach($users as $user)

                                <option value="{{ $user->id }}">
                                    {{ __($user->name) }}
                                </option>

                            @endforeach

                        </select>
                    </div>

                </div>

                <div class="form-group">
                    <label for="inputCourse" class="col-sm-2 control-label">Curso*</label>

                    <div class="col-sm-10">
                        <select class="form-control selection" id="inputCourse" name="course">

                            @foreach($courses as $course)

                                <option value="{{ $course->id }}" {{ ($c == $course->id) ? 'selected' : '' }}>
                                    {{ __($course->name) }}
                                </option>

                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputValidity_ini" class="col-sm-4 control-label">Vigência Início*</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputStart" name="start"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputValidity_fim" class="col-sm-4 control-label">Vigência Fim</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputEnd" name="end"/>
                            </div>
                        </div>
                    </div>
                </div>

                <h4>Botoes de hoje, ano que vem, ...</h4>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="cancel" class="btn btn-default">Cancelar</button>
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
        });
    </script>
@endsection
