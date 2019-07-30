{{--
    TODO: mensagem => alunos de qual periodo (manha, noite, 4º ano)
--}}

@extends('adminlte::page')

@section('title', 'Mensagem - SGE CTI')

@section('content_header')
    <h1>Enviar mensagem</h1>
@stop

@section('content')
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
        <div class="box-header with-border">
            <h3 class="box-title">Destinotários</h3>
        </div>

        <div class="box-body">
            marcoslira05
        </div>
    </div>

    <div class="box box-default">
        <div class="box-body">
            <form action="#" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="subject" placeholder="Assunto">
                </div>
                <div>
                  <textarea id="message" class="textarea" placeholder="Mensagem"
                            style="resize:none; width: 100%; height: 250px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
            </form>
        </div>
        <div class="box-footer clearfix">
            <button type="button" class="pull-right btn btn-default" id="sendEmail">Enviar
                <i class="fa fa-arrow-circle-right"></i></button>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(() => {
            jQuery('#message').wysihtml5({
                locale: 'pt-BR'
            });
        });
    </script>
@endsection
