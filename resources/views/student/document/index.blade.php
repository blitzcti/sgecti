@extends('adminlte::page')

@section('title', 'Documentação de estágio - SGE CTI')

@section('content_header')
    <h1>Documentação de estágio</h1>
@stop

@section('content')
    @include('modals.student.document.protocol')

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
            <h3 class="box-title">Sobre o estágio</h3>
        </div>

        <div class="box-body">
            <div class="col-sm-4">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>Manual do<br>estagiário</h3>

                        <p>As regras e instruções para fazer estágio</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-paperclip"></i>
                    </div>
                    <a href="{{ route('aluno.documento.manual') }}" class="small-box-footer">Visualizar <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>Protocolo de<br>estágio</h3>

                        <p>Protocolo para entregar na secretaria junto com os documentos</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file-text-o"></i>
                    </div>
                    <a href="#" class="small-box-footer"
                       data-toggle="modal" class="text-red"
                       data-target="#documentProtocol">Gerar <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Início de estágio</h3>
        </div>

        <div class="box-body">
            <div class="col-sm-4">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>Plano de<br>estágio</h3>

                        <p>O que você pretende fazer no estágio</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-paper-plane"></i>
                    </div>
                    <a href="#" class="small-box-footer">Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                    <a href="{{ route('aluno.documento.ajuda.plano') }}" class="small-box-footer">Ajuda <i class="fa fa-question-circle"></i></a>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>Termo de<br>compromisso</h3>

                        <p>Seu copromisso com as regras do estágio</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-paper-plane"></i>
                    </div>
                    <a href="#" class="small-box-footer">Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                    <a href="#" class="small-box-footer">Ajuda <i class="fa fa-question-circle"></i></a>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>Convênio<br>de estágio</h3>

                        <p>Caso seja o primeiro estágio da empresa com o colégio</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-paper-plane"></i>
                    </div>
                    <a href="#" class="small-box-footer">Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                    <a href="#" class="small-box-footer">Ajuda <i class="fa fa-question-circle"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Finalização de estágio</h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>Certificado<br>de estágio</h3>

                            <p>Certificaco que você acabou o estágio</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-flag-checkered"></i>
                        </div>
                        <a href="#" class="small-box-footer">Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                        <a href="#" class="small-box-footer">Ajuda <i class="fa fa-question-circle"></i></a>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>Avaliação<br>do estagiário</h3>

                            <p>Como você foi durante o estágio</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-flag-checkered"></i>
                        </div>
                        <a href="#" class="small-box-footer">Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                        <a href="#" class="small-box-footer">Ajuda <i class="fa fa-question-circle"></i></a>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>Apresentação</h3>

                            <p>Informações básicas do seu estágio</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-flag-checkered"></i>
                        </div>
                        <a href="#" class="small-box-footer">Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                        <a href="#" class="small-box-footer">Ajuda <i class="fa fa-question-circle"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>Conteúdo</h3>

                            <p>O que você fez no estágio</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-flag-checkered"></i>
                        </div>
                        <a href="#" class="small-box-footer">Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                        <a href="#" class="small-box-footer">Ajuda <i class="fa fa-question-circle"></i></a>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>Questionário</h3>

                            <p>Dê a sua opinião sobre o estágio</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-flag-checkered"></i>
                        </div>
                        <a href="#" class="small-box-footer">Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                        <a href="#" class="small-box-footer">Ajuda <i class="fa fa-question-circle"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Outros documentos</h3>
        </div>

        <div class="box-body">
            <div class="col-sm-4">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>Relatório<br>bimestral</h3>

                        <p>Controle bimestral das atividades do estágio</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-calendar-minus-o"></i>
                    </div>
                    <a href="#" class="small-box-footer">Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                    <a href="#" class="small-box-footer">Ajuda <i class="fa fa-question-circle"></i></a>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>Termo<br>aditivo</h3>

                        <p>As regras para fazer estágio</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-plus"></i>
                    </div>
                    <a href="#" class="small-box-footer">Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                    <a href="#" class="small-box-footer">Ajuda <i class="fa fa-question-circle"></i></a>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>Situação<br>funcional</h3>

                        <p>Transformar CTPS em estágio</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <a href="#" class="small-box-footer">Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                    <a href="#" class="small-box-footer">Ajuda <i class="fa fa-question-circle"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
