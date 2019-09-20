<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', 'HomeController@frontPage');

Auth::routes([
    'register' => false, // Registration Routes
    'reset' => true, // Password Reset Routes
    'verify' => false, // Email Verification Routes
]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('notificacoes', 'HomeController@notifications')->name('notificacoes');
});

Route::prefix('usuario')->name('usuario.')->middleware('auth')->group(function () {
    Route::get('alterarSenha', 'UserController@changeUserPassword')->name('alterarSenha');
    Route::put('salvarSenha', 'UserController@savePassword')->name('salvarSenha');
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('logs', [
        'middleware' => 'role:admin',
        'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index'
    ])->name('logs');

    Route::prefix('usuario')->name('usuario.')->group(function () {
        Route::get('', 'Admin\UserController@index')->name('index');
        Route::get('novo', 'Admin\UserController@create')->name('novo');
        Route::post('', 'Admin\UserController@store')->name('salvar');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('editar', 'Admin\UserController@edit')->name('editar');
            Route::put('', 'Admin\UserController@update')->name('alterar');

            Route::get('alterarSenha', 'Admin\UserController@changePassword')->name('alterarSenha');
            Route::put('salvarSenha', 'Admin\UserController@savePassword')->name('salvarSenha');
        });
    });

    Route::prefix('configuracao')->name('configuracao.')->group(function () {
        Route::prefix('curso')->name('curso.')->group(function () {
            Route::get('', 'Admin\GeneralConfigurationController@index')->name('index');
            Route::get('novo', 'Admin\GeneralConfigurationController@create')->name('novo');
            Route::post('', 'Admin\GeneralConfigurationController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'Admin\GeneralConfigurationController@edit')->name('editar');
                Route::put('', 'Admin\GeneralConfigurationController@update')->name('alterar');
            });
        });

        Route::prefix('parametros')->name('parametros.')->group(function () {
            Route::get('', 'Admin\SystemConfigurationController@index')->name('index');
            Route::get('novo', 'Admin\SystemConfigurationController@create')->name('novo');
            Route::post('', 'Admin\SystemConfigurationController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'Admin\SystemConfigurationController@edit')->name('editar');
                Route::put('', 'Admin\SystemConfigurationController@update')->name('alterar');
            });
        });

        Route::prefix('backup')->name('backup.')->group(function () {
            Route::get('', 'Admin\BackupController@index')->name('index');
            Route::get('download', 'Admin\BackupController@backup')->name('download');
            Route::post('restaurar', 'Admin\BackupController@restore')->name('restaurar');
            Route::post('salvarConfig', 'Admin\BackupController@storeConfig')->name('salvarConfig');
        });
    });

    Route::prefix('coordenador')->name('coordenador.')->group(function () {
        Route::get('', 'Admin\CoordinatorController@index')->name('index');
        Route::get('novo', 'Admin\CoordinatorController@create')->name('novo');
        Route::post('', 'Admin\CoordinatorController@store')->name('salvar');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('editar', 'Admin\CoordinatorController@edit')->name('editar');
            Route::put('', 'Admin\CoordinatorController@update')->name('alterar');
        });
    });

    Route::prefix('curso')->name('curso.')->group(function () {
        Route::get('', 'Admin\CourseController@index')->name('index');
        Route::get('novo', 'Admin\CourseController@create')->name('novo');
        Route::post('', 'Admin\CourseController@store')->name('salvar');
        Route::delete('excluir', 'Admin\CourseController@delete')->name('excluir');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'Admin\CourseController@show')->name('detalhes');
            Route::get('editar', 'Admin\CourseController@edit')->name('editar');
            Route::put('', 'Admin\CourseController@update')->name('alterar');

            Route::get('coordenador', 'Admin\CoordinatorController@indexByCourse')->name('coordenador');

            Route::prefix('configuracao')->name('configuracao.')->group(function () {
                Route::get('', 'Admin\CourseConfigurationController@index')->name('index');
                Route::get('novo', 'Admin\CourseConfigurationController@create')->name('novo');
                Route::post('', 'Admin\CourseConfigurationController@store')->name('salvar');

                Route::prefix('{id_config}')->where(['id_config' => '[0-9]+'])->group(function () {
                    Route::get('editar', 'Admin\CourseConfigurationController@edit')->name('editar');
                    Route::put('', 'Admin\CourseConfigurationController@update')->name('alterar');
                });
            });
        });
    });

    Route::prefix('mensagem')->name('mensagem.')->group(function () {
        Route::get('', 'Admin\MessageController@index')->name('index');
        Route::post('enviar', 'Admin\MessageController@sendEmail')->name('enviar');
    });
});

Route::prefix('coordenador')->name('coordenador.')->middleware('auth')->group(function () {
    Route::prefix('empresa')->name('empresa.')->group(function () {
        Route::get('', 'Coordinator\CompanyController@index')->name('index');
        Route::get('novo', 'Coordinator\CompanyController@create')->name('novo');
        Route::post('', 'Coordinator\CompanyController@store')->name('salvar');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'Coordinator\CompanyController@show')->name('detalhes');
            Route::get('editar', 'Coordinator\CompanyController@edit')->name('editar');
            Route::put('', 'Coordinator\CompanyController@update')->name('alterar');

            Route::get('supervisor', 'Coordinator\SupervisorController@indexByCompany')->name('supervisor');
            Route::get('convenio', 'Coordinator\AgreementController@indexByCompany')->name('convenio');

            Route::get('pdf', 'Coordinator\CompanyController@pdf')->name('pdf');
        });

        Route::prefix('setor')->name('setor.')->group(function () {
            Route::get('', 'Coordinator\SectorController@index')->name('index');
            Route::get('novo', 'Coordinator\SectorController@create')->name('novo');
            Route::post('', 'Coordinator\SectorController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'Coordinator\SectorController@edit')->name('editar');
                Route::put('', 'Coordinator\SectorController@update')->name('alterar');
            });
        });

        Route::prefix('convenio')->name('convenio.')->group(function () {
            Route::get('', 'Coordinator\AgreementController@index')->name('index');
            Route::get('novo', 'Coordinator\AgreementController@create')->name('novo');
            Route::post('', 'Coordinator\AgreementController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'Coordinator\AgreementController@edit')->name('editar');
                Route::put('', 'Coordinator\AgreementController@update')->name('alterar');
                Route::put('cancelar', 'Coordinator\AgreementController@cancel')->name('cancelar');
                Route::put('reativar', 'Coordinator\AgreementController@reactivate')->name('reativar');
            });
        });

        Route::prefix('supervisor')->name('supervisor.')->group(function () {
            Route::get('', 'Coordinator\SupervisorController@index')->name('index');
            Route::get('novo', 'Coordinator\SupervisorController@create')->name('novo');
            Route::post('', 'Coordinator\SupervisorController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'Coordinator\SupervisorController@edit')->name('editar');
                Route::put('', 'Coordinator\SupervisorController@update')->name('alterar');
            });
        });
    });

    Route::prefix('estagio')->name('estagio.')->group(function () {
        Route::get('', 'Coordinator\InternshipController@index')->name('index');
        Route::get('novo', 'Coordinator\InternshipController@create')->name('novo');
        Route::post('', 'Coordinator\InternshipController@store')->name('salvar');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'Coordinator\InternshipController@show')->name('detalhes');
            Route::get('editar', 'Coordinator\InternshipController@edit')->name('editar');
            Route::put('', 'Coordinator\InternshipController@update')->name('alterar');
            Route::put('cancelar', 'Coordinator\InternshipController@cancel')->name('cancelar');
            Route::put('reativar', 'Coordinator\InternshipController@reactivate')->name('reativar');

            Route::get('aditivo', 'Coordinator\AmendmentController@indexByInternship')->name('aditivo');
        });

        Route::prefix('aditivo')->name('aditivo.')->group(function () {
            Route::get('', 'Coordinator\AmendmentController@index')->name('index');
            Route::get('novo', 'Coordinator\AmendmentController@create')->name('novo');
            Route::post('', 'Coordinator\AmendmentController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'Coordinator\AmendmentController@edit')->name('editar');
                Route::put('', 'Coordinator\AmendmentController@update')->name('alterar');
            });
        });
    });

    Route::prefix('trabalho')->name('trabalho.')->group(function () {
        Route::get('', 'Coordinator\JobController@index')->name('index');
        Route::get('novo', 'Coordinator\JobController@create')->name('novo');
        Route::post('', 'Coordinator\JobController@store')->name('salvar');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'Coordinator\JobController@show')->name('detalhes');
            Route::get('editar', 'Coordinator\JobController@edit')->name('editar');
            Route::put('', 'Coordinator\JobController@update')->name('alterar');
            Route::put('cancelar', 'Coordinator\JobController@cancel')->name('cancelar');
            Route::put('reativar', 'Coordinator\JobController@reactivate')->name('reativar');
        });

        Route::prefix('empresa')->name('empresa.')->group(function () {
            Route::get('', 'Coordinator\JobCompanyController@index')->name('index');
            Route::get('novo', 'Coordinator\JobCompanyController@create')->name('novo');
            Route::post('', 'Coordinator\JobCompanyController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('', 'Coordinator\JobCompanyController@show')->name('detalhes');
                Route::get('editar', 'Coordinator\JobCompanyController@edit')->name('editar');
                Route::put('', 'Coordinator\JobCompanyController@update')->name('alterar');
            });
        });
    });

    Route::prefix('relatorio')->name('relatorio.')->group(function () {
        Route::get('', 'Coordinator\ReportController@index')->name('index');

        Route::prefix('bimestral')->name('bimestral.')->group(function () {
            Route::get('novo', 'Coordinator\ReportController@createBimestral')->name('novo');
            Route::post('', 'Coordinator\ReportController@storeBimestral')->name('salvar');
            Route::post('pdf', 'Coordinator\ReportController@pdfBimestral')->name('pdf');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'Coordinator\ReportController@editBimestral')->name('editar');
                Route::put('', 'Coordinator\ReportController@updateBimestral')->name('alterar');
            });
        });

        Route::prefix('final')->name('final.')->group(function () {
            Route::get('novo', 'Coordinator\ReportController@createFinal')->name('novo');
            Route::post('', 'Coordinator\ReportController@storeFinal')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'Coordinator\ReportController@editFinal')->name('editar');
                Route::put('', 'Coordinator\ReportController@updateFinal')->name('alterar');
                Route::get('pdf', 'Coordinator\ReportController@pdfFinal')->name('pdf');
            });
        });
    });

    Route::prefix('mensagem')->name('mensagem.')->group(function () {
        Route::get('', 'Coordinator\MessageController@index')->name('index');
        Route::post('enviar', 'Coordinator\MessageController@sendEmail')->name('enviar');
    });

    Route::prefix('aluno')->name('aluno.')->group(function () {
        Route::get('', 'Coordinator\StudentController@index')->name('index');
        Route::get('pdf', 'Coordinator\StudentController@pdf')->name('pdf');
        Route::post('gerarPDF', 'Coordinator\StudentController@makePDF')->name('gerarPDF');

        Route::prefix('{ra}')->where(['ra' => '[0-9]+'])->group(function () {
            Route::get('', 'Coordinator\StudentController@show')->name('detalhes');
        });
    });

    Route::prefix('proposta')->name('proposta.')->group(function () {
        Route::get('', 'Coordinator\ProposalController@index')->name('index');
        Route::get('novo', 'Coordinator\ProposalController@create')->name('novo');
        Route::post('', 'Coordinator\ProposalController@store')->name('salvar');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'Coordinator\ProposalController@show')->name('detalhes');
            Route::get('editar', 'Coordinator\ProposalController@edit')->name('editar');
            Route::put('', 'Coordinator\ProposalController@update')->name('alterar');
            Route::put('aprovar', 'Coordinator\ProposalController@approve')->name('aprovar');
            Route::delete('', 'Coordinator\ProposalController@delete')->name('excluir');
        });
    });
});

Route::prefix('aluno')->name('aluno.')->middleware('auth')->group(function () {
    Route::prefix('proposta')->name('proposta.')->group(function () {
        Route::get('', 'Student\ProposalController@index')->name('index');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'Student\ProposalController@show')->name('detalhes');
        });
    });

    Route::prefix('documento')->name('documento.')->group(function () {
        Route::get('', 'Student\DocumentController@index')->name('index');
    });
});

Route::prefix('empresa')->name('empresa.')->middleware('auth')->group(function () {
    Route::prefix('proposta')->name('proposta.')->group(function () {
        Route::get('', 'Company\ProposalController@index')->name('index');
        Route::get('novo', 'Company\ProposalController@create')->name('novo');
        Route::post('', 'Company\ProposalController@store')->name('salvar');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'Company\ProposalController@show')->name('detalhes');
            Route::get('editar', 'Company\ProposalController@edit')->name('editar');
            Route::put('', 'Company\ProposalController@update')->name('alterar');
            Route::delete('', 'Company\ProposalController@delete')->name('excluir');
        });
    });
});

Route::prefix('ajuda')->name('ajuda.')->group(function () {
    Route::get('', 'HelpController@index')->name('index');
});

Route::prefix('sobre')->name('sobre.')->group(function () {
    Route::get('', 'AboutController@index')->name('index');
});
