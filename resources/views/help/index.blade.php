@extends('adminlte::page')

@section('title', 'Ajuda - SGE CTI')]

@section('css')
    <link rel="stylesheet" href="{{ asset('css/help.css') }}">
@endsection

@section('content_header')
    <h1>Ajuda</h1>
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

            <?php
            $t1 = ['Configurações do sistema', 'Funcionalidades extras', 'Página inicial', 'Funcionalidades do sistema'];

            $t2 =
                [
                    [
                        ['Parâmetros do sistema',
                            '(TUTORIAL)',
                            '(VÍDEO)',
                        ],
                        ['Backup do sistema',
                            '(TUTORIAL)',
                            '(VÍDEO)',
                        ],
                    ],
                    [
                        ['Mensagem',
                            '(TUTORIAL)',
                            '(VÍDEO)',
                        ],
                        ['Logs',
                            '(TUTORIAL)',
                            '(VÍDEO)',
                        ],
                    ],
                    [
                        ['Notificações',
                            '(TUTORIAL)',
                            '(VÍDEO)',
                        ],
                    ],
                    [
                        ['Estágio',
                            '(TUTORIAL)',
                            '(VÍDEO)',
                        ],
                        ['Usuários',
                            '(TUTORIAL)',
                            '(VÍDEO)',
                        ],
                        ['Alunos',
                            '(TUTORIAL)',
                            '(VÍDEO)',
                        ],
                        ['Empresas',
                            '(TUTORIAL)',
                            '(VÍDEO)',
                        ],
                    ]
                ];

            ?>

            <?php
            for($n1 = 0; $n1 < sizeof($t1); $n1++)
            {
            $i1 = $n1 + 1;
            ?>

            <section class="accordion">
                <input type="checkbox" name="collapse" id="handle<?php echo $i1; ?>">
                <h2 class="handle">
                    <label for="handle<?php echo $i1; ?>"><b><?php echo $i1.'.'; ?></b> <?php echo $t1[$n1]; ?></label>
                </h2>
                <div class="hcontent">
                    <?php

                    for($n2 = 0; $n2 < sizeof($t2[$n1]); $n2++)
                    {
                    $i2 = $n2 + 1;
                    ?>

                    <section class="accordion">
                        <input type="checkbox" name="collapse" id="handle<?php echo $i1.'.'.$i2; ?>">
                        <h2 class="handle">
                            <label for="handle<?php echo $i1.'.'.$i2; ?>"><b><?php echo $i1.'.'.$i2.'.'; ?></b> <?php echo $t2[$n1][$n2][0]; ?></label>
                        </h2>
                        <div class="hcontent">
                            <div class="tabs">
                                <div id="tab<?php echo $i1.'.'.$i2; ?>.2" class="tab">
                                    <ul class="nav nav-tabs">
                                        <li><a href="#tab<?php echo $i1.'.'.$i2; ?>.1">Tutorial</a></li>
                                        <li class="active"><a href="#tab<?php echo $i1.'.'.$i2; ?>.2">Vídeo</a></li>
                                    </ul>

                                    <p>
                                        <?php echo $t2[$n1][$n2][2]; ?>
                                    </p>
                                </div>


                                <div id="tab<?php echo $i1.'.'.$i2; ?>.1" class="tab">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab<?php echo $i1.'.'.$i2; ?>.1">Tutorial</a></li>
                                        <li><a href="#tab<?php echo $i1.'.'.$i2; ?>.2">Vídeo</a></li>
                                    </ul>

                                    <p>
                                        <?php echo $t2[$n1][$n2][1]; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <?php
                    }
                    ?>
                </div>
            </section>

            <?php
            }
            ?>

        </div>
    </div>
@endsection

@section('js')
    <!--
    <script src="https://kit.fontawesome.com/085f790a05.js"></script>
    !-->



@endsection
