@extends('adminlte::page')

@section('title', 'Documentação de estágio - SGE CTI')

@section('css')
    <style type="text/css">
        #toggle {
            font-size: 12pt;
        }
    </style>
@endsection

@section('content_header')
    <div class="pull-right" style="display: none;">
        <div id="toggle">
            <i id="formatToggle" class="fa fa-toggle-on"></i> <span id="formatDesc">.docx</span>
        </div>
    </div>

    <h1>Documentação de estágio</h1>
@stop

@section('content')
    @include('modals.student.document.aditive')

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
                    <a href="{{ route('aluno.documento.manual') }}" class="small-box-footer"
                       target="_blank">Visualizar <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            @if($student->internship == null)

                <div class="col-sm-4">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>Protocolo de<br>estágio</h3>

                            <p>Protocolo para entregar na secretaria junto com os documentos</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-text-o"></i>
                        </div>
                        <a href="{{ route('aluno.documento.protocolo') }}" class="small-box-footer">
                            Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            @else

                <div class="col-sm-4">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>Protocolo do<br>relatório</h3>

                            <p>Protocolo para entregar na secretaria junto com os documentos</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-text-o"></i>
                        </div>
                        <a href="{{ route('aluno.documento.protocolo') }}" class="small-box-footer">
                            Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            @endif
        </div>
    </div>

    @if($student->internship == null)

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
                        <a href="{{ route('aluno.documento.plano') }}" class="small-box-footer">
                            Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                        <a href="{{ route('aluno.documento.ajuda.plano') }}" class="small-box-footer"
                           target="_blank">Ajuda <i class="fa fa-question-circle"></i></a>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>Termo de<br>compromisso</h3>

                            <p>Seu compromisso com as regras do estágio</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-paper-plane"></i>
                        </div>
                        <a href="{{ route('aluno.documento.termo') }}" class="small-box-footer">
                            Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                        <a href="{{ route('aluno.documento.ajuda.termo') }}" class="small-box-footer"
                           target="_blank">Ajuda <i class="fa fa-question-circle"></i></a>
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
                        <a href="{{ route('aluno.documento.convenio') }}" class="small-box-footer">
                            Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                        <a href="{{ route('aluno.documento.ajuda.convenio') }}" class="small-box-footer"
                           target="_blank">Ajuda <i class="fa fa-question-circle"></i></a>
                    </div>
                </div>
            </div>
        </div>

    @else

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

                                <p>Certificado que você acabou o estágio</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-flag-checkered"></i>
                            </div>
                            <a href="{{ route('aluno.documento.certificado') }}" class="small-box-footer">
                                Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                            <a href="{{ route('aluno.documento.ajuda.certificado') }}" class="small-box-footer"
                               target="_blank">Ajuda <i class="fa fa-question-circle"></i></a>
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
                            <a href="{{ route('aluno.documento.avaliacao') }}" class="small-box-footer">
                                Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                            <a href="{{ route('aluno.documento.ajuda.avaliacao') }}" class="small-box-footer"
                               target="_blank">Ajuda <i class="fa fa-question-circle"></i></a>
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
                            <a href="{{ route('aluno.documento.apresentacao') }}" class="small-box-footer">
                                Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                            <a href="{{ route('aluno.documento.ajuda.apresentacao') }}" class="small-box-footer"
                               target="_blank">Ajuda <i class="fa fa-question-circle"></i></a>
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
                            <a href="{{ route('aluno.documento.conteudo') }}" class="small-box-footer">
                                Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                            <a href="{{ route('aluno.documento.ajuda.conteudo') }}" class="small-box-footer"
                               target="_blank">Ajuda <i class="fa fa-question-circle"></i></a>
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
                            <a href="{{ route('aluno.documento.questionario') }}" class="small-box-footer">
                                Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                            <a href="{{ route('aluno.documento.ajuda.questionario') }}" class="small-box-footer"
                               target="_blank">Ajuda <i class="fa fa-question-circle"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

    @if(($student->internship != null) || (sizeof($student->finished_internships) == 0))

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Outros documentos</h3>
            </div>

            <div class="box-body">
                @if($student->internship != null)

                    <div class="col-sm-4">
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3>Relatório<br>bimestral</h3>

                                <p>Controle bimestral das atividades do estágio</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-calendar-minus-o"></i>
                            </div>
                            <a href="{{ route('aluno.documento.relatorio') }}" class="small-box-footer">
                                Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
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
                            <a href="#" class="small-box-footer" data-toggle="modal"
                               data-target="#documentAditive">Gerar <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                @elseif(sizeof($student->finished_internships) == 0)

                    <div class="col-sm-4">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>Situação<br>funcional</h3>

                                <p>Transformar CTPS em estágio</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-briefcase"></i>
                            </div>
                            <a href="{{ route('aluno.documento.situacao') }}" class="small-box-footer">
                                Gerar documento <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                @endif

            </div>
        </div>

    @endif
@endsection

@section('js')
    <script type="text/javascript">
        const allowedKeys = {
            37: 'left',
            38: 'up',
            39: 'right',
            40: 'down',
            65: 'a',
            66: 'b'
        };

        const konamiCode = ['up', 'up', 'down', 'down', 'left', 'right', 'left', 'right', 'b', 'a'];

        let konamiCodePosition = 0;

        // add keydown event listener
        document.addEventListener('keydown', e => {
            let key = allowedKeys[e.keyCode];
            let requiredKey = konamiCode[konamiCodePosition];

            if (key === requiredKey) {
                konamiCodePosition++;

                if (konamiCodePosition === konamiCode.length) {
                    activateCheats();
                    konamiCodePosition = 0;
                }
            } else {
                konamiCodePosition = 0;
            }
        });

        function activateCheats() {
            jQuery('#formatToggle').trigger('click');
        }

        jQuery(document).ready(function () {
            jQuery('#formatToggle').on('click', function (e) {
                jQuery.ajax({
                    url: `{{ route('api.aluno.documento.formato') }}`,
                    dataType: 'json',
                    type: 'GET',
                    success: data => {
                        if (data.format === 'docx') {
                            jQuery(this).removeClass('fa-toggle-off').addClass('fa-toggle-on');
                            jQuery('#formatDesc').text('.docx');
                        } else if (data.format === 'odt') {
                            jQuery(this).removeClass('fa-toggle-on').addClass('fa-toggle-off');
                            jQuery('#formatDesc').text('.odt');
                        }
                    },

                    error: function () {

                    }
                });
            });

            @if(session()->get('format') != 'docx')

            jQuery('#formatToggle').removeClass('fa-toggle-on').addClass('fa-toggle-off');
            jQuery('#formatDesc').text('.odt');

            @endif
        });
    </script>
@endsection
