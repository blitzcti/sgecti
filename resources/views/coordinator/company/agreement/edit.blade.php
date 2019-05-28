@extends('adminlte::page')

@section('title', 'Editar convênio - SGE CTI')

@section('content_header')
    <h1>Editar convênio</h1>
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
        <form class="form-horizontal" action="{{ route('coordenador.empresa.convenio.salvar') }}" method="post">
            @csrf

            <div class="box-body">

                <input type="hidden" name="id" value="{{ $agreement->id }}">
                <input type="hidden" name="company" value="{{ $agreement->company->id }}">

                <div class="form-group">
                    <label for="inputCompanyName" class="col-sm-2 control-label">Empresa conveniada*</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputCompanyName" name="companyName"
                               value="{{ $agreement->company->nome }}" readonly/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputExpirationDate" class="col-sm-2 control-label">Validade*</label>

                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="date" class="form-control" id="inputExpirationDate" name="expirationDate"
                                   value="{{ $agreement->validade }}" readonly/>

                            <span class="input-group-btn">
                                <button id="btnCancelAgreement" type="button"
                                        class="btn btn-danger">Cancelar convênio</button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputObservation" class="col-sm-2 control-label">Observação</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputObservation" name="observation"
                               value="{{ $agreement->observacao }}"/>
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
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('.selection').select2({
                language: "pt-BR"
            });

            jQuery('#btnCancelAgreement').on('click', () => {
                jQuery('#inputExpirationDate').val('{{ date("Y-m-d") }}');
            });
        });
    </script>
@endsection
