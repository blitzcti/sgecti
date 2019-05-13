<?php

namespace App\Providers;

use App\Color;
use App\Course;
use App\UserGroup;
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
            $courses = Course::all()->sortBy('id');

            $user = Auth::user();
            $group = UserGroup::all()->find($user->id_group);

            if ($group->id == 1)
                $this->LoadAdminMenu($courses, $event);
            else if ($group->id == 2)
                $this->LoadCoordinatorMenu($courses, $event /*, $curso_do_coordenador*/);
        });
    }

    public function LoadAdminMenu($courses, $event)
    {
        //Sistema
        $event->menu->add('SISTEMA');
        $event->menu->add(
            [
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
                        'route'  => 'admin.configuracoes.backup.index',
                        'icon' => 'floppy-o',
                        'active' => ['admin/configuracoes/backup/'],
                    ],
                ],
            ],
            [
                'text' => 'menu.users',
                'icon' => 'user',
                'submenu' => [
                    [
                        'text'   => 'menu.view',
                        'route'  => 'admin.usuario.index',
                        'icon'   => 'th-list',
                        'active' => ['admin/usuario/'] // If not set, even if at /curso/novo this item will be .active
                    ],
                    [
                        'text'  => 'menu.new',
                        'route' => 'admin.usuario.novo',
                        'icon'  => 'edit',
                        'active' => ['admin/usuario/novo']
                    ],
                ]
            ],
            [
                'text' => 'menu.message',
                'route'  => 'admin.mensagem.index',
                'icon' => 'envelope',
                'active' => ['admin/mensagem/']
            ],
            [
                'text' => 'menu.help',
                'route'  => 'ajuda.index',
                'icon' => 'question-circle',
                'active' => ['ajuda/']
            ]
        );
        $event->menu->add('ADMINISTRACAO');
        $event->menu->add(
            [
                'text' => 'menu.courses',
                'icon' => 'graduation-cap',
                'submenu' => [
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
                    [
                        'text' => 'Coordenadores',
                        'icon' => 'street-view',
                        'submenu' => [
                            [
                                'text' => 'menu.view',
                                //'route'  => 'admin.coordenadores.index',
                                'icon' => 'th-list',
                                'active' => ['admin/curso/']
                            ],
                            [
                                'text' => 'menu.new',
                                //'route' => 'admin.coordenadores.novo',
                                'icon' => 'edit',
                                'active' => ['admin/curso/novo']
                            ],
                        ]
                    ]
                ]
            ],
            [
                'text' => 'menu.student',
                'icon' => 'users',
                'submenu' => [
                    [
                        'text' => 'menu.history',
                        'route'  => 'aluno.index',
                        'icon' => 'hourglass-1',
                        'active' => ['admin/aluno/']
                    ],
                ]
            ]
        );

        //Cursos tab
        $event->menu->add('CURSOS');
        foreach ($courses as $course) {
            if ($course->active) {
                $color = Color::all()->find($course->id_color);

                $event->menu->add([
                    'text' => $course->name,
                    'icon_color' => $color->name
                ]);
            }
        }
    }

    public function LoadCoordinatorMenu($courses, $event)
    {
        $event->menu->add('SISTEMA');
        $event->menu->add(
            [
                'text' => 'menu.help',
                'route'  => 'ajuda.index',
                'icon' => 'question-circle',
                'active' => ['ajuda/']
            ]
        );

        $event->menu->add('COORDENAÇÃO DE ESTÁGIO');
        $event->menu->add(
            [
                'text' => 'menu.company',
                'icon' => 'building',
                'submenu' => [
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
                    [
                        'text' => 'menu.sector',
                        'icon' => 'balance-scale',
                        'submenu' => [
                            [
                                'text' => 'menu.view',
                                'route'  => 'coordenador.empresa.setor.index',
                                'icon' => 'th-list',
                                'active' => ['coordenador/empresa/setor/']
                            ],
                            [
                                'text' => 'menu.new',
                                'route'  => 'coordenador.empresa.setor.novo',
                                'icon' => 'edit',
                                'active' => ['coordenador/empresa/setor/novo']
                            ]
                        ]
                    ]
                ]
            ],
            [
                'text' => 'menu.internship',
                'icon' => 'id-badge',
                'submenu' => [
                    [
                        'text' => 'menu.view',
                        'route'  => 'coordenador.estagio.index',
                        'icon' => 'th-list',
                        'active' => ['coordenador/estagio/']
                    ],
                    [
                        'text' => 'menu.new',
                        'route'  => 'coordenador.estagio.novo',
                        'icon' => 'edit',
                        'active' => ['coordenador/estagio/novo']
                    ],
                    [
                        'text' => 'menu.ctps',
                        'route'  => 'coordenador.estagio.ctps',
                        'icon' => 'edit',
                        'active' => ['coordenador/estagio/novo']
                    ],
                    [
                        'text' => 'menu.aditive',
                        'icon' => 'plus',
                        'submenu' => [
                            [
                                'text' => 'menu.view',
                                'route'  => 'coordenador.estagio.aditivo.index',
                                'icon' => 'th-list',
                                'active' => ['coordenador/estagio/aditivo/']
                            ],
                            [
                                'text' => 'menu.new',
                                'route'  => 'coordenador.estagio.aditivo.novo',
                                'icon' => 'edit',
                                'active' => ['coordenador/estagio/aditivo/novo']
                            ],
                        ],
                    ],
                ]
            ],
            [
                'text' => 'menu.report',
                'icon' => 'book',
                'submenu' => [
                    [
                        'text' => 'menu.view',
                        'route'  => 'coordenador.relatorio.index',
                        'icon' => 'th-list',
                        'active' => ['coordenador/relatorio/'] // If not set, even if at /curso/novo this item will be .active
                    ],
                    [
                        'text' => 'menu.proposal',
                        'route'  => 'coordenador.relatorio.proposta',
                        'icon' => 'edit',
                        'active' => ['coordenador/relatorio/proposta']
                    ],
                    [
                        'text' => 'menu.bimestral',
                        'route'  => 'coordenador.relatorio.bimestral',
                        'icon' => 'edit',
                        'active' => ['coordenador/relatorio/bimestral']
                    ],
                    [
                        'text' => 'menu.final',
                        'route'  => 'coordenador.relatorio.final',
                        'icon' => 'edit',
                        'active' => ['coordenador/relatorio/final']
                    ],
                ]
            ]
        );
        $event->menu->add('ALUNOS');
        $event->menu->add(
            [
                'text' => 'menu.student',
                'icon' => 'users',
                'submenu' => [
                    [
                        'text' => 'menu.history',
                        'route'  => 'aluno.index',
                        'icon' => 'hourglass-1',
                        'active' => ['aluno/'] // If not set, even if at /curso/novo this item will be .active
                    ],
                ]
            ],
            [
                'text' => 'menu.message',
                'route'  => 'coordenador.mensagem.index',
                'icon' => 'envelope',
                'active' => ['coordenador/mensagem/']
            ]
        );
    }
}
