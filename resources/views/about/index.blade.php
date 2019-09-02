@extends('adminlte::page')

@section('title', 'Sobre - SGE CTI')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endsection

@section('content_header')
    <h1>Sobre</h1>
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
        <div class="box-body">
            <div class="dg dg1">
                <div class="img">
                    <img src="{{ asset('img/about/sobre_blitz.jpg') }}" alt="">
                </div>
                <div class="txt">
                    <h2>Sobre a equipe</h2>
                    <p>
                        A Blitz foi formada como equipe para o Trabalho de Conclusão de Curso de Informática com o objetivo de desenvolver alguma aplicação voltada ao ambiente escolar. Encontramos no gerenciamento de estágios a oportunidade de contribuir com o futuro do CTI e de toda a comunidade estudantil que passa por aqui.
                        <br><br>
                        <b>Líder:</b> André Creppe<br><b>Vice-líder:</b> Estevão Rolim
                        <br><br>
                        <small>Da esquerda para a direita:
                            <br>Estevão (cima), Igor (baixo), Sofia, André, Gustavo, Marcos, Carolina, Lucas (cima), Dhiego (baixo)</small>
                    </p>
                </div>
            </div>
            <br>
            <div class="dg dg2">
                <div class="txt">
                    <h2>Sobre o CTI</h2>
                    <p>O sistema desenvolvido pela equipe conta com uma estrutura de banco de dados sofisticada, através da qual serão armazenados os dados dos estagiários, das empresas e dos coordenadores dos cursos técnicos. Com foco na praticidade, o sistema desenvolvido pela Blitz tem o objetivo de se adaptar às demandas diárias das coordenadorias, se encaixando na rotina ativa do Colégio e auxiliando toda a comunidade estudantil a gerenciar todos os aspectos dos estágios profissionais, desde as propostas e convênios de empresas até o registro de relatórios finais de atividades.</p>
                </div>
                <div class="img">
                    <img src="{{ asset('img/about/sobre_cti.jpg') }}" alt="">
                </div>
            </div>
            <br>
            <div class="dg dg1">
                <div class="img">
                    <div class="video">
                        <iframe width="auto" height="auto" src="https://www.youtube.com/embed/GeKRFQlPYYY?controls=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="txt">
                    <h2>Filme Comercial</h2>
                    <p>
                       O vídeo comercial da blitz foi feito para ajudar nossos usuários a entender o motivo pelo qual o sistema foi criado e qual sua principal funcionabilidade. Prezando simplificar e facilitar o trabalho de todos os usuários.

                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
