<?php

namespace App\Providers;

use App\Models\Course;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @param Dispatcher $events
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        Schema::defaultStringLength(191);

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $this->loadMenu($event->menu);
        });
    }

    public function loadMenu($menu)
    {
        $courses = Course::all()->sortBy('id');
        $user = Auth::user();

        $menu->add('menu.system');
        $menu->add([
            'text' => 'menu.changePassword',
            'route' => 'alterarSenha',
            'icon' => 'lock',
            'active' => ['alterarSenha/']
        ]);

        if ($user->can('systemConfiguration-list')) {
            $menu->add([
                'text' => 'menu.configuration',
                'icon' => 'gear',
                'submenu' => [
                    [
                        'text' => 'menu.configurations', //CTI
                        'route' => 'admin.configuracoes.parametros.index',
                        'icon' => 'wrench',
                        'active' => ['admin/configuracoes/parametros/'],
                    ],
                    [
                        'text' => 'menu.backup',
                        'route' => 'admin.configuracoes.backup.index',
                        'icon' => 'floppy-o',
                        'active' => ['admin/configuracoes/backup/'],
                    ],
                ],
            ]);
        }

        if ($user->can('user-list')) {
            $menu->add([
                'text' => 'menu.users',
                'icon' => 'user',
                'submenu' => [
                    [
                        'text' => 'menu.view',
                        'route' => 'admin.usuario.index',
                        'icon' => 'th-list',
                        'active' => ['admin/usuario/']
                    ],
                    [
                        'text' => 'menu.new',
                        'route' => 'admin.usuario.novo',
                        'icon' => 'edit',
                        'active' => ['admin/usuario/novo']
                    ],
                ]
            ]);
        }

        $menu->add([
            'text' => 'menu.message',
            'route' => $user->hasRole('admin') ? 'admin.mensagem.index' : ($user->isCoordinator() ? 'coordenador.mensagem.index' : null),
            'icon' => 'envelope',
            'active' => ['admin/mensagem/', 'coordenador/mensagem']
        ]);

        if ($user->hasRole('admin')) {
            $menu->add([
                'text' => 'menu.logs',
                'icon' => 'calendar',
                'route' => 'admin.logs',
                'active' => ['admin/logs*'],
            ]);
        }

        $menu->add([
            'text' => 'menu.help',
            'route' => 'ajuda.index',
            'icon' => 'question-circle',
            'active' => ['ajuda/']
        ]);

        $menu->add([
            'text' => 'menu.about',
            'route' => 'sobre.index',
            'icon' => 'info-circle',
            'active' => ['sobre/']
        ]);

        if ($user->hasRole('admin')) {
            $menu->add('menu.administration');
            if ($user->can('course-list')) {
                $submenu = [
                    [
                        'text' => 'menu.view',
                        'route' => 'admin.curso.index',
                        'icon' => 'th-list',
                        'active' => ['admin/curso/']
                    ],
                    [
                        'text' => 'menu.new',
                        'route' => 'admin.curso.novo',
                        'icon' => 'edit',
                        'active' => ['admin/curso/novo']
                    ],
                ];

                if ($user->can('coordinator-list')) {
                    $coordinator = [
                        'text' => 'Coordenadores',
                        'icon' => 'black-tie',
                        'submenu' => [
                            [
                                'text' => 'menu.view',
                                'route' => 'admin.coordenador.index',
                                'icon' => 'th-list',
                                'active' => ['admin/coordenador/']
                            ],
                            [
                                'text' => 'menu.new',
                                'route' => 'admin.coordenador.novo',
                                'icon' => 'edit',
                                'active' => ['admin/coordenador/novo']
                            ],
                        ]
                    ];

                    array_push($submenu, $coordinator);
                }

                $menu->add([
                    'text' => 'menu.courses',
                    'icon' => 'graduation-cap',
                    'submenu' => $submenu,
                ]);
            }

            //Cursos tab
            $menu->add('CURSOS');
            foreach ($courses as $course) {
                if ($course->active) {
                    $color = $course->color;

                    $menu->add([
                        'text' => $course->name,
                        'icon_color' => $color->name
                    ]);
                }
            }
        }

        if ($user->isCoordinator()) {
            $menu->add('COORDENAÇÃO DE ESTÁGIO');

            if ($user->can('company-list')) {
                $submenu = [
                    [
                        'text' => 'menu.view',
                        'route' => 'coordenador.empresa.index',
                        'icon' => 'th-list',
                        'active' => ['coordenador/empresa/']
                    ],
                    [
                        'text' => 'menu.new',
                        'route' => 'coordenador.empresa.novo',
                        'icon' => 'edit',
                        'active' => ['coordenador/empresa/novo']
                    ],
                ];

                if ($user->can('companySector-list')) {
                    $companySector = [
                        'text' => 'menu.sector',
                        'icon' => 'balance-scale',
                        'submenu' => [
                            [
                                'text' => 'menu.view',
                                'route' => 'coordenador.empresa.setor.index',
                                'icon' => 'th-list',
                                'active' => ['coordenador/empresa/setor/']
                            ],
                            [
                                'text' => 'menu.new',
                                'route' => 'coordenador.empresa.setor.novo',
                                'icon' => 'edit',
                                'active' => ['coordenador/empresa/setor/novo']
                            ]
                        ]
                    ];

                    array_push($submenu, $companySector);
                }

                if ($user->can('companySupervisor-list')) {
                    $companySupervisor = [
                        'text' => 'menu.supervisors',
                        'icon' => 'user',
                        'submenu' => [
                            [
                                'text' => 'menu.view',
                                'route' => 'coordenador.empresa.supervisor.index',
                                'icon' => 'th-list',
                                'active' => ['coordenador/empresa/supervisor/']
                            ],
                            [
                                'text' => 'menu.new',
                                'route' => 'coordenador.empresa.supervisor.novo',
                                'icon' => 'edit',
                                'active' => ['coordenador/empresa/supervisor/novo']
                            ],
                        ]
                    ];

                    array_push($submenu, $companySupervisor);
                }

                if ($user->can('companyAgreement-list')) {
                    $companyAgreement = [
                        'text' => 'menu.agreements',
                        'icon' => 'exchange',
                        'submenu' => [
                            [
                                'text' => 'menu.view',
                                'route' => 'coordenador.empresa.convenio.index',
                                'icon' => 'th-list',
                                'active' => ['coordenador/empresa/convenio/']
                            ],
                            [
                                'text' => 'menu.new',
                                'route' => 'coordenador.empresa.convenio.novo',
                                'icon' => 'edit',
                                'active' => ['coordenador/empresa/convenio/novo']
                            ],
                        ]
                    ];

                    array_push($submenu, $companyAgreement);
                }

                $menu->add([
                    'text' => 'menu.company',
                    'icon' => 'building',
                    'submenu' => $submenu,
                ]);
            }

            if ($user->can('internship-list')) {
                $submenu = [
                    [
                        'text' => 'menu.view',
                        'route' => 'coordenador.estagio.index',
                        'icon' => 'th-list',
                        'active' => ['coordenador/estagio/']
                    ],
                    [
                        'text' => 'menu.new',
                        'route' => 'coordenador.estagio.novo',
                        'icon' => 'edit',
                        'active' => ['coordenador/estagio/novo']
                    ],
                ];

                if ($user->can('internshipAmendment-list')) {
                    $internshipAmendment = [
                        'text' => 'menu.aditive',
                        'icon' => 'plus',
                        'submenu' => [
                            [
                                'text' => 'menu.view',
                                'route' => 'coordenador.estagio.aditivo.index',
                                'icon' => 'th-list',
                                'active' => ['coordenador/estagio/aditivo/']
                            ],
                            [
                                'text' => 'menu.new',
                                'route' => 'coordenador.estagio.aditivo.novo',
                                'icon' => 'edit',
                                'active' => ['coordenador/estagio/aditivo/novo']
                            ],
                        ],
                    ];

                    array_push($submenu, $internshipAmendment);
                }

                $menu->add([
                    'text' => 'menu.internship',
                    'icon' => 'id-badge',
                    'submenu' => $submenu,
                ]);
            }

            if ($user->can('report-list')) {
                $menu->add([
                    'text' => 'menu.report',
                    'icon' => 'book',
                    'submenu' => [
                        [
                            'text' => 'menu.view',
                            'route' => 'coordenador.relatorio.index',
                            'icon' => 'th-list',
                            'active' => ['coordenador/relatorio/']
                        ],
                        [
                            'text' => 'menu.bimestral',
                            'route' => 'coordenador.relatorio.bimestral.novo',
                            'icon' => 'edit',
                            'active' => ['coordenador/relatorio/bimestral/novo']
                        ],
                        [
                            'text' => 'menu.final',
                            'route' => 'coordenador.relatorio.final.novo',
                            'icon' => 'edit',
                            'active' => ['coordenador/relatorio/final/novo']
                        ],
                        [
                            'text' => 'menu.pdf',
                            'route' => 'coordenador.relatorio.pdf',
                            'icon' => 'file-pdf-o',
                            'active' => ['coordenador/relatorio/pdf']
                        ],
                    ]
                ]);
            }

            $menu->add('ALUNOS');
            $menu->add([
                'text' => 'menu.student',
                'icon' => 'users',
                'submenu' => [
                    [
                        'text' => 'menu.data',
                        'route' => 'coordenador.aluno.index',
                        'icon' => 'file-text-o',
                        'active' => ['coordenador/aluno/']
                    ],
                ]
            ]);
        }
    }
}
