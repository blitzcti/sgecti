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
                        'desc' => null,
                        'content' => [
                            [
                                'img' => 'alterar_senha/altera_senha_barra.png',
                                'text' => 'Nesses campos, você altera a senha.',
                            ],
                            [
                                'img' => 'alterar_senha/altera_senha_cancelar.png',
                                'text' => 'Clicando aqui, você tem a possibilidade de cancelar a alteração de senha.',
                            ],
                            [
                                'img' => 'alterar_senha/altera_senha_salvar.png',
                                'text' => 'Clicando aqui, você tem a possibilidade de salvar a nova senha.',
                            ],
                        ]
                    ],

                    'Parâmetros do sistema' => [
                        'desc' => 'Dados e informações sobre a Instituição, com funções de download de planilhas e impressão.',
                        'content' => [
                            [
                                'img' => 'parametros_sist/conf_parametros_adicionar.png',
                                'text' => 'A opção “Adicionar parâmetros” permite que você cadastre uma nova instituição no sistema.',
                            ],
                            [
                                'img' => 'parametros_sist/new_parametros_dados.png',
                                'text' => 'Para realizar o cadastro, utilize os campos em “Dados do parâmetro” para adicionar informações sobre a nova instituição.',
                            ],
                            [
                                'img' => 'parametros_sist/new_parametros_adicionar.png',
                                'text' => 'Após preencher, clique em “Adicionar” para salvar a nova instituição no banco de dados.',
                            ],
                            [
                                'img' => 'parametros_sist/conf_parametros_CSV.png',
                                'text' => 'Clicando na opção “CSV”, você pode realizar o download da planilha, que poderá ser visualizada e manipulada utilizando softwares como o libre office calc ou excel.',
                            ],
                            [
                                'img' => 'parametros_sist/conf_parametros_imprimir.png',
                                'text' => 'Clicando na opção “Imprimir” você pode imprimir a planilha de parâmetros do sistema.',
                            ],
                            [
                                'img' => 'parametros_sist/conf_parametros_barra.png',
                                'text' => 'Nessa tabela, você visualiza os parâmetros já cadastrados no banco de dados.',
                            ],
                            [
                                'img' => 'parametros_sist/conf_parametros_antProx.png',
                                'text' => 'Os botões “Anterior” e “Próxima” permitem trocar as páginas quando determinado número de registros for atingido.',
                            ],
                            [
                                'img' => 'parametros_sist/conf_parametros_pesquisar.png',
                                'text' => 'Para explorar os registros, você pode utilizar a barra de pesquisa ou a navegação por páginas.',
                            ],
                        ],
                    ],

                    'Backup do sistema' => [
                        'desc' => 'Salvamento de arquivos que pode ser programado para que ocorra automaticamente e restaurar arquivos antigos .JSON.',
                        'content' => [
                            [
                                'img' => 'backup/conf_backup_fazerBackup.png',
                                'text' => 'Ao clicar em “Fazer backup”, o usuário tem a possibilidade de baixar o conteúdo do banco de dados em formato JSON.',
                            ],
                            [
                                'img' => 'backup/agendar_backup.png',
                                'text' => 'Na opção “Agendar Backup”, o usuário tem a possibilidade de escolher os dias da semana e horário em que o salvamento de dados será feito.',
                            ],
                            [
                                'img' => 'backup/conf_backup_salvar.png',
                                'text' => 'Em “Salvar”, a operação é concluída.',
                            ],
                            [
                                'img' => 'backup/conf_backup_restaurar.png',
                                'text' => 'Em “Restaurar”, o usuário poderá restaurar a estrutura de dados para um backup anterior já salvo.',
                            ],
                            [
                                'img' => 'backup/restaurar_backup.png',
                                'text' => 'A opção “Escolher arquivo” permite que um arquivo de backup seja carregado diretamente da pasta de arquivos.',
                            ],
                            [
                                'img' => 'backup/restaurar_backup_restaurar.png',
                                'text' => 'O botão “Restaurar” completa a operação.',
                            ],
                        ],

                    ],

                    'Configurações gerais do curso' => [
                        'desc' => null,
                        'content' => [
                            [
                                'img' => 'configurações_curso/conf_gerais_barra.png',
                                'text' => 'Essa tabela disponibiliza dados que todos os cursos possuem em comum.',
                            ],
                            [
                                'img' => 'configurações_curso/conf_gerais_antProx.png',
                                'text' => 'Os botões “Anterior” e “Próxima” permitem trocar as páginas quando determinado número de registros for atingido.',
                            ],
                            [
                                'img' => 'configurações_curso/conf_gerais_CSV.png',
                                'text' => 'Neste campo destacado, o usuário poderá fazer o download de uma planilha que contém informações em comum à todos os cursos.',
                            ],
                            [
                                'img' => 'configurações_curso/conf_gerais_imprimir.png',
                                'text' => 'Neste campo destacado, o usuário poderá imprimir a planilha que contém informações em comum à todos os cursos.',
                            ],
                            [
                                'img' => 'configurações_curso/conf_gerais_pesquisar.png',
                                'text' => 'Na opção “Pesquisar” você pode pesquisar alguma informação específica.',
                            ],
                        ],
                    ]
                ],

                'Funcionalidades extras' => [
                    'Mensagem' => [
                        'desc' => null,
                        'content' => [
                            [
                                'img' => 'mensagem/mensagem_visualizar.png',
                                'text' => '    Ao clicar nesse botão você visualizará os alunos que se encaixam nos filtros pré selecionados. ',
                            ],
                            [
                                'img' => 'mensagem/mensagem_enviar.png',
                                'text' => '  Ao clicar nesse botão você enviará a mensagem aos alunos selecionados.  ',
                            ],
                            [
                                'img' => 'mensagem/mensagem_tipos.png',
                                'text' => ' Nesse campo você poderá utilizar esses parametros para editar o texto da sua mensagem.    ',
                            ],
                            [
                                'img' => 'mensagem/mensagem_alunos.png',
                                'text' => '   Nesse campo você poderá escolher um aluno especifico. ',
                            ],
                        ]
                    ],

                    'Logs' => [
                        'desc' => null,
                        'content' => [
                            [
                                'img' => 'logs/logs_barra.png',
                                'text' => 'Essa tabela disponibiliza o monitoramento de todas as funções desempenhadas no sistema, que serão registradas no banco de dados por segurança e chance de recuperação de dados excluídos por engano.',
                            ],
                            [
                                'img' => 'logs/logs_baixar.png',
                                'text' => '    Na opção “Baixar Log” você consegue baixar toda a planilha de logs.',
                            ],
                            [
                                'img' => 'logs/logs_limpar.png',
                                'text' => '    Na opção “Limpar Log” você limpa toda a tabela de logs, porém os dados continuam no servidor.',
                            ],
                            [
                                'img' => 'logs/logs_excluir.png',
                                'text' => '    Na opção “Excluir Log” você limpa toda a tabela de logs, e também exclui os dados do servidor.',
                            ],
                            [
                                'img' => 'logs/logs_pesquisar.png',
                                'text' => '    Na opção “Pesquisar” você pode pesquisar algum log em específico.',
                            ],
                        ]
                    ],
                ],

                'Página inicial' => [
                    'Notificações' => [
                        'desc' => null,
                        'content' => [
                            [
                                'img' => 'configurações_curso/notificações.png',
                                'text' => 'Nesse espaço aparecerão ao usuário notificações relativas a mensagens de coordenadores, vagas de estágio, novidades e informações.',
                            ],
                        ]
                    ],
                ],

                'Funcionalidades do sistema' => [
                    'Estágio' => [
                        null
                    ],

                    'Cursos' => [
                        'desc' => null,
                        'content' => [
                            'Visualizar cursos' => [
                                [
                                    'img' => 'cursos/cursos.png',
                                    'text' => 'Nessa página o usuário terá a possibilidade de observar os detalhes, fazer edições, adicionar coordenadores e encaminha para a página de configurações do curso selecionado.',
                                ],
                                [
                                    'img' => 'cursos/cursos_anteProx.png',
                                    'text' => 'Os botões “Anterior” e “Próxima” permitem trocar as páginas quando determinado número de registros for atingido.',
                                ],
                                [
                                    'img' => 'cursos/down_curso.png',
                                    'text' => 'Neste campo destacado, o usuário poderá fazer o download de uma planilha que contém os nome de todos os coordenadores,informando os cursos correspondentes, assim como a data do seu ingresso na coordenadoria e do seu egresso.',
                                ],
                                [
                                    'img' => 'cursos/imprimi_curso.png',
                                    'text' => 'Através deste campo destacado, o usuário poderá imprimir e até mesmo criar um arquivo PDF em formato de planilha, assim como salvar no Google Drive tais informações.',
                                ],
                                [
                                    'img' => 'cursos/pesquisar_curso.png',
                                    'text' => 'Na barra pesquisa, o usuário poderá pesquisar o curso que deseja encontrar, podendo colocar o nome inteiro ou parcialmente.',
                                ],
                            ],

                            'Novo curso' => [
                                [
                                    'img' => 'cursos/add_curso.png',
                                    'text' => 'Neste campo, há a possibilidade de adicionar um novo curso à tabela.',
                                ],
                                [
                                    'img' => 'cursos/curso_new_barra.png',
                                    'text' => 'Nesse campo o usuário poderá adicionar as informações básicas do curso.',
                                ],
                                [
                                    'img' => 'cursos/curso_new_cancelar.png',
                                    'text' => 'Este campo trará a possibilidade do usuário cancelar a ação ”adicionar novo curso”, caso tenha ocorrido algum contratempo.',
                                ],
                                [
                                    'img' => 'cursos/curso_new_add.png',
                                    'text' => 'Este campo é a confirmação do ato “Adicionar novo Curso”, na qual salvará os dados no Banco.',
                                ],
                            ],
                        ]
                    ],

                    'Usuários' => [
                        'desc' => null,
                        'content' => [
                            'Visualizar usuário' => [
                                [
                                    'img' => 'usuarios/user_view_barra.png',
                                    'text' => 'Nesta tabela, é possível visualizar  o id dos usuários, nome, email, cargo e também há a possibilidade de editar as informações.',
                                ],
                                [
                                    'img' => 'usuarios/user_view_antProx.png',
                                    'text' => 'Os botões “Anterior” e “Próxima” permitem trocar as páginas quando determinado número de registros for atingido.',
                                ],
                                [
                                    'img' => 'usuarios/user_view_CSV.png',
                                    'text' => 'Nesta opção, o usuário tem a opção de baixar a planilha de usuários.',
                                ],
                                [
                                    'img' => 'usuarios/user_view_imprimir.png',
                                    'text' => 'Nesta área é possível imprimir as informações apresentadas na tabela de usuários.',
                                ],
                                [
                                    'img' => 'usuarios/user_view_pesquisar.png',
                                    'text' => 'A área de pesquisa permite pesquisar informações sobre usuários.',
                                ],
                            ],

                            'Novo usuário' => [
                                [
                                    'img' => 'usuarios/user_view_add.png',
                                    'text' => 'Neste campo, há a possibilidade de adicionar um novo usuário à tabela.',
                                ],
                                [
                                    'img' => 'usuarios/user_new_barra.png',
                                    'text' => 'Neste campo, Você insere os dados relativos ao novo usuário que será cadastrado.',
                                ],
                                [
                                    'img' => 'usuarios/user_new_cancelar.png',
                                    'text' => 'Este campo trará a possibilidade do usuário cancelar o cadastro do novo usuário, caso tenha ocorrido algum contratempo.',
                                ],
                                [
                                    'img' => 'usuarios/user_new_add.png',
                                    'text' => 'Este campo permite que seja efetuado o cadastro de usuário.',
                                ],
                            ]
                        ]
                    ],

                    'Coordenadores' => [
                        'desc' => null,
                        'content' => [
                            'Visualizar coordenadores' => [
                                [
                                    'img' => 'coordenadores/coord_view_barra.png',
                                    'text' => 'Neste campo será possível observar os coordenadores que foram adicionados . Caso não haja nenhum coordenador cadastrado, apresentará a mensagem “Nenhum registro encontrado”.',
                                ],
                                [
                                    'img' => 'coordenadores/coord_view_antProx.png',
                                    'text' => 'Através destes campos destacados, o usuário poderá navegar pelas páginas anteriores dos coordenadores cadastrados e até mesmo ver as próximas.',
                                ],
                                [
                                    'img' => 'coordenadores/coord_view_CSV.png',
                                    'text' => 'Neste campo destacado, o usuário poderá fazer o download de uma planilha que contém os nome de todos os coordenadores,informando os cursos correspondentes, assim como a data do seu ingresso na coordenadoria e do seu egresso.',
                                ],
                                [
                                    'img' => 'coordenadores/coord_view_imprimir.png',
                                    'text' => 'Através deste campo destacado, o usuário poderá imprimir e até mesmo criar um arquivo PDF em formato de planilha, assim como salvar no Google Drive tais informações.',
                                ],
                                [
                                    'img' => 'coordenadores/coord_view_pesquisar.png',
                                    'text' => 'Neste campo o usuário poderá realizar uma pesquisa por nome, a fim de encontrar o coordenador desejado com maior facilidade e agilidade.',
                                ],
                            ],

                            'Novo coordenador' => [
                                [
                                    'img' => 'coordenadores/coord_new_barra.png',
                                    'text' => 'Neste campo será possível adicionar um novo coordenador, visto que pode haver troca de profissionais e até mesmo criação de novos curso no colégio.',
                                ],
                                [
                                    'img' => 'coordenadores/coord_new_cancelar.png',
                                    'text' => 'Este campo trará a possibilidade do usuário cancelar a ação “adicionar novo Coordenador”, caso tenha ocorrido algum contratempo.',
                                ],
                                [
                                    'img' => 'coordenadores/coord_new_adicionar.png',
                                    'text' => 'Este campo é a confirmação do ato “Adicionar novo Coordenador”, na qual salvará os dados no Banco.',
                                ],
                            ],
                        ]
                    ],

                    'Alunos' => [
                        null
                    ],

                    'Empresas' => [
                        'desc' => null,
                        'content' => [
                            'Visualizar empresa' => [
                                [
                                    'img' => 'empresas/view/dados_new_empresa.png',
                                    'text' => 'Nesta área é possível visualizar os dados das empresas associadas em formato de tabela.',
                                ],
                                [
                                    'img' => 'empresas/view/empresa_new_anteProx.png',
                                    'text' => 'Através destes campos destacados, o usuário poderá navegar pelas páginas anteriores das empresas cadastradas e até mesmo ver as próximas.',
                                ],
                                [
                                    'img' => 'empresas/view/down_new_empresa.png',
                                    'text' => 'Neste campo destacado, o usuário poderá fazer o download de uma planilha que contém os nome de todas as empresas,informando dados específicos das empresas, assim como a CNPJ, responsável e telefones.',
                                ],
                                [
                                    'img' => 'empresas/view/impri_new_empresa.png',
                                    'text' => 'Através deste campo destacado, o usuário poderá imprimir e até mesmo criar um arquivo PDF em formato de planilha, assim como salvar no Google Drive tais informações.',
                                ],
                                [
                                    'img' => 'empresas/view/pesq_new_empresa.png',
                                    'text' => 'Na barra pesquisa, o usuário poderá pesquisar as empresas que deseja encontrar, podendo colocar o nome inteiro ou parcialmente.',
                                ],
                            ],

                            'Nova empresa' => [
                                [
                                    'img' => 'empresas/new/add_new_empresa.png',
                                    'text' => 'Em “Adicionar empresa” você pode fazer um novo registro de empresas.',
                                ],
                                [
                                    'img' => 'empresas/new/dados_da_nova_empresa.png',
                                    'text' => 'Nos campos da tabela, é possível registrar os dados da empresa.',
                                ],
                                [
                                    'img' => 'empresas/new/cancel_da_nova_empresa.png',
                                    'text' => 'Nesse campo é possível cancelar as ações de cadastramento de uma nova empresa.',
                                ],
                                [
                                    'img' => 'empresas/new/add_da_nova_empresa.png',
                                    'text' => 'Nesse campo você irá adicionar uma nova empresa, após o preenchimento de todos os campos de cadastramento.',
                                ],
                                [
                                    'img' => 'empresas/new/dados_do_repre_nova_empresa.png',
                                    'text' => 'Nesse campo você irá informar o nome e o cargo que exerce o representante da empresa.',
                                ],
                                [
                                    'img' => 'empresas/new/cancel_do_repre_nova_empresa.png',
                                    'text' => 'Nesse campo é possível cancelar as ações de cadastramento dos dados do representante da empresa.',
                                ],
                                [
                                    'img' => 'empresas/new/add_do_repre_nova_empresa.png',
                                    'text' => 'Nesse campo você irá adicionar uma nova empresa, após o preenchimento de todos os campos de cadastramento do representante da empresa.',
                                ],
                                [
                                    'img' => 'empresas/new/dados_do_endereco_nova_empresa.png',
                                    'text' => 'Nos campos da tabela, você irá adicionar os dados da empresa como: cep, bairro e estado.',
                                ],
                                [
                                    'img' => 'empresas/new/cancel_do_endereço_nova_empresa.png',
                                    'text' => 'Nesse campo é possível cancelar as ações de cadastramento dos dados de localização da empresa.',
                                ],
                                [
                                    'img' => 'empresas/new/add_do_endereço_nova_empresa.png',
                                    'text' => 'Nesse campo você irá adicionar uma nova empresa, após o preenchimento de todos os campos de cadastramento do endereço da empresa.',
                                ],
                            ],

                            'Setores' => [
                                [
                                    'img' => 'empresas/new/setores/dados_setores_nova_empresa.png',
                                    'text' => 'Nesse campo, você irá adicionar os setores e quais cursos a empresa se interessa na busca de um estagiário.',
                                ],
                                [
                                    'img' => 'empresas/new/setores/add_setores_nova_empresa.png',
                                    'text' => 'Ao clicar, você poderá adicionar um novo setor no qual a empresa trabalha.',
                                ],
                                [
                                    'img' => 'empresas/new/setores/add2_setores_nova_empresa.png',
                                    'text' => 'Ao clicar em adicionar, conclui - se a operação.',
                                ],
                                [
                                    'img' => 'empresas/new/setores/cancel_setores_nova_empresa.png',
                                    'text' => 'Ao clicar em cancelar, a operação será desfeita.',
                                ],
                            ],

                            'Convênios' => [
                                [
                                    'img' => 'empresas/new/convenio/registro_convenio_empresa.png',
                                    'text' => 'Nesta área, é possível registrar um novo convênio.',
                                ],
                                [
                                    'img' => 'empresas/new/convenio/cancel_registro_convenio_empresa.png',
                                    'text' => 'Ao clicar em cancelar, a operação será desfeita.',
                                ],
                                [
                                    'img' => 'empresas/new/convenio/add_registro_convenio_empresa.png',
                                    'text' => 'Ao clicar em adicionar, conclui - se a operação',
                                ],
                            ],
                        ],
                    ]
                ]
            ];


        } else if ($user->isCoordinator()) {

            $content = [
                'Configurações do sistema' => [
                    'Alterar senha' => [
                        'desc' => null,
                        'content' => [
                            [
                                'img' => 'alterar_senha/altera_senha_barra.png',
                                'text' => 'Nesses campos, você altera a senha.',
                            ],
                            [
                                'img' => 'alterar_senha/altera_senha_cancelar.png',
                                'text' => 'Clicando aqui, você tem a possibilidade de cancelar a alteração de senha.',
                            ],
                            [
                                'img' => 'alterar_senha/altera_senha_salvar.png',
                                'text' => 'Clicando aqui, você tem a possibilidade de salvar a nova senha.',
                            ],
                        ]
                    ],

                    'Parâmetros do sistema' => [
                        'desc' => 'Dados e informações sobre a Instituição, com funções de download de planilhas e impressão.',
                        'content' => [
                            [
                                'img' => 'parametros_sist/conf_parametros_adicionar.png',
                                'text' => 'A opção “Adicionar parâmetros” permite que você cadastre uma nova instituição no sistema.',
                            ],
                            [
                                'img' => 'parametros_sist/new_parametros_dados.png',
                                'text' => 'Para realizar o cadastro, utilize os campos em “Dados do parâmetro” para adicionar informações sobre a nova instituição.',
                            ],
                            [
                                'img' => 'parametros_sist/new_parametros_adicionar.png',
                                'text' => 'Após preencher, clique em “Adicionar” para salvar a nova instituição no banco de dados.',
                            ],
                            [
                                'img' => 'parametros_sist/conf_parametros_CSV.png',
                                'text' => 'Clicando na opção “CSV”, você pode realizar o download da planilha, que poderá ser visualizada e manipulada utilizando softwares como o libre office calc ou excel.',
                            ],
                            [
                                'img' => 'parametros_sist/conf_parametros_imprimir.png',
                                'text' => 'Clicando na opção “Imprimir” você pode imprimir a planilha de parâmetros do sistema.',
                            ],
                            [
                                'img' => 'parametros_sist/conf_parametros_barra.png',
                                'text' => 'Nessa tabela, você visualiza os parâmetros já cadastrados no banco de dados.',
                            ],
                            [
                                'img' => 'parametros_sist/conf_parametros_antProx.png',
                                'text' => 'Os botões “Anterior” e “Próxima” permitem trocar as páginas quando determinado número de registros for atingido.',
                            ],
                            [
                                'img' => 'parametros_sist/conf_parametros_pesquisar.png',
                                'text' => 'Para explorar os registros, você pode utilizar a barra de pesquisa ou a navegação por páginas.',
                            ],
                        ],
                    ],

                    'Backup do sistema' => [
                        'desc' => 'Salvamento de arquivos que pode ser programado para que ocorra automaticamente e restaurar arquivos antigos .JSON.',
                        'content' => [
                            [
                                'img' => 'backup/conf_backup_fazerBackup.png',
                                'text' => 'Ao clicar em “Fazer backup”, o usuário tem a possibilidade de baixar o conteúdo do banco de dados em formato JSON.',
                            ],
                            [
                                'img' => 'backup/agendar_backup.png',
                                'text' => 'Na opção “Agendar Backup”, o usuário tem a possibilidade de escolher os dias da semana e horário em que o salvamento de dados será feito.',
                            ],
                            [
                                'img' => 'backup/conf_backup_salvar.png',
                                'text' => 'Em “Salvar”, a operação é concluída.',
                            ],
                            [
                                'img' => 'backup/conf_backup_restaurar.png',
                                'text' => 'Em “Restaurar”, o usuário poderá restaurar a estrutura de dados para um backup anterior já salvo.',
                            ],
                            [
                                'img' => 'backup/restaurar_backup.png',
                                'text' => 'A opção “Escolher arquivo” permite que um arquivo de backup seja carregado diretamente da pasta de arquivos.',
                            ],
                            [
                                'img' => 'backup/restaurar_backup_restaurar.png',
                                'text' => 'O botão “Restaurar” completa a operação.',
                            ],
                        ],

                    ],

                    'Configurações gerais do curso' => [
                        'desc' => null,
                        'content' => [
                            [
                                'img' => 'configurações_curso/conf_gerais_barra.png',
                                'text' => 'Essa tabela disponibiliza dados que todos os cursos possuem em comum.',
                            ],
                            [
                                'img' => 'configurações_curso/conf_gerais_antProx.png',
                                'text' => 'Os botões “Anterior” e “Próxima” permitem trocar as páginas quando determinado número de registros for atingido.',
                            ],
                            [
                                'img' => 'configurações_curso/conf_gerais_CSV.png',
                                'text' => 'Neste campo destacado, o usuário poderá fazer o download de uma planilha que contém informações em comum à todos os cursos.',
                            ],
                            [
                                'img' => 'configurações_curso/conf_gerais_imprimir.png',
                                'text' => 'Neste campo destacado, o usuário poderá imprimir a planilha que contém informações em comum à todos os cursos.',
                            ],
                            [
                                'img' => 'configurações_curso/conf_gerais_pesquisar.png',
                                'text' => 'Na opção “Pesquisar” você pode pesquisar alguma informação específica.',
                            ],
                        ],
                    ]
                ],

                'Funcionalidades extras' => [
                    'Mensagem' => [
                        'desc' => null,
                        'content' => [
                            [
                                'img' => 'mensagem/mensagem_visualizar.png',
                                'text' => '    Ao clicar nesse botão você visualizará os alunos que se encaixam nos filtros pré selecionados. ',
                            ],
                            [
                                'img' => 'mensagem/mensagem_enviar.png',
                                'text' => '  Ao clicar nesse botão você enviará a mensagem aos alunos selecionados.  ',
                            ],
                            [
                                'img' => 'mensagem/mensagem_tipos.png',
                                'text' => ' Nesse campo você poderá utilizar esses parametros para editar o texto da sua mensagem.    ',
                            ],
                            [
                                'img' => 'mensagem/mensagem_alunos.png',
                                'text' => '   Nesse campo você poderá escolher um aluno especifico. ',
                            ],
                        ]
                    ],

                    'Logs' => [
                        'desc' => null,
                        'content' => [
                            [
                                'img' => 'logs/logs_barra.png',
                                'text' => 'Essa tabela disponibiliza o monitoramento de todas as funções desempenhadas no sistema, que serão registradas no banco de dados por segurança e chance de recuperação de dados excluídos por engano.',
                            ],
                            [
                                'img' => 'logs/logs_baixar.png',
                                'text' => '    Na opção “Baixar Log” você consegue baixar toda a planilha de logs.',
                            ],
                            [
                                'img' => 'logs/logs_limpar.png',
                                'text' => '    Na opção “Limpar Log” você limpa toda a tabela de logs, porém os dados continuam no servidor.',
                            ],
                            [
                                'img' => 'logs/logs_excluir.png',
                                'text' => '    Na opção “Excluir Log” você limpa toda a tabela de logs, e também exclui os dados do servidor.',
                            ],
                            [
                                'img' => 'logs/logs_pesquisar.png',
                                'text' => '    Na opção “Pesquisar” você pode pesquisar algum log em específico.',
                            ],
                        ]
                    ],
                ],

                'Página inicial' => [
                    'Notificações' => [
                        'desc' => null,
                        'content' => [
                            [
                                'img' => 'configurações_curso/notificações.png',
                                'text' => 'Nesse espaço aparecerão ao usuário notificações relativas a mensagens de coordenadores, vagas de estágio, novidades e informações.',
                            ],
                        ]
                    ],
                ],

                'Funcionalidades do sistema' => [
                    'Estágio' => [
                        null
                    ],

                    'Cursos' => [
                        'desc' => null,
                        'content' => [
                            'Visualizar cursos' => [
                                [
                                    'img' => 'cursos/cursos.png',
                                    'text' => 'Nessa página o usuário terá a possibilidade de observar os detalhes, fazer edições, adicionar coordenadores e encaminha para a página de configurações do curso selecionado.',
                                ],
                                [
                                    'img' => 'cursos/cursos_anteProx.png',
                                    'text' => 'Os botões “Anterior” e “Próxima” permitem trocar as páginas quando determinado número de registros for atingido.',
                                ],
                                [
                                    'img' => 'cursos/down_curso.png',
                                    'text' => 'Neste campo destacado, o usuário poderá fazer o download de uma planilha que contém os nome de todos os coordenadores,informando os cursos correspondentes, assim como a data do seu ingresso na coordenadoria e do seu egresso.',
                                ],
                                [
                                    'img' => 'cursos/imprimi_curso.png',
                                    'text' => 'Através deste campo destacado, o usuário poderá imprimir e até mesmo criar um arquivo PDF em formato de planilha, assim como salvar no Google Drive tais informações.',
                                ],
                                [
                                    'img' => 'cursos/pesquisar_curso.png',
                                    'text' => 'Na barra pesquisa, o usuário poderá pesquisar o curso que deseja encontrar, podendo colocar o nome inteiro ou parcialmente.',
                                ],
                            ],

                            'Novo curso' => [
                                [
                                    'img' => 'cursos/add_curso.png',
                                    'text' => 'Neste campo, há a possibilidade de adicionar um novo curso à tabela.',
                                ],
                                [
                                    'img' => 'cursos/curso_new_barra.png',
                                    'text' => 'Nesse campo o usuário poderá adicionar as informações básicas do curso.',
                                ],
                                [
                                    'img' => 'cursos/curso_new_cancelar.png',
                                    'text' => 'Este campo trará a possibilidade do usuário cancelar a ação ”adicionar novo curso”, caso tenha ocorrido algum contratempo.',
                                ],
                                [
                                    'img' => 'cursos/curso_new_add.png',
                                    'text' => 'Este campo é a confirmação do ato “Adicionar novo Curso”, na qual salvará os dados no Banco.',
                                ],
                            ],
                        ]
                    ],

                    'Usuários' => [
                        'desc' => null,
                        'content' => [
                            'Visualizar usuário' => [
                                [
                                    'img' => 'usuarios/user_view_barra.png',
                                    'text' => 'Nesta tabela, é possível visualizar  o id dos usuários, nome, email, cargo e também há a possibilidade de editar as informações.',
                                ],
                                [
                                    'img' => 'usuarios/user_view_antProx.png',
                                    'text' => 'Os botões “Anterior” e “Próxima” permitem trocar as páginas quando determinado número de registros for atingido.',
                                ],
                                [
                                    'img' => 'usuarios/user_view_CSV.png',
                                    'text' => 'Nesta opção, o usuário tem a opção de baixar a planilha de usuários.',
                                ],
                                [
                                    'img' => 'usuarios/user_view_imprimir.png',
                                    'text' => 'Nesta área é possível imprimir as informações apresentadas na tabela de usuários.',
                                ],
                                [
                                    'img' => 'usuarios/user_view_pesquisar.png',
                                    'text' => 'A área de pesquisa permite pesquisar informações sobre usuários.',
                                ],
                            ],

                            'Novo usuário' => [
                                [
                                    'img' => 'usuarios/user_view_add.png',
                                    'text' => 'Neste campo, há a possibilidade de adicionar um novo usuário à tabela.',
                                ],
                                [
                                    'img' => 'usuarios/user_new_barra.png',
                                    'text' => 'Neste campo, Você insere os dados relativos ao novo usuário que será cadastrado.',
                                ],
                                [
                                    'img' => 'usuarios/user_new_cancelar.png',
                                    'text' => 'Este campo trará a possibilidade do usuário cancelar o cadastro do novo usuário, caso tenha ocorrido algum contratempo.',
                                ],
                                [
                                    'img' => 'usuarios/user_new_add.png',
                                    'text' => 'Este campo permite que seja efetuado o cadastro de usuário.',
                                ],
                            ]
                        ]
                    ],

                    'Coordenadores' => [
                        'desc' => null,
                        'content' => [
                            'Visualizar coordenadores' => [
                                [
                                    'img' => 'coordenadores/coord_view_barra.png',
                                    'text' => 'Neste campo será possível observar os coordenadores que foram adicionados . Caso não haja nenhum coordenador cadastrado, apresentará a mensagem “Nenhum registro encontrado”.',
                                ],
                                [
                                    'img' => 'coordenadores/coord_view_antProx.png',
                                    'text' => 'Através destes campos destacados, o usuário poderá navegar pelas páginas anteriores dos coordenadores cadastrados e até mesmo ver as próximas.',
                                ],
                                [
                                    'img' => 'coordenadores/coord_view_CSV.png',
                                    'text' => 'Neste campo destacado, o usuário poderá fazer o download de uma planilha que contém os nome de todos os coordenadores,informando os cursos correspondentes, assim como a data do seu ingresso na coordenadoria e do seu egresso.',
                                ],
                                [
                                    'img' => 'coordenadores/coord_view_imprimir.png',
                                    'text' => 'Através deste campo destacado, o usuário poderá imprimir e até mesmo criar um arquivo PDF em formato de planilha, assim como salvar no Google Drive tais informações.',
                                ],
                                [
                                    'img' => 'coordenadores/coord_view_pesquisar.png',
                                    'text' => 'Neste campo o usuário poderá realizar uma pesquisa por nome, a fim de encontrar o coordenador desejado com maior facilidade e agilidade.',
                                ],
                            ],

                            'Novo coordenador' => [
                                [
                                    'img' => 'coordenadores/coord_new_barra.png',
                                    'text' => 'Neste campo será possível adicionar um novo coordenador, visto que pode haver troca de profissionais e até mesmo criação de novos curso no colégio.',
                                ],
                                [
                                    'img' => 'coordenadores/coord_new_cancelar.png',
                                    'text' => 'Este campo trará a possibilidade do usuário cancelar a ação “adicionar novo Coordenador”, caso tenha ocorrido algum contratempo.',
                                ],
                                [
                                    'img' => 'coordenadores/coord_new_adicionar.png',
                                    'text' => 'Este campo é a confirmação do ato “Adicionar novo Coordenador”, na qual salvará os dados no Banco.',
                                ],
                            ],
                        ]
                    ],

                    'Alunos' => [
                        null
                    ],

                    'Empresas' => [
                        'desc' => null,
                        'content' => [
                            'Visualizar empresa' => [
                                [
                                    'img' => 'empresas/view/dados_new_empresa.png',
                                    'text' => 'Nesta área é possível visualizar os dados das empresas associadas em formato de tabela.',
                                ],
                                [
                                    'img' => 'empresas/view/empresa_new_anteProx.png',
                                    'text' => 'Através destes campos destacados, o usuário poderá navegar pelas páginas anteriores das empresas cadastradas e até mesmo ver as próximas.',
                                ],
                                [
                                    'img' => 'empresas/view/down_new_empresa.png',
                                    'text' => 'Neste campo destacado, o usuário poderá fazer o download de uma planilha que contém os nome de todas as empresas,informando dados específicos das empresas, assim como a CNPJ, responsável e telefones.',
                                ],
                                [
                                    'img' => 'empresas/view/impri_new_empresa.png',
                                    'text' => 'Através deste campo destacado, o usuário poderá imprimir e até mesmo criar um arquivo PDF em formato de planilha, assim como salvar no Google Drive tais informações.',
                                ],
                                [
                                    'img' => 'empresas/view/pesq_new_empresa.png',
                                    'text' => 'Na barra pesquisa, o usuário poderá pesquisar as empresas que deseja encontrar, podendo colocar o nome inteiro ou parcialmente.',
                                ],
                            ],

                            'Nova empresa' => [
                                [
                                    'img' => 'empresas/new/add_new_empresa.png',
                                    'text' => 'Em “Adicionar empresa” você pode fazer um novo registro de empresas.',
                                ],
                                [
                                    'img' => 'empresas/new/dados_da_nova_empresa.png',
                                    'text' => 'Nos campos da tabela, é possível registrar os dados da empresa.',
                                ],
                                [
                                    'img' => 'empresas/new/cancel_da_nova_empresa.png',
                                    'text' => 'Nesse campo é possível cancelar as ações de cadastramento de uma nova empresa.',
                                ],
                                [
                                    'img' => 'empresas/new/add_da_nova_empresa.png',
                                    'text' => 'Nesse campo você irá adicionar uma nova empresa, após o preenchimento de todos os campos de cadastramento.',
                                ],
                                [
                                    'img' => 'empresas/new/dados_do_repre_nova_empresa.png',
                                    'text' => 'Nesse campo você irá informar o nome e o cargo que exerce o representante da empresa.',
                                ],
                                [
                                    'img' => 'empresas/new/cancel_do_repre_nova_empresa.png',
                                    'text' => 'Nesse campo é possível cancelar as ações de cadastramento dos dados do representante da empresa.',
                                ],
                                [
                                    'img' => 'empresas/new/add_do_repre_nova_empresa.png',
                                    'text' => 'Nesse campo você irá adicionar uma nova empresa, após o preenchimento de todos os campos de cadastramento do representante da empresa.',
                                ],
                                [
                                    'img' => 'empresas/new/dados_do_endereco_nova_empresa.png',
                                    'text' => 'Nos campos da tabela, você irá adicionar os dados da empresa como: cep, bairro e estado.',
                                ],
                                [
                                    'img' => 'empresas/new/cancel_do_endereço_nova_empresa.png',
                                    'text' => 'Nesse campo é possível cancelar as ações de cadastramento dos dados de localização da empresa.',
                                ],
                                [
                                    'img' => 'empresas/new/add_do_endereço_nova_empresa.png',
                                    'text' => 'Nesse campo você irá adicionar uma nova empresa, após o preenchimento de todos os campos de cadastramento do endereço da empresa.',
                                ],
                            ],

                            'Setores' => [
                                [
                                    'img' => 'empresas/new/setores/dados_setores_nova_empresa.png',
                                    'text' => 'Nesse campo, você irá adicionar os setores e quais cursos a empresa se interessa na busca de um estagiário.',
                                ],
                                [
                                    'img' => 'empresas/new/setores/add_setores_nova_empresa.png',
                                    'text' => 'Ao clicar, você poderá adicionar um novo setor no qual a empresa trabalha.',
                                ],
                                [
                                    'img' => 'empresas/new/setores/add2_setores_nova_empresa.png',
                                    'text' => 'Ao clicar em adicionar, conclui - se a operação.',
                                ],
                                [
                                    'img' => 'empresas/new/setores/cancel_setores_nova_empresa.png',
                                    'text' => 'Ao clicar em cancelar, a operação será desfeita.',
                                ],
                            ],

                            'Convênios' => [
                                [
                                    'img' => 'empresas/new/convenio/registro_convenio_empresa.png',
                                    'text' => 'Nesta área, é possível registrar um novo convênio.',
                                ],
                                [
                                    'img' => 'empresas/new/convenio/cancel_registro_convenio_empresa.png',
                                    'text' => 'Ao clicar em cancelar, a operação será desfeita.',
                                ],
                                [
                                    'img' => 'empresas/new/convenio/add_registro_convenio_empresa.png',
                                    'text' => 'Ao clicar em adicionar, conclui-se a operação',
                                ],
                            ],
                        ],
                    ]
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
