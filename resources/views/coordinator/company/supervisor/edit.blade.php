@extends('adminlte::page')

@section('title', 'Editar supervisor - SGE CTI')

@section('content_header')
    <h1>Editar supervisor</h1>
@stop

@section('content')
    <form class="form-horizontal" action="{{ route('coordenador.empresa.supervisor.alterar', $supervisor->id) }}"
          method="post">
        @method('PUT')
        @csrf

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Dados do supervisor</h3>
            </div>
            <div class="box-body">
                <div class="form-group @if($errors->has('company')) has-error @endif">
                    <label for="inputCompany" class="col-sm-2 control-label">Empresa*</label>

                    <div class="col-sm-10">
                        <select class="selection" name="company" id="inputCompany"
                                style="width: 100%">

                            @foreach($companies as $company)

                                <option
                                    value="{{ $company->id }}" {{ (old('company') ?? $supervisor->company_id) == $company->id ? 'selected' : '' }}>
                                    {{ $company->formatted_cpf_cnpj }} - {{ $company->name }} {{ $company->fantasy_name != null ? " ($company->fantasy_name)" : '' }}
                                </option>

                            @endforeach

                        </select>

                        <span class="help-block">{{ $errors->first('company') }}</span>
                    </div>
                </div>

                <div class="form-group @if($errors->has('supervisorName')) has-error @endif">
                    <label for="inputSupervisorName" class="col-sm-2 control-label">Nome*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputSupervisorName" name="supervisorName"
                               placeholder="André Castro" value="{{ old('supervisorName') ?? $supervisor->name }}"/>

                        <span class="help-block">{{ $errors->first('supervisorName') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group @if($errors->has('supervisorEmail')) has-error @endif">
                            <label for="inputSupervisorEmail" class="col-sm-3 control-label">Email*</label>

                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="inputSupervisorEmail"
                                       name="supervisorEmail" placeholder="andcastro28@gmail.com"
                                       value="{{ old('supervisorEmail') ?? $supervisor->email }}"/>

                                <span class="help-block">{{ $errors->first('supervisorEmail') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group @if($errors->has('supervisorPhone')) has-error @endif">
                            <label for="inputSupervisorPhone" class="col-sm-3 control-label">Telefone*</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="inputSupervisorPhone" name="supervisorPhone"
                                       placeholder="(14) 93103-6150"
                                       data-inputmask="'mask': ['(99) 9999-9999', '(99) 99999-9999']"
                                       value="{{ old('supervisorPhone') ?? $supervisor->phone }}"/>

                                <span class="help-block">{{ $errors->first('supervisorPhone') }}</span>
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

            jQuery('#inputSupervisorPhone').inputmask('(99)99999-9999', {
                removeMaskOnSubmit: true
            });
        });
    </script>
@endsection
