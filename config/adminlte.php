<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'SGE CTI',

    'title_prefix' => '',

    'title_postfix' => ' - SGE CTI',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>SGE</b> CTI',

    'logo_mini' => '<b>S</b>GE',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | light variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'blue',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => 'fixed',

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we have the option to enable a right sidebar.
    | When active, you can use @section('right-sidebar')
    | The icon you configured will be displayed at the end of the top menu,
    | and will show/hide de sidebar.
    | The slide option will slide the sidebar over the content, while false
    | will push the content, and have no animation.
    | You can also choose the sidebar theme (dark or light).
    | The right Sidebar can only be used if layout is not top-nav.
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs.
    | This was automatically set on install, only change if you really need.
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => null,

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and a URL. You can also specify an icon from Font
    | Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    */

    'menu' => [
        ['header' => 'user'],
        [
            'text' => 'changePassword',
            'route' => 'usuario.senha.editar',
            'icon' => 'lock',
            'active' => ['usuario/senha'],
        ],

        ['header' => 'system'],
        [
            'text' => 'configuration',
            'icon' => 'gear',
            'role' => 'admin',
            'submenu' => [
                [
                    'text' => 'courseConfig',
                    'route' => 'admin.configuracao.curso.index',
                    'icon' => 'wrench',
                    'active' => ['admin/configuracao/curso', 'admin/configuracao/curso/novo'],
                    'can' => 'generalConfiguration-list',
                ],
                [
                    'text' => 'configurations',
                    'route' => 'admin.configuracao.parametros.index',
                    'icon' => 'wrench',
                    'active' => ['admin/configuracao/parametros'],
                    'can' => 'systemConfiguration-list',
                ],
                [
                    'text' => 'backup',
                    'route' => 'admin.configuracao.backup.index',
                    'icon' => 'floppy-o',
                    'active' => ['admin/configuracao/backup'],
                    'can' => 'db-backup',
                ],
            ],
        ],
        [
            'text' => 'sso',
            'icon' => 'server',
            'url' => env('SSO_SERVER_URL', 'http://127.0.0.1') . '/home',
            'sso' => true,
            'role' => 'admin',
        ],
        [
            'text' => 'users',
            'icon' => 'user',
            'can' => 'user-list',
            'sso' => false,
            'submenu' => [
                [
                    'text' => 'view',
                    'route' => 'admin.usuario.index',
                    'icon' => 'th-list',
                    'active' => ['admin/usuario'],
                ],
                [
                    'text' => 'new',
                    'route' => 'admin.usuario.novo',
                    'icon' => 'edit',
                    'active' => ['admin/usuario/novo'],
                ],
            ]
        ],
        [
            'text' => 'message',
            'route' => 'admin.mensagem.index',
            'icon' => 'envelope',
            'active' => ['admin/mensagem'],
            'role' => 'admin',
        ],
        [
            'text' => 'message',
            'route' => 'coordenador.mensagem.index',
            'icon' => 'envelope',
            'active' => ['coordenador/mensagem', 'coordenador/mensagem*'],
            'role' => 'coordinator',
        ],
        [
            'text' => 'logs',
            'icon' => 'calendar',
            'route' => 'admin.logs',
            'active' => ['admin/logs*'],
            'role' => 'admin',
        ],
        [
            'text' => 'help',
            'route' => 'ajuda.index',
            'icon' => 'question-circle',
            'active' => ['ajuda'],
        ],
        [
            'text' => 'about',
            'route' => 'sobre.index',
            'icon' => 'bolt',
            'active' => ['sobre'],
        ],

        ['header' => 'administration', 'role' => 'admin'],
        [
            'text' => 'courses',
            'icon' => 'institution',
            'role' => 'admin',
            'submenu' => [
                [
                    'text' => 'view',
                    'route' => 'admin.curso.index',
                    'icon' => 'th-list',
                    'active' => ['admin/curso'],
                    'can' => 'course-list',
                ],
                [
                    'text' => 'new',
                    'route' => 'admin.curso.novo',
                    'icon' => 'edit',
                    'active' => ['admin/curso/novo'],
                    'can' => 'course-create',
                ],
            ],
        ],
        [
            'text' => 'coordinators',
            'icon' => 'black-tie',
            'role' => 'admin',
            'submenu' => [
                [
                    'text' => 'view',
                    'route' => 'admin.coordenador.index',
                    'icon' => 'th-list',
                    'active' => ['admin/coordenador', 'admin/curso/*/coordenador'],
                    'can' => 'coordinator-list',
                ],
                [
                    'text' => 'new',
                    'route' => 'admin.coordenador.novo',
                    'icon' => 'edit',
                    'active' => ['admin/coordenador/novo*'],
                    'can' => 'coordinator-create',
                ],
            ],
        ],

        ['header' => 'secretary', 'role' => 'admin'],
        [
            'text' => 'graduation',
            'route' => 'admin.colacao.index',
            'icon' => 'graduation-cap',
            'active' => ['admin/colacao'],
            'can' => 'graduation-list',
        ],


        ['header' => 'COORDENAÇÃO DE ESTÁGIO', 'role' => 'coordinator'],
        [
            'text' => 'companies',
            'icon' => 'building',
            'role' => 'coordinator',
            'submenu' => [
                [
                    'text' => 'view',
                    'route' => 'coordenador.empresa.index',
                    'icon' => 'th-list',
                    'active' => ['coordenador/empresa'],
                    'can' => 'company-list',
                ],
                [
                    'text' => 'new',
                    'route' => 'coordenador.empresa.novo',
                    'icon' => 'edit',
                    'active' => ['coordenador/empresa/novo'],
                    'can' => 'company-create',
                ],
                [
                    'text' => 'sectors',
                    'icon' => 'balance-scale',
                    'submenu' => [
                        [
                            'text' => 'view',
                            'route' => 'coordenador.empresa.setor.index',
                            'icon' => 'th-list',
                            'active' => ['coordenador/empresa/setor'],
                            'can' => 'companySector-list',
                        ],
                        [
                            'text' => 'new',
                            'route' => 'coordenador.empresa.setor.novo',
                            'icon' => 'edit',
                            'active' => ['coordenador/empresa/setor/novo'],
                            'can' => 'companySector-create',
                        ]
                    ]
                ],
                [
                    'text' => 'supervisors',
                    'icon' => 'user',
                    'submenu' => [
                        [
                            'text' => 'view',
                            'route' => 'coordenador.empresa.supervisor.index',
                            'icon' => 'th-list',
                            'active' => ['coordenador/empresa/supervisor', 'coordenador/empresa/*/supervisor'],
                            'can' => 'companySupervisor-list',
                        ],
                        [
                            'text' => 'new',
                            'route' => 'coordenador.empresa.supervisor.novo',
                            'icon' => 'edit',
                            'active' => ['coordenador/empresa/supervisor/novo*'],
                            'can' => 'companySupervisor-create',
                        ],
                    ]
                ],
                [
                    'text' => 'agreements',
                    'icon' => 'exchange',
                    'submenu' => [
                        [
                            'text' => 'view',
                            'route' => 'coordenador.empresa.convenio.index',
                            'icon' => 'th-list',
                            'active' => ['coordenador/empresa/convenio', 'coordenador/empresa/*/convenio'],
                            'can' => 'companyAgreement-list',
                        ],
                        [
                            'text' => 'new',
                            'route' => 'coordenador.empresa.convenio.novo',
                            'icon' => 'edit',
                            'active' => ['coordenador/empresa/convenio/novo*'],
                            'can' => 'companyAgreement-create',
                        ],
                    ],
                ],
            ],
        ],
        [
            'text' => 'internships',
            'icon' => 'id-badge',
            'role' => 'coordinator',
            'submenu' => [
                [
                    'text' => 'view',
                    'route' => 'coordenador.estagio.index',
                    'icon' => 'th-list',
                    'active' => ['coordenador/estagio'],
                    'can' => 'internship-list',
                ],
                [
                    'text' => 'new',
                    'route' => 'coordenador.estagio.novo',
                    'icon' => 'edit',
                    'active' => ['coordenador/estagio/novo*'],
                    'can' => 'internship-create',
                ],
                [
                    'text' => 'amendments',
                    'icon' => 'plus',
                    'submenu' => [
                        [
                            'text' => 'view',
                            'route' => 'coordenador.estagio.aditivo.index',
                            'icon' => 'th-list',
                            'active' => ['coordenador/estagio/aditivo', 'coordenador/estagio/*/aditivo'],
                            'can' => 'internshipAmendment-list',
                        ],
                        [
                            'text' => 'new',
                            'route' => 'coordenador.estagio.aditivo.novo',
                            'icon' => 'edit',
                            'active' => ['coordenador/estagio/aditivo/novo*'],
                            'can' => 'internshipAmendment-create',
                        ],
                    ],
                ],
            ],
        ],
        [
            'text' => 'jobs',
            'icon' => 'briefcase',
            'role' => 'coordinator',
            'submenu' => [
                [
                    'text' => 'view',
                    'route' => 'coordenador.trabalho.index',
                    'icon' => 'th-list',
                    'active' => ['coordenador/trabalho'],
                    'can' => 'job-list',
                ],
                [
                    'text' => 'new',
                    'route' => 'coordenador.trabalho.novo',
                    'icon' => 'edit',
                    'active' => ['coordenador/trabalho/novo*'],
                    'can' => 'job-create',
                ],
                [
                    'text' => 'companies',
                    'icon' => 'building',
                    'submenu' => [
                        [
                            'text' => 'view',
                            'route' => 'coordenador.trabalho.empresa.index',
                            'icon' => 'th-list',
                            'active' => ['coordenador/trabalho/empresa'],
                            'can' => 'jobCompany-list',
                        ],
                        [
                            'text' => 'new',
                            'route' => 'coordenador.trabalho.empresa.novo',
                            'icon' => 'edit',
                            'active' => ['coordenador/trabalho/empresa/novo'],
                            'can' => 'jobCompany-create',
                        ],
                    ],
                ]
            ],
        ],
        [
            'text' => 'reports',
            'icon' => 'book',
            'role' => 'coordinator',
            'submenu' => [
                [
                    'text' => 'view',
                    'route' => 'coordenador.relatorio.index',
                    'icon' => 'th-list',
                    'active' => ['coordenador/relatorio'],
                    'can' => 'report-list',
                ],
                [
                    'text' => 'bimestral',
                    'route' => 'coordenador.relatorio.bimestral.novo',
                    'icon' => 'edit',
                    'active' => ['coordenador/relatorio/bimestral/novo*'],
                    'can' => 'report-create',
                ],
                [
                    'text' => 'final',
                    'route' => 'coordenador.relatorio.final.novo',
                    'icon' => 'edit',
                    'active' => ['coordenador/relatorio/final/novo*'],
                    'can' => 'report-create',
                ],
            ]
        ],

        ['header' => 'EMPRESAS', 'role' => 'coordinator'],
        [
            'text' => 'proposals',
            'icon' => 'bullhorn',
            'role' => 'coordinator',
            'submenu' => [
                [
                    'text' => 'view',
                    'route' => 'coordenador.proposta.index',
                    'icon' => 'th-list',
                    'active' => ['coordenador/proposta'],
                    'can' => 'proposal-list',
                ],
                [
                    'text' => 'new',
                    'route' => 'coordenador.proposta.novo',
                    'icon' => 'edit',
                    'active' => ['coordenador/proposta/novo'],
                    'can' => 'proposal-create',
                ],
            ],
        ],

        ['header' => 'ALUNOS', 'role' => 'coordinator'],
        [
            'text' => 'students',
            'icon' => 'users',
            'role' => 'coordinator',
            'submenu' => [
                [
                    'text' => 'data',
                    'route' => 'coordenador.aluno.index',
                    'icon' => 'file-text-o',
                    'active' => ['coordenador/aluno'],
                    'can' => 'student-list',
                ],
                [
                    'text' => 'pdf',
                    'route' => 'coordenador.aluno.pdf',
                    'icon' => 'file-pdf-o',
                    'active' => ['coordenador/aluno/pdf'],
                    'can' => 'student-list',
                ],
            ]
        ],


        ['header' => 'ESTÁGIO', 'role' => 'company'],
        [
            'text' => 'proposals',
            'icon' => 'bullhorn',
            'role' => 'company',
            'submenu' => [
                [
                    'text' => 'view',
                    'route' => 'empresa.proposta.index',
                    'icon' => 'th-list',
                    'active' => ['empresa/proposta'],
                    'can' => 'proposal-list',
                ],
                [
                    'text' => 'new',
                    'route' => 'empresa.proposta.novo',
                    'icon' => 'edit',
                    'active' => ['empresa/proposta/novo'],
                    'can' => 'proposal-create',
                ],
            ],
        ],


        ['header' => 'ESTÁGIOS', 'role' => 'student'],
        [
            'text' => 'proposals',
            'icon' => 'bullhorn',
            'route' => 'aluno.proposta.index',
            'active' => ['aluno/proposta'],
            'role' => 'student',
            'can' => 'proposal-list',
        ],

        ['header' => 'DOCUMENTOS', 'role' => 'student'],
        [
            'text' => 'documentation',
            'route' => 'aluno.documento.index',
            'icon' => 'book',
            'active' => ['aluno/documento'],
            'role' => 'student',
            'can' => 'documents-list',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        App\AdminLTE\LangFilter::class,
        App\AdminLTE\RoleFilter::class,
        App\AdminLTE\SSOFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Configure which JavaScript plugins should be included. At this moment,
    | DataTables, Select2, Chartjs and SweetAlert are added out-of-the-box,
    | including the Javascript and CSS files from a CDN via script and link tag.
    | Plugin Name, active status and files array (even empty) are required.
    | Files, when added, need to have type (js or css), asset (true or false) and location (string).
    | When asset is set to true, the location will be output using asset() function.
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css',
                ],

                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js',
                ],

                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js',
                ],
            ],
        ],
        [
            'name' => 'Datatables.responsive',
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/responsive/2.2.2/css/responsive.bootstrap.min.css',
                ],

                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/responsive/2.2.2/js/responsive.bootstrap.min.js',
                ],
            ],
        ],
        [
            'name' => 'Select2',
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/i18n/pt-BR.js',
                ],
            ],
        ],
        [
            'name' => 'Chartjs',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'wysihtml5',
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.all.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/locales/bootstrap-wysihtml5.pt-BR.min.js',
                ],
            ]
        ],
        [
            'name' => 'inputmask',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js',
                ]
            ]
        ],
        [
            'name' => 'iCheck',
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/all.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js',
                ]
            ]
        ],
        [
            'name' => 'Sweetalert2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        [
            'name' => 'Pace',
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-minimal.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],
];
