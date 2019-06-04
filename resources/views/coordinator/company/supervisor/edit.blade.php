@extends('adminlte::page')

@section('title', 'Editar supervisor - SGE CTI')

@section('content_header')
    <h1>Editar supervisor</h1>
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
        <form class="form-horizontal" action="{{ route('coordenador.empresa.supervisor.salvar') }}" method="post">
            @csrf

            <input type="hidden" name="id" value="{{ $supervisor->id }}">

            <div class="box-body">
                <div class="form-group">
                    <label for="inputSupervisorName" class="col-sm-2 control-label">Nome do supervisor*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputSupervisorName" name="supervisorName"
                               value="{{ $supervisor->nome }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputSupervisorEmail" class="col-sm-2 control-label">Email*</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputSupervisorEmail" name="supervisorEmail"
                               value="{{ $supervisor->email }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputSupervisorFone" class="col-sm-2 control-label">Telefone*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputSupervisorFone" name="supervisorFone"
                               data-inputmask="'mask': '(99) 99999-9999'"
                               value="{{ $supervisor->telefone }}"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputCompany" class="col-sm-2 control-label">Empresa*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="company" id="inputCompany"
                                style="width: 100%">

                            @foreach($companies as $company)

                                <option value="{{ $company->id }}" {{ ($company->id == $supervisor->company_id) ? 'selected' : '' }}>
                                    {{ $company->nome }}
                                </option>

                            @endforeach

                        </select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                    <button type="submit" name="cancel" class="btn btn-default">Cancelar</button>
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

            jQuery(':input').inputmask({removeMaskOnSubmit: true});

            jQuery('#inputSupervisorFone').inputmask('(99)99999-9999', {
                removeMaskOnSubmit: true
            });
        });
    </script>
@endsection
