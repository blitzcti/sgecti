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
                        'desc' => "Utilize esta interface para alterar a sua senha de entrada.",
                        'content' => [
                            [
                                'img' => 'administrador/alterar_senha_admin.png',
                                'text' => 'Insira a senha em uso em "Senha atual" e a nova senha desejada em "Nova senha", confirmando a nova senha em "Repita a senha".',
                            ],
                        ]
                    ],

                    'Parâmetros do sistema' => [
                        'desc' => 'Informações e normas da instituição em que o sistema será utilizado. Os parâmetros serão exibidos nos documentos gerados automaticamente pelo sistema.',
                        'content' => [
                            [
                                'img' => 'administrador/parametros_admin.png',
                                'text' => 'Utilize os campos editáveis para alterar informações e visualizar os dados já registrados.',
                            ],
                            [
                                'img' => 'administrador/convenio_parametros_admin.png',
                                'text' => 'A validade se refere ao prazo dos convênios com as empresas cadastradas.',
                            ],
                        ],
                    ],

                    'Backup do sistema' => [
                        'desc' => 'Essa interface possibilita a realização de backups de segurança do sistema.',
                        'content' => [
                            [
                                'img' => 'administrador/realizar_backup_admin.png',
                                'text' => 'Você pode fazer o download dos dados do sistema.',
                            ],
                            [
                                'img' => 'administrador/restaurar_backup_admin.png',
                                'text' => 'Você pode restaurar os dados a partir de um registro antigo',
                            ],
                            [
                                'img' => 'administrador/programar_backup_admin.png',
                                'text' => 'Você pode agendar a realização automática de backups, ajustando os dias da semana e o horário destes.',
                            ],
                            [
                                'text' => 'A configuração do servidor de backup se encontra no arquivo <b>.env</b>, localizado no diretório de instalação do SGE no servidor, por questões de segurança.',
                            ],
                        ],

                    ],

                    'Configurações gerais do curso' => [
                        'desc' => 'As configurações gerais servem de base para o cadastro de novos cursos no sistema,definindo os parâmetros de acordo com as normas do Colégio ou da legislação.',
                        'content' => [
                            [
                                'img' => 'administrador/visualizar_conf_gerais_admin.png',
                                'text' => 'Visualize as configurações já registradas, ordenadas por data de vigência.',
                            ],
                            [
                                'img' => 'administrador/editar_conf_gerais_admin.png',
                                'text' => 'Adicione/edite configurações utilizando essa interface, que salva as normas por data de vigência e respeitando a retroatividade.',
                            ],

                        ],
                    ],

                    'Logs' => [
                        'desc' => 'Nos Logs de sistema, o administrador pode visualizar, por data e horário, todas as ações realizadas no sistema, como cadastros, alterações e até mesmo aprovação de estágios e propostas.Atenção: mensalmente, os logs com mais de 30 dias são excluídos automaticamente.',
                        'content' => [
                            [
                                'text' => 'Atenção! Mensalmente, os logs com mais de 30 dias são excluídos automaticamente.',
                            ],
                            [
                                'img' => 'administrador/nav_log_admin.png',
                                'text' => 'Utilize a barra lateral para navegar pelos arquivos de log de datas anteriores.',
                            ],
                            [
                                'img' => 'administrador/baixar_log_admin.png',
                                'text' => 'Apertando esse botão, você pode baixar o arquivo .log selecionado e todos os seus registros.',
                            ],
                            [
                                'img' => 'administrador/limpar_excluir_log_admin.png',
                                'text' => 'Utilize o botão "Limpar log" para excluir os registros do arquivo .log selecionado.
                               Utilize o botão "Excluir log" para excluir o arquivo .log selecionado.',
                            ],
                            [
                                'img' => 'administrador/exctudo_log_admin.png',
                                'text' => 'Selecione "Excluir tudo" para excluir todos os arquivos .log do sistema (incluindo o selecionado).',
                            ],

                        ],
                    ]

                ],

                'Padronização de tabelas' => [
                    'CSV' => [
                        'desc' => 'Selecionando a opção "CSV", você pode fazer o download da tabela em formato de planilha (.csv), para visualização em Excel, Calc ou Google Planilhas.',
                        'content' => [
                            [
                                'img' => 'administrador/csv_admin.png',
                                'text' => 'A opção estará disponível em todas as tabelas do sistema.',
                            ],
                        ]
                    ],

                    'Imprimir' => [
                        'desc' => 'Selecionando a opção "Imprimir", você pode fazer imprimir a tabela ou gerar um arquivo PDF com todos os dados contidos nela.',
                        'content' => [
                            [
                                'img' => 'administrador/imprimir_admin.png',
                                'text' => 'A opção estará disponível em todas as tabelas do sistema.',
                            ],
                        ]
                    ],

                    'Pesquisar' => [
                        'desc' => 'Pesquise registros específicos inserindo palavras ou termos relacionados. Ex.: para encontrar um registro do curso de Mecânica, você pode digitar "mec", e serão exibidas todas as linhas que possuem algum campo com essas letras.',
                        'content' => [
                            [
                                'img' => 'administrador/pesquisa_admin.png',
                                'text' => 'A opção estará disponível em todas as tabelas do sistema.',
                            ],
                        ]
                    ],

                    'Anterior/Próximo' => [
                        'desc' => 'Navegue pelas diferentes páginas da tabela, que serão geradas automaticamente de acordo com o número de registros.',
                        'content' => [
                            [
                                'img' => 'administrador/ant_prox_admin.png',
                                'text' => 'A opção estará disponível em todas as tabelas do sistema.',
                            ],
                        ]
                    ],
                ],

                'Página inicial' => [
                    'Dashboard' => [
                        'desc' => 'No início, o administrador pode visualizar a Dashboard, que exibe informações do servidor e as notificações (descritas em outro tópico)',
                        'content' => [
                            [
                                'img' => 'administrador/pagina_inicial.png',
                                'text' => 'Visualize estatísticas de uso do servidor e de seu poder de processamento.',
                            ],
                            [
                                'img' => 'administrador/manutencao_inicio.png',
                                'text' => 'Ative a opção "Manutenção" somente nos casos de manutenção técnica, correção de erros ou incremento de funcionalidades. Ao ser ativada, todos os acessos serão restritos, com exceção do próprio endereço de IP sendo utilizado.',
                            ],
                        ]
                    ],

                    'Notificações' => [
                        'desc' => 'Visualize as notificações e atualizações do sistema, dos estágios, das coordenadorias, empresas, etc.',
                        'content' => [
                            [
                                'img' => 'administrador/notifica_admin.png',
                                'text' => 'Selecione o sino para visualizar as notificações.',
                            ],
                            [
                                'img' => 'administrador/notificacoes_admin.png',
                                'text' => 'Clique em "Ver todas" para abrir uma tabela com todas as notificações ainda não lidas.',
                            ],
                        ]
                    ],
                ],

                'Funcionalidades do sistema' => [
                    'Mensagem' => [
                        'desc' => 'Envie mensagens para os alunos do Colégio, através do email.',
                        'content' => [
                            'Filtros' => [
                                [
                                    'img' => 'administrador/filtro_mensagem_admin.png',
                                    'text' => 'Selecione turmas, períodos e outros filtros para especificar os alunos que devem receber a mensagem a ser escrita. Utilizando a aba "Alunos específicos", você pode enviar a mensagem para um ou mais alunos específicos, que podem ser selecionados através de RA e nome.',
                                ],
                            ],

                            'Conteúdo' => [
                                [
                                    'img' => 'administrador/content_mensagem_admin.png',
                                    'text' => 'Você pode redigir mensagens com alto grau de personalização, editando tamanho de texto, inserindo conteúdo em negrito, sublinhado ou itálico e até imagens.',
                                ],
                            ],
                        ],
                    ],

                    'Usuários' => [
                        'desc' => "Os usuários são todos aqueles que têm acesso ao sistema, seja como administrador, professor, empresa ou aluno.",
                        'content' => [
                            'Visualizar usuários' => [
                                [
                                    'img' => 'administrador/visualizar_usuario_admin.png',
                                    'text' => 'Visualize todos os usuários cadastrados, podendo editar seus registros e visualizar a que grupo pertencem.',
                                ],
                            ],

                            'Adicionar usuário' => [
                                [
                                    'img' => 'administrador/add_usuario_admin.png',
                                    'text' => 'Adicione um novo usuário. Atenção! Todos os coordenadores, para serem registrados, devem primeiramente serem cadastrados no grupo de Professores, para que fiquem disponíveis à escolha na página de Coordenadores (descrita em outro tópico).',
                                ],
                            ],
                        ],
                    ],

                    'Cursos' => [
                        'desc' => "São todos os cursos atualmente ativos ou que em algum momento já foram oferecidos pelo Colégio.",
                        'content' => [
                            'Visualizar cursos' => [
                                [
                                    'img' => 'administrador/visualizar_curso_admin.png',
                                    'text' => 'Visualize todos os cursos relacionados à instituição, podendo visualizar os respectivos coordenadores e outras configurações.',
                                ],
                            ],

                            'Adicionar curso' => [
                                [
                                    'img' => 'administrador/add_curso_admin.png',
                                    'text' => 'Adicione um novo curso ao sistema. Selecione a opção "Adicionar configuração" caso deseje adicionar configurações personalizadas ao curso (diferentes das opções gerais de curso, já explicadas no tópico "Configurações do sistema").',
                                ],
                                [
                                    'img' => 'administrador/conf_add_curso_admin.png',
                                    'text' => 'Determine normas exclusivas ao novo curso, alterando por exemplo as horas mínimas de estágio ou outras regras, ou seja, que sejam diferentes das opções gerais de curso definidas nas "Confirações do sistema".',
                                ],
                            ],

                            'Adicionar configuração' => [
                                [
                                    'img' => 'administrador/conf_visualizar_curso_admin.png',
                                    'text' => 'Ao visualizar todos os cursos cadastrados, você pode selecionar um deles para realizar a alteração ou adição de suas opções de curso.',
                                ],
                                [
                                    'img' => 'administrador/add_conf_curso_admin.png',
                                    'text' => 'Ao ser direcionado a essa página, clique em "Adicionar configuração" para adicionar uma nova configuração do curso selecionado, ou edite alguma das opções já cadastradas.',
                                ],
                            ],
                        ],
                    ],

                    'Coordenadores' => [
                        'desc' => "Os coordenadores têm acesso a uma interface específica do sistema, e podem trabalhar com propostas e estágios, enviar mensagens e administrar a entrega de relatórios.",
                        'content' => [
                            'Visualizar coordenadores' => [
                                [
                                    'img' => 'administrador/visualizar_coordenador_admin.png',
                                    'text' => 'Visualize todos os coordenadores registrados e as datas de vigência de suas coordenadorias, sejam essas atuais ou anteriores.',
                                ],
                            ],

                            'Adicionar coordenador' => [
                                [
                                    'img' => 'administrador/add_coordenador_admin.png',
                                    'text' => 'Você pode adicionar um novo coordenador de curso, que deve obrigatoriamente estar registrado como usuário Professor.',
                                ],
                                [
                                    'img' => 'administrador/temp_add_coordenador_admin.png',
                                    'text' => 'Em épocas de férias ou recesso, um novo coordenador pode ser registrado apenas como temporário de outro coordenador já ativo, ao selecionar a opção indicada. Um coordenador temporário poderá usufruir das mesmas permissões de qualquer outro coordenador (restrito ao seu respectivo curso).',
                                ],
                            ],
                        ],
                    ],

                    'Geração de documentos' => [
                        'desc' => 'O SGE é capaz de gerar automaticamente todos os documentos necessários à realização do estágio. Desde o plano de estágio até o relatório final.',
                        'content' => [
                            [
                                'img' => 'administrador/docs_estagio.png',
                                'text' => 'Caso seja necessário, é possível acessar o servidor do SGE para realizar alterações nos templates da documentação de estágio. Os templates se localizam em <b>storage/app/public/docs/templates</b>.',
                            ]
                        ],
                    ],
                ]
            ];
        } elseif ($user->isCoordinator()) {
            $content = [
                'Configurações do sistema' => [
                    'Alterar senha' => [
                        'desc' => "Utilize esta interface para alterar a sua senha de entrada.",
                        'content' => [
                            [
                                'img' => 'coordenador/alterar_senha_coordenadores.png',
                                'text' => 'Insira a senha em uso em "Senha atual" e a nova senha desejada em "Nova senha", confirmando a nova senha em "Repita a senha".',
                            ],
                        ]
                    ],
                ],

                'Padronização de tabelas' => [
                    'CSV' => [
                        'desc' => 'Selecionando a opção "CSV", você pode fazer o download da tabela em formato de planilha (.csv), para visualização em Excel, Calc ou Google Planilhas.',
                        'content' => [
                            [
                                'img' => 'coordenador/csv_coordenadores.png',
                                'text' => 'A opção estará disponível em todas as tabelas do sistema.',
                            ],
                        ]
                    ],

                    'Imprimir' => [
                        'desc' => 'Selecionando a opção "Imprimir", você pode fazer imprimir a tabela ou gerar um arquivo PDF com todos os dados contidos nela.',
                        'content' => [
                            [
                                'img' => 'coordenador/imprimir_coordenadores.png',
                                'text' => 'A opção estará disponível em todas as tabelas do sistema.',
                            ],
                        ]
                    ],

                    'Pesquisar' => [
                        'desc' => 'Pesquise registros específicos inserindo palavras ou termos relacionados. Ex.: para encontrar um registro do curso de Mecânica, você pode digitar "mec", e serão exibidas todas as linhas que possuem algum campo com essas letras.',
                        'content' => [
                            [
                                'img' => 'coordenador/pesquisa_coordenadores.png',
                                'text' => 'A opção estará disponível em todas as tabelas do sistema.',
                            ],
                        ]
                    ],

                    'Anterior/Próximo' => [
                        'desc' => 'Navegue pelas diferentes páginas da tabela, que serão geradas automaticamente de acordo com o número de registros.',
                        'content' => [
                            [
                                'img' => 'coordenador/ant_prox_coordenadores.png',
                                'text' => 'A opção estará disponível em todas as tabelas do sistema.',
                            ],
                        ]
                    ],
                ],

                'Página inicial' => [
                    'Dashboard' => [
                        'desc' => 'No início, o administrador pode visualizar a Dashboard, que exibe informações da sua coordenadoria e as notificações (descritas em outro tópico)',
                        'content' => [
                            [
                                'img' => 'coordenador/pagina_inicial_coordenadores.png',
                                'text' => 'Visualize relatórios atrasados e outros assuntos de importância.',
                            ],
                        ]
                    ],

                    'Notificações' => [
                        'desc' => 'Visualize as notificações e atualizações do sistema, dos estágios, das coordenadorias, empresas, etc.',
                        'content' => [
                            [
                                'img' => 'coordenador/notifica_coordenadores.png',
                                'text' => 'Selecione o sino para visualizar as notificações.',
                            ],
                            [
                                'img' => 'coordenador/notificacao_coordenadores.png',
                                'text' => 'Clique em "Ver todas" para abrir uma tabela com todas as notificações ainda não lidas.',
                            ],
                        ]
                    ],
                ],

                'Funcionalidades do sistema' => [
                    'Mensagem' => [
                        'desc' => 'Envie mensagens para os alunos do Colégio, através do email.',
                        'content' => [
                            'Filtros' => [
                                [
                                    'img' => 'coordenador/filtro_mensagem_coordenadores.png',
                                    'text' => 'Selecione turmas, períodos e outros filtros para especificar os alunos que devem receber a mensagem a ser escrita. Utilizando a aba "Alunos específicos", você pode enviar a mensagem para um ou mais alunos específicos, que podem ser selecionados através de RA e nome. Aviso: cada coordenador está restrito aos alunos do curso que coordena para o envio de emails.',
                                ],
                            ],

                            'Conteúdo' => [
                                [
                                    'img' => 'coordenador/content_mensagem_coordenadores.png',
                                    'text' => 'Você pode redigir mensagens com alto grau de personalização, editando tamanho de texto, inserindo conteúdo em negrito, sublinhado ou itálico e até imagens. Selecione alguma das opções como "Aviso importante" ou "Relatório bimestral" para automatizar a escrita e ganhar tempo.',
                                ],
                            ],
                        ],
                    ],

                    'Empresas' => [
                        'desc' => 'As empresas cadastradas pelos coordenadores passam a estar disponíveis no registro de novos estágios de alunos do Colégio.',
                        'content' => [
                            'Visualizar empresa' => [
                                [
                                    'img' => 'coordenador/visualizar_empresa_coordenadores.png',
                                    'text' => 'Visualize todas as empresas cadastradas em relação ao seu curso.',
                                ],
                            ],

                            'Adicionar empresa' => [
                                [
                                    'img' => 'coordenador/pg1_add_empresa.png',
                                    'text' => 'Ao adicionar o CNPJ da empresa ou o CPF do responsável, o sistema busca automaticamente outras informações disponíveis sobre o Cadastro no banco de dados da Receita Federal.',
                                ],
                                [
                                    'img' => 'coordenador/pg2_add_empresa.png',
                                    'text' => 'Ao adicionar o CEP do endereço da empresa, o sistema busca automaticamente o resto do endereço no banco de dados dos Correios.',
                                ],
                                [
                                    'img' => 'coordenador/pg3_add_empresa.png',
                                    'text' => 'Caso selecione a opção "Registrar convênio", um convênio será automaticamente registrado com referência à nova empresa.',
                                ],
                            ],

                            'Setores' => [
                                [
                                    'img' => 'coordenador/visualizar_setor_coordenadores.png',
                                    'text' => 'Visualize todos os setores possíveis já registrados em relação ao seu curso.',
                                ],
                                [
                                    'img' => 'coordenador/add_setor_coordenadores.png',
                                    'text' => 'Ao clicar em "Adicionar setor", na página anterior, você tem a possibilidade de adicionar um novo setor ao sistema, o que também pode ser feito utilizando a interface de adição de nova empresa (subtópico "Adicionar empresa", no presente tópico).',
                                ],
                            ],

                            'Supervisores' => [
                                [
                                    'img' => 'coordenador/visualizar_supervisor_coordenadores.png',
                                    'text' => 'Visualize todos os supervisores já registrados e associados às empresas registradas.',
                                ],
                                [
                                    'img' => 'coordenador/add_supervisor_coordenadores.png',
                                    'text' => 'Adicione um novo supervisor para uma empresa já cadastrada no sistema (para cadastrar uma nova empresa, leia o subtópico "Adicionar empresa", no presente tópico).',
                                ],
                            ],

                            'Convênios' => [
                                [
                                    'img' => 'coordenador/visualizar_convenios_ccoordenadores.png',
                                    'text' => 'Visualize todos os convênios de estágios com empresas já registrados.',
                                ],
                                [
                                    'img' => 'coordenador/add_convenios_coordenadores.png',
                                    'text' => 'Crie um convênio para uma empresa já cadastrada no sistema e ainda não conveniada (para cadastrar uma nova empresa, leia o subtópico "Adicionar empresa", no presente tópico).',
                                ],
                            ],
                        ],
                    ],

                    'Estágios' => [
                        'desc' => 'Os estágios dos alunos podem ser adicionados e administrados através desta interface.',
                        'content' => [
                            'Visualizar estágio' => [
                                [
                                    'img' => 'coordenador/visualizar_estagio_coordenadores.png',
                                    'text' => 'Visualize todos os estágios em andamento, cancelados ou finalizados em relação ao curso.',
                                ],
                            ],

                            'Adicionar estágio' => [
                                [
                                    'img' => 'coordenador/pg1_add_estagio.png',
                                    'text' => 'Adicione um novo estágio associando um aluno a uma empresa, selecionando representante, setor, datas e descrição das atividades. O estágio só poderá ser registrado caso siga as opções do seu curso, como os anos mínimos e o semestre do aluno.',
                                ],
                                [
                                    'img' => 'coordenador/pg2_add_estagio.png',
                                    'text' => 'A opção destacada com a seta pode auxiliar no preenchimento de horários repetidos, pois replica automaticamente os horários e dias desejados.',
                                ],
                            ],

                            'Termos Aditivos' => [
                                [
                                    'img' => 'coordenador/visualizar_termoadd_coordenadores.png',
                                    'text' => 'Visualize todos os termos aditivos criados para estágios registrados em relação ao curso, desempenhando a função de promover mudanças temporárias ou não de datas ou horários e outros parâmetros do estágio.',
                                ],
                                [
                                    'img' => 'coordenador/pg1_add_termo.png',
                                    'text' => 'Adicione um novo termo aditivo associado a um estágio já cadastrado.',
                                ],
                                [
                                    'img' => 'coordenador/pg2_add_termo.png',
                                    'text' => 'Selecionando essa opção, você tem a possibilidade de alterar a data de término do estágio.',
                                ],
                                [
                                    'img' => 'coordenador/pg3_add_termo.png',
                                    'text' => 'Ao selecionar "Alterar horário", você pode alterar os horários de realização do estágio pelo aluno, determinando uma data de início e de fim de vigência para alteração na agenda.',
                                ],
                            ],
                        ]
                    ],

                    'Trabalhos' => [
                        'desc' => 'Registros dos trabalhos CTPS realizados por alunos do Colégio.',
                        'content' => [
                            'Visualizar trabalhos' => [
                                [
                                    'img' => 'coordenador/visualizar_trabalho_coordenadores.png',
                                    'text' => 'Visualize todos os trabalhos registrados em relação ao curso.',
                                ],
                            ],

                            'Adicionar trabalho' => [
                                [
                                    'img' => 'coordenador/add_trabalho_coordenadores.png',
                                    'text' => 'Adicione um novo trabalho, associando-o com um aluno e outras informações da empresa e das atividades desenvolvidas.',
                                ],
                            ],
                            'Empresas' => [
                                [
                                    'img' => 'coordenador/visualizar_empresatrab_coordenadores.png',
                                    'text' => 'Visualize as empresas registradas exclusivamente para trabalhos CTPS, ou seja, sem relação com a oferta de estágios e/ou interesse por convênios.',
                                ],
                                [
                                    'img' => 'coordenador/add_empresatrab_coordenadores.png',
                                    'text' => 'Adicione uma nova empresa para futuros trabalhos CTPS.',
                                ],
                            ],
                        ]
                    ],

                    'Relatórios' => [
                        'desc' => 'Relatórios bimestrais e finais entregues por alunos que possuem estágio em andamento ou finalizado.',
                        'content' => [
                            'Visualizar relatórios' => [
                                [
                                    'img' => 'coordenador/visualizar_relatorio_coordenadores.png',
                                    'text' => 'Visualize todos os relatórios bimestrais ou finais entregues e registrados em relação ao curso.',
                                ],
                            ],

                            'Adicionar relatório bimestral' => [
                                [
                                    'img' => 'coordenador/add_bimestral_coordenadores.png',
                                    'text' => 'Adicione um relatório bimestral protocolado por um aluno estagiando.',
                                ],
                            ],

                            'Relatórios finais' => [
                                [
                                    'img' => 'coordenador/add_final_coordenadores.png',
                                    'text' => 'Adicione um relatório final protocolado por um aluno que está finalizando o estágio, preenchendo o questionário e revisando os dados do estágio.',
                                ],
                            ],
                        ]
                    ],

                    'Propostas' => [
                        'desc' => 'Recebidas das empresas registradas no SGE, podem ser aprovadas, rejeitadas ou divulgadas aos alunos do seu curso.',
                        'content' => [
                            'Visualizar propostas' => [
                                [
                                    'img' => 'coordenador/visualizar_propostas.png',
                                    'text' => 'Visualize todas as propostas recebidas pelo curso, podendo as aprovar, rejeitar, editar ou divulgar (através do email).',
                                ],
                            ],

                            'Adicionar proposta' => [
                                [
                                    'img' => 'coordenador/pg1_add_proposta.png',
                                    'text' => 'Toda proposta adicionada por um coordenador será automaticamente aprovada ao ser registrada. Deve estar obrigatoriamente associada a uma empresa.',
                                ],
                                [
                                    'img' => 'coordenador/pg2_add_proposta.png',
                                    'text' => 'O coordenador pode inserir propostas que abranjam mais que apenas seu próprio curso.',
                                ],
                                [
                                    'img' => 'coordenador/pg3_add_proposta.png',
                                    'text' => 'Ao selecionar a opção "Horário pré-definido", o estagiário terá ciência de que deverá contemplar obrigatoriamente as horários pré-definidas na proposta.',
                                ],
                            ],

                            'Enviar email' => [
                                [
                                    'img' => 'coordenador/email_visualizar_propostas.png',
                                    'text' => 'Ao selecionar a opção "Enviar email", você é redirecionado para a página de Mensagem (leia mais sobre no tópico 4.1 "Mensagem").',
                                ],
                                [
                                    'img' => 'coordenador/email_propostas.png',
                                    'text' => 'Na página de Mensagem (tópico 4.1), você pode selecionar, entre as propostas aprovadas, quais deseja divulgar para as turmas selecionadas através dos filtros.',
                                ],
                            ],
                        ]
                    ],

                    'Alunos' => [
                        'desc' => 'Integração com o banco de dados do NSac do Colégio.',
                        'content' => [
                            'Visualizar dados dos alunos' => [
                                [
                                    'img' => 'coordenador/dados_alunos.png',
                                    'text' => 'Visualize todos os registros dos alunos do Colégio.',
                                ],
                            ],

                            'Obter PDF dos alunos' => [
                                [
                                    'img' => 'coordenador/relacao_alunos.png',
                                    'text' => 'Defina filtros para geração de relação em PDF com os alunos selecionados.',
                                ],
                            ],
                        ]
                    ],
                ]
            ];
        } elseif ($user->isCompany()) {
            $content = [
                'Configurações do sistema' => [
                    'Alterar senha' => [
                        'desc' => "Utilize esta interface para alterar a sua senha de entrada.",
                        'content' => [
                            [
                                'img' => 'empresa/alterar_senha.png',
                                'text' => 'Insira a senha em uso em "Senha atual" e a nova senha desejada em "Nova senha", confirmando a nova senha em "Repita a senha".',
                            ],
                        ]
                    ],
                ],

                'Padronização de tabelas' => [
                    'CSV' => [
                        'desc' => 'Selecionando a opção "CSV", você pode fazer o download da tabela em formato de planilha (.csv), para visualização em Excel, Calc ou Google Planilhas.',
                        'content' => [
                            [
                                'img' => 'empresa/csv.png',
                                'text' => 'A opção estará disponível em todas as tabelas do sistema.',
                            ],
                        ]
                    ],

                    'Imprimir' => [
                        'desc' => 'Selecionando a opção "Imprimir", você pode fazer imprimir a tabela ou gerar um arquivo PDF com todos os dados contidos nela.',
                        'content' => [
                            [
                                'img' => 'empresa/imprimir.png',
                                'text' => 'A opção estará disponível em todas as tabelas do sistema.',
                            ],
                        ]
                    ],

                    'Pesquisar' => [
                        'desc' => 'Pesquise registros específicos inserindo palavras ou termos relacionados. Ex.: para encontrar um registro do curso de Mecânica, você pode digitar "mec", e serão exibidas todas as linhas que possuem algum campo com essas letras.',
                        'content' => [
                            [
                                'img' => 'empresa/pesquisa.png',
                                'text' => 'A opção estará disponível em todas as tabelas do sistema.',
                            ],
                        ]
                    ],

                    'Anterior/Próximo' => [
                        'desc' => 'Navegue pelas diferentes páginas da tabela, que serão geradas automaticamente de acordo com o número de registros.',
                        'content' => [
                            [
                                'img' => 'empresa/ant_prox.png',
                                'text' => 'A opção estará disponível em todas as tabelas do sistema.',
                            ],
                        ]
                    ],
                ],

                'Página inicial' => [
                    'Notificações' => [
                        'desc' => 'Nesse local apareceram as novas notificações e alertas sobre as propostas de estágio solicitadas, se foram aceitas ou não pelo coordenador.',
                        'content' => [
                            [
                                'img' => 'empresa/notifica_empresa.png',
                                'text' => 'Selecione o sino para visualizar as notificações disponíveis',
                            ],
                            [
                                'img' => 'empresa/notificacao_empresa.png',
                                'text' => 'Clique em "Ver todas" para abrir uma tabela com todas as notificações ainda não lidas.',
                            ],
                        ]
                    ],

                    'Propostas' => [
                        'desc' => 'Na página inicial, você pode visualizar estatísticas sobre as propostas enviadas por sua empresa ao Colégio.',
                        'content' => [
                            [
                                'img' => 'empresa/dashboard.png',
                                'text' => '',
                            ],
                        ]
                    ],
                ],

                'Funcionalidades do sistema' => [
                    'Propostas' => [
                        'desc' => 'Propostas enviadas por sua empresa ao Colégio.',
                        'content' => [
                            'Visualizar propostas' => [
                                [
                                    'img' => 'coordenador/visualizar_propostas.png',
                                    'text' => 'Visualize todas as propostas já enviadas e o estado destas (aprovadas, reprovadas ou pendentes).',
                                ],
                            ],

                            'Adicionar proposta' => [
                                [
                                    'img' => 'coordenador/pg1_add_proposta.png',
                                    'text' => 'Toda proposta enviada estará associada à sua empresa.',
                                ],
                                [
                                    'img' => 'coordenador/pg2_add_proposta.png',
                                    'text' => 'Sua proposta pode abranger mais de um curso.',
                                ],
                                [
                                    'img' => 'coordenador/pg3_add_proposta.png',
                                    'text' => 'Ao selecionar a opção "Horário pré-definido", o estagiário terá ciência de que deverá contemplar obrigatoriamente as horários pré-definidas na proposta.',
                                ],
                            ],
                        ]
                    ],
                ]
            ];
        } elseif ($user->isStudent()) {
            $content = [
                'Configurações do sistema' => [
                    'Alterar senha' => [
                        'desc' => "Utilize esta interface para alterar a sua senha de entrada.",
                        'content' => [
                            [
                                'img' => 'aluno/alterar_senha.png',
                                'text' => 'Insira a senha em uso em "Senha atual" e a nova senha desejada em "Nova senha", confirmando a nova senha em "Repita a senha".',
                            ],
                        ]
                    ],
                ],

                'Página inicial' => [
                    'Notificações' => [
                        'desc' => 'Neste local aparecerão as novas notificações e alertas sobre sua documentação ou propostas de estágio.',
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
                        'desc' => 'Acesse todas as propostas de estágio/IC disponíveis.',
                        'content' => [
                            'Visualizar' => [
                                [
                                    'img' => 'aluno/propostas_aluno.png',
                                    'text' => 'Visualize as propostas recebidas e aprovadas de empresas relacionadas ao Colégio.',
                                ],
                            ],

                            'Detalhes' => [
                                [
                                    'img' => 'aluno/detalhes_proposta.png',
                                    'text' => 'Veja mais detalhes sobre a proposta selecionada, como o contato para que você possa enviar seu currículo e outras informações.',
                                ],
                            ],
                        ],
                    ],

                    'Documentação de estágio' => [
                        'desc' => "Você pode utilizar essa interface para gerar automaticamente todos os documentos necessários à realização do estágio. Desde o plano de estágio até o relatório final.",
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
