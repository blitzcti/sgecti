<?php

namespace App\Http\Controllers;

use App\Auth;

class HelpController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $content = [];

        if ($user->isAdmin()) {

            $content = [
                'Configurações do sistema' => [
                    'Alterar senha' => [
                        'desc' => "Utilize essa interface para alterar sua senha.",
                        'content' => [
                            [
                                'img' => 'administrador/alterar_senha_admin.png',
                                'text' => '',
                            ],
                        ]
                    ],

                    'Parâmetros do sistema' => [
                        'desc' => 'Informações e dados sobre o local e a instituição atual.',
                        'content' => [
                            [
                                'img' => 'administrador/parametros_admin.png',
                                'text' => '',
                            ],
                        ],
                    ],

                    'Backup do sistema' => [
                        'desc' => 'Salvamento de arquivos que pode ser programado para que ocorra automaticamente e restaurar arquivos antigos.',
                        'content' => [
                            [
                                'img' => 'administrador/backup_admin.png',
                                'text' => '',
                            ],

                        ],

                    ],

                    'Configurações gerais do curso' => [
                        'desc' => 'A interface disponibiliza os dados que todos os cursos possuem em comum.',
                        'content' => [
                            [
                                'img' => 'administrador/conf_gerais_admin.png',
                                'text' => '',
                            ],

                        ],
                    ],

                    'Logs' => [
                        'desc' => 'Essa interface possui uma tabela com todas as alterações feitas no sistema.',
                        'content' => [
                             [
                                'img' => 'administrador/log_admin.png',
                                'text' => '',
                             ],

                        ],
                    ]

                ],



                'Padronização de tabelas' => [
                    'CSV' => [
                        'desc' => 'Essa opção permite que você faça o download da respectiva tabela.',
                        'content' => [
                            [
                                'img' => 'administrador/csv_admin.png',
                                'text' => '',
                            ],
                        ]
                    ],

                    'Imprimir' => [
                        'desc' => 'Essa opção permite que você faça a impressão da respectiva tabela.',
                        'content' => [
                            [
                                'img' => 'administrador/imprimir_admin.png',
                                'text' => '',
                            ],
                        ]
                    ],

                    'Pesquisar' => [
                        'desc' => 'Essa opção permite que você pesquise a informação que deseja na tabela.',
                        'content' => [
                            [
                                'img' => 'administrador/pesquisa_admin.png',
                                'text' => '',
                            ],
                        ]
                    ],

                    'Anterior/Próximo' => [
                        'desc' => 'Essa opção permite que você navegue pelas páginas da tabela.',
                        'content' => [
                            [
                                'img' => 'administrador/ant_prox_admin.png',
                                'text' => '',
                            ],
                        ]
                    ],
                ],

                'Página inicial' => [
                    'Notificações' => [
                        'desc' => 'Nesse local apareceram as novas notificações do administrador.',
                        'content' => [
                            [
                                'img' => 'administrador/notificacoes_admin.png',
                                'text' => '',
                            ],
                        ]
                    ],

                    'Informações do servidor' => [
                        'desc' => 'Na página inicial, você tem informações sobre o armazenamento, memória e processamento do servidor.,',
                        'content' => [
                            [
                                'img' => 'administrador/pagina_inicial.png',
                                'text' => '',
                            ],
                        ]
                    ],
                ],

                'Funcionalidades do sistema' => [

                    'Mensagem' => [
                        'desc' => 'Utilize essa interface para enviar um email para certo público do Colégio.',
                        'content' => [
                            '' => [
                                [
                                    'img' => 'administrador/mensagem_admin.png',
                                    'text' => '',
                                ],
                            ],
                        ],
                    ],

                    'Usuários' => [
                        'desc' => "Visualize e adicione usuários no sistema.",
                        'content' => [
                            'Visualizar usuários' => [
                                [
                                    'img' => 'administrador/visualizar_usuario_admin.png',
                                    'text' => '',
                                ],
                            ],

                            'Adicionar usuário' => [
                                [
                                    'img' => 'administrador/add_usuario_admin.png',
                                    'text' => '',
                                ],
                            ],
                        ],
                    ],
                        'Cursos' => [
                            'desc' => "Visualize e adicione cursos no sistema.",
                            'content' => [
                                'Visualizar cursos' => [
                                    [
                                        'img' => 'administrador/visualizar_curso_admin.png',
                                        'text' => '',
                                    ],
                                ],

                                'Adicionar curso' => [
                                    [
                                        'img' => 'administrador/add_curso_admin.png',
                                        'text' => '',
                                    ],
                                ],
                            ],
                        ],
                        'Coordenadores' => [
                            'desc' => "Visualize e adicione coordenadores no sistema.",
                            'content' => [
                                'Visualizar coordenadores' => [
                                    [
                                        'img' => 'administrador/visualizar_coordenador_admin.png',
                                        'text' => '',
                                    ],
                                ],

                                'Adicionar coordenador' => [
                                    [
                                        'img' => 'administrador/add_coordenador_admin.png',
                                        'text' => '',
                                    ],
                                ],
                            ],
                        ],

                ]
            ];



        } else if ($user->isCoordinator()) {

            $content = [
                'Configurações do sistema' => [
                    'Alterar senha' => [
                        'desc' => 'Nesses campos, você altera a senha.',
                        'content' => [
                            [
                                'img' => 'coordenador/alterar_senha_coordenadores.png',
                                'text' => '',
                            ],

                        ]

                    ]
                ],

                'Padronização de tabelas' => [
                    'CSV' => [
                        'desc' => 'Essa opção permite que você faça o download da respectiva tabela.',
                        'content' => [
                            [
                                'img' => 'coordenador/csv_coordenadores.png',
                                'text' => '',
                            ],
                        ]
                    ],

                    'Imprimir' => [
                        'desc' => 'Essa opção permite que você faça a impressão da respectiva tabela.',
                        'content' => [
                            [
                                'img' => 'coordenador/imprimir_coordenadores.png',
                                'text' => '',
                            ],
                        ]
                    ],

                    'Pesquisar' => [
                        'desc' => 'Essa opção permite que você pesquise a informação que deseja na tabela.',
                        'content' => [
                            [
                                'img' => 'coordenador/pesquisa_coordenadores.png',
                                'text' => '',
                            ],
                        ]
                    ],

                    'Anterior/Próximo' => [
                        'desc' => 'Essa opção permite que você navegue pelas páginas da tabela.',
                        'content' => [
                            [
                                'img' => 'coordenador/ant_prox_coordenadores.png',
                                'text' => '',
                            ],
                        ]
                    ],
                ],
                    'Página inicial' => [
                        'Notificações' => [
                            'desc' => 'Nesse local apareceram as novas notificações do coordenador.',
                            'content' => [
                                [
                                    'img' => 'coordenador/notificacao_coordenadores.png',
                                    'text' => '',
                                ],
                            ]
                        ],

                        'Informações do coordenador' => [
                            'desc' => 'Nesse local apareceram as informações do coordenador, e informações sobre os estágios dos alunos.',
                            'content' => [
                                [
                                    'img' => 'coordenador/pagina_inicial_coordenadores.png',
                                    'text' => '',
                                ],
                            ]
                        ],
                    ],

                'Funcionalidades do sistema' => [

                    'Mensagem' => [
                        'desc' => 'Essa interface possibilita o envio de email a um público específico do Colégio.',
                        'content' => [
                                [
                                    'img' => 'coordenador/mensagem_coordenadores.png',
                                    'text' => '',
                                ],

                            ],
                    ],

                    'Empresas' => [
                        'desc' => 'Visualize e adicione empresas no sistema.',
                        'content' => [
                            'Visualizar empresa' => [
                                [
                                    'img' => 'coordenador/visualizar_empresa_coordenadores.png',
                                    'text' => '',
                                ],
                            ],

                            'Adicionar empresa' => [
                                [
                                    'img' => 'coordenador/add_empresa_coordenadores.png',
                                    'text' => '',
                                ],
                            ],

                            'Setores' => [
                                [
                                    'img' => 'coordenador/visualizar_setor_coordenadores.png',
                                    'text' => 'Visualize os setores existentes nas empresas.',
                                ],
                                [
                                    'img' => 'coordenador/add_setor_coordenadores.png',
                                    'text' => 'Adicione um setor.',
                                ],

                            ],

                            'Supervisores' => [
                                [
                                    'img' => 'coordenador/visualizar_supervisor_coordenadores.png',
                                    'text' => 'Visualize os supervisores das empresas.',
                                ],
                                [
                                    'img' => 'coordenador/add_supervisor_coordenadores.png',
                                    'text' => 'Adicione um supervisor.',
                                ],

                            ],

                            'Convênios' => [
                                [
                                    'img' => 'coordenador/visualizar_convenios_ccoordenadores.png',
                                    'text' => 'Visualize os convênios com o Colégio.',
                                ],
                                [
                                    'img' => 'coordenador/add_convenios_coordenadores.png',
                                    'text' => 'Adicione um convênio.',
                                ],

                            ],
                        ],
                    ],

            'Estágios' => [
                'desc' => 'Visualize e adicione os estágios dos alunos.',
                'content' => [
                    'Visualizar estágio' => [
                        [
                            'img' => 'coordenador/visualizar_estagio_coordenadores.png',
                            'text' => '',
                        ],

                    ],

                    'Adicionar estágio' => [
                        [
                            'img' => 'coordenador/add_estagio_coordenadores.png',
                            'text' => '',
                        ],

                    ],

                    'Termos Aditivos' => [
                        [
                            'img' => 'coordenador/visualizar_termoadd_coordenadores.png',
                            'text' => 'Visualize os termos aditivos dos estágios.',
                        ],

                        [
                            'img' => 'coordenador/add_termoadd_coordenadores.png',
                            'text' => 'Adicione termos aditivos aos estágios.',
                        ],

                    ],
                ]
            ],

                'Trabalhos' => [
                'desc' => 'Visualize e adicione os trabalhos dos alunos.',
                'content' => [
                    'Visualizar coordenadores' => [
                        [
                            'img' => 'coordenador/visualizar_trabalho_coordenadores.png',
                            'text' => '',
                        ],

                    ],

                    'Novo coordenador' => [
                        [
                            'img' => 'coordenador/add_trabalho_coordenadores.png',
                            'text' => '',
                        ],

                    ],

                    'Empresas' => [
                        [
                            'img' => 'coordenador/visualizar_empresatrab_coordenadores.png',
                            'text' => 'Visualize as empresas dos trabalhos existentes.',
                        ],

                        [
                            'img' => 'coordenador/add_empresatrab_coordenadores.png',
                            'text' => 'Adicione empresas para os futuros trabalhos.',
                        ],

                    ],
                ]
            ],
                    'Relatórios' => [
                        'desc' => 'Visualize e adicione os relatórios bimestrais e finais.',
                        'content' => [
                            'Visualizar relatórios' => [
                                [
                                    'img' => 'coordenador/visualizar_relatorio_coordenadores.png',
                                    'text' => '',
                                ],

                            ],

                            'Relatórios bimestrais' => [
                                [
                                    'img' => 'coordenador/add_bimestral_coordenadores.png',
                                    'text' => 'Adicione um relatório bimestral.',
                                ],

                            ],

                            'Relatórios finais' => [
                                [
                                    'img' => 'coordenador/add_final_coordenadores.png',
                                    'text' => 'Adicione um relatório final.',
                                ],

                            ],
                        ]
                    ],

                    'Propostas' => [
                        'desc' => 'Visualize e adicione as propostas de estágio.',
                        'content' => [
                            'Visualizar propostas' => [
                                [
                                    'img' => 'coordenador/visualizar_propostas_coordenadores.png',
                                    'text' => '',
                                ],

                            ],

                            'Adicionar proposta' => [
                                [
                                    'img' => 'coordenador/add_proposta_coordenadores.png',
                                    'text' => '',
                                ],

                            ],
                        ]
                    ],

                    'Alunos' => [
                        'desc' => 'Visualize e obtenha o PDF dos alunos.',
                        'content' => [
                            'Visualizar dados dos alunos' => [
                                [
                                    'img' => 'coordenador/dados_alunos.png',
                                    'text' => '',
                                ],

                            ],

                            'Obter PDF dos alunos' => [
                                [
                                    'img' => 'coordenador/relacao_alunos.png',
                                    'text' => 'Nessa interface, você filtra as informações dos alunos para obter o PDF somente dos desejados.',
                                ],

                            ],
                        ]
                    ],
          ]
            ];


        } else if ($user->isCompany()) {

            $content = [
                'Configurações do sistema' => [
                    'Alterar senha' => [
                        'desc' => "Utilize essa interface para alterar sua senha.",
                        'content' => [
                            [
                                'img' => 'empresa/alterar_senha_empresa.png',
                                'text' => '',
                            ],
                        ]
                    ],

                ],

                'Padronização de tabelas' => [
                    'CSV' => [
                        'desc' => "Todas as tabelas possuem essa opção, e sua utilidade é baixar as informações existentes nela.",
                        'content' => [
                            [
                                'img' => 'empresa/csv_empresa.png',
                                'text' => '',
                            ],

                        ]
                    ],

                    'Imprimir' => [
                        'desc' => "Todas as tabelas possuem essa opção, e sua utilidade é imprimir as informações existentes nela.",
                        'content' => [
                            [
                                'img' => 'empresa/imprimir_empresa.png',
                                'text' => '',
                            ],
                        ]
                    ],

                    'Pesquisar' => [
                        'desc' => "Todas as tabelas possuem essa opção, e sua utilidade é pesquisar a informação que você deseja na tabela.",
                        'content' => [
                            [
                                'img' => 'empresa/pesquisa_empresa.png',
                                'text' => '',
                            ],
                        ]
                    ],

                    'Anterior/Próximo' => [
                        'desc' => "Todas as tabelas possuem essa opção, e sua utilidade é navegar pelas páginas da tabela.",
                        'content' => [
                            [
                                'img' => 'empresa/ant_prox_empresa.png',
                                'text' => '',
                            ],
                        ]
                    ],
                ],

                'Página inicial' => [
                    'Notificações' => [
                        'desc' => 'Nesse local apareceram as novas notificações e alertas sobre as propostas de estágio solicitadas, se foram aceitas ou não pelo coordenador.',
                        'content' => [
                            [
                                'img' => 'empresa/notificacao_empresa.png',
                                'text' => 'Escreve aqui Tevinho',
                            ],
                        ]
                    ],

                    'Propostas' => [
                        'desc' => 'Na página inicial, há o número de propostas feitas pela empresa, e quantas foram aprovadas.',
                        'content' => [
                            [
                                'img' => 'empresa/inicio_empresa.png',
                                'text' => 'Escreve aqui Tevinho',
                            ],
                        ]
                    ],
                ],

                'Funcionalidades do sistema' => [

                    'Propostas' => [
                        'desc' => 'Visualize e adicione as propostas fornecidas ao Colégio.',
                        'content' => [
                            'Visualizar Proposta' => [

                                [
                                    'img' => 'empresa/visualizar_propostas_empresa.png',
                                    'text' => 'A tabela mostra quais as propostas que a sua sempresa já forneceu ao Colégio.',
                                ],
                            ],

                            'Adicionar Proposta' => [
                                [
                                    'text' => '',
                                    'img' => 'empresa/adicionar_proposta_empresa.png',

                                ],
                                [
                                    'img' => 'empresa/adicionar_proposta_empresa2.png',
                                    'text' => '',
                                ],

                            ],
                        ]
                    ],

                ]

            ];


        } else if ($user->isStudent()) {

            $content = [
                'Configurações do sistema' => [
                    'Alterar senha' => [
                        'desc' => 'Utilize essa interface para alterar sua senha.',
                        'content' => [
                            [
                                'img' => 'aluno/alterar_senha_aluno.png',
                                'text' => '',
                            ],
                        ]
                    ],
                ],

                'Página inicial' => [
                    'Notificações' => [
                        'desc' => 'Nesse local apareceram as novas notificações e alertas sobre sua documentação ou propostas de estágio.',
                        'content' => [
                            [
                                'img' => 'aluno/notificacao_aluno.png',
                                'text' => '',
                            ],
                        ]
                    ],

                    'Propostas' => [
                        'desc' => 'Atualizações sobre oportunidades oferecidas por empresas e instituições.',
                        'content' => [
                            [
                                'img' => 'aluno/inicio_aluno.png',
                                'text' => '',
                            ],
                        ]
                    ],
                ],

                'Funcionalidades do sistema' => [

                    'Propostas' => [
                        'desc' => 'Utilize essa interface para visualizar todas as propostas de estágio disponíveis.',
                        'content' => [
                            '' => [
                                [
                                    'img' => 'aluno/propostas_aluno.png',
                                    'text' => '',
                                ],
                            ],
                        ],
                    ],

                    'Documentação de estágio' => [
                        'desc' => "Nesta interface, é possível visualizar todos os documentos necessários no início, no processo e no término do estágio.",
                        'content' => [
                            '' => [
                                [
                                    'img' => 'aluno/documentacao_aluno.png',
                                    'text' => '',
                                ],
                                [
                                    'img' => 'aluno/documentacao_aluno1.png',
                                    'text' => '',
                                ],
                                [
                                    'img' => 'aluno/documentacao_aluno2.png',
                                    'text' => '',
                                ],
                            ],
                        ],
                    ]
                ]
            ];


        }

        return view('help.index')->with(['content' => $content]);
    }
}
