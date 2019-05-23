@extends('adminlte::page')

@section('title', 'Backup e restauração - SGE CTI')

@section('content_header')
    <h1>Backup e restauração</h1>
@stop

@section('content')
    <div class="modal fade" id="restaurarModal" tabindex="-1" role="dialog"
         aria-labelledby="restaurarModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="formRestaurar" class="form-horizontal"
                      action="{{ route('admin.configuracoes.backup.restaurar') }}"
                      method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <h4 class="modal-title" id="deleteModalTitle">Restaurar de arquivo</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputSectorName" class="col-sm-3 control-label">Arquivo</label>

                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="inputFile" name="json" accept=".json"/>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary pull-right">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @if(session()->has('message'))
        <div class="alert {{ session('saved') ? 'alert-success' : 'alert-error' }} alert-dismissible"
             role="alert">
            {{ session()->get('message') }}

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="box box-default">
        <div class="box-body">
            <div class="btn-group" style="display: inline-flex; margin: 0 0 10px 0">
                <a href="{{ route('admin.configuracoes.backup.download') }}" class="btn btn-success">Fazer backup</a>
                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#restaurarModal">Restaurar</a>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

    </script>
@endsection
