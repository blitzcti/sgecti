<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('', function () {
    return view('index');
});

Auth::routes([
    'register' => false, // Registration Routes
    'reset' => true, // Password Reset Routes
    'verify' => false, // Email Verification Routes
]);

Route::get('home', 'HomeController@index')->name('home');
Route::get('notificacoes', 'HomeController@notifications')->name('notificacoes');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', 'RoleController');
    Route::resource('users', 'UserController');
});

Route::get('alterarSenha', 'UserController@changeCUserPassword')->name('alterarSenha');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('logs', [
        'middleware' => 'role:admin',
        'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index'
    ])->name('logs');

    Route::prefix('usuario')->name('usuario.')->group(function () {
        Route::get('', 'UserController@index')->name('index');
        Route::get('novo', 'UserController@create')->name('novo');
        Route::post('salvar', 'UserController@store')->name('salvar');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('editar', 'UserController@edit')->name('editar');
            Route::put('alterar', 'UserController@update')->name('alterar');

            Route::get('alterarSenha', 'UserController@changePassword')->name('alterarSenha');
            Route::put('salvarSenha', 'UserController@savePassword')->name('salvarSenha');
        });
    });

    Route::prefix('configuracao')->name('configuracao.')->group(function () {
        Route::prefix('curso')->name('curso.')->group(function () {
            Route::get('', 'GeneralConfigurationController@index')->name('index');
            Route::get('novo', 'GeneralConfigurationController@create')->name('novo');
            Route::post('salvar', 'GeneralConfigurationController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'GeneralConfigurationController@edit')->name('editar');
                Route::put('alterar', 'GeneralConfigurationController@update')->name('alterar');
            });
        });

        Route::prefix('parametros')->name('parametros.')->group(function () {
            Route::get('', 'SystemConfigurationController@index')->name('index');
            Route::get('novo', 'SystemConfigurationController@create')->name('novo');
            Route::post('salvar', 'SystemConfigurationController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'SystemConfigurationController@edit')->name('editar');
                Route::put('alterar', 'SystemConfigurationController@update')->name('alterar');
            });
        });

        Route::prefix('backup')->name('backup.')->group(function () {
            Route::get('', 'BackupController@index')->name('index');
            Route::get('download', 'BackupController@backup')->name('download');
            Route::post('restaurar', 'BackupController@restore')->name('restaurar');
            Route::post('salvarConfig', 'BackupController@storeConfig')->name('salvarConfig');
        });
    });

    Route::prefix('coordenador')->name('coordenador.')->group(function () {
        Route::get('', 'CoordinatorController@index')->name('index');
        Route::get('novo', 'CoordinatorController@create')->name('novo');
        Route::post('salvar', 'CoordinatorController@store')->name('salvar');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('editar', 'CoordinatorController@edit')->name('editar');
            Route::put('alterar', 'CoordinatorController@update')->name('alterar');
        });
    });

    Route::prefix('curso')->name('curso.')->group(function () {
        Route::get('', 'CourseController@index')->name('index');
        Route::get('novo', 'CourseController@create')->name('novo');
        Route::post('salvar', 'CourseController@store')->name('salvar');
        Route::delete('excluir', 'CourseController@delete')->name('excluir');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'CourseController@details')->name('detalhes');
            Route::get('editar', 'CourseController@edit')->name('editar');
            Route::put('alterar', 'CourseController@update')->name('alterar');

            Route::prefix('coordenador')->name('coordenador.')->group(function () {
                Route::get('', 'CoordinatorController@indexByCourse')->name('index');
            });

            Route::prefix('configuracao')->name('configuracao.')->group(function () {
                Route::get('', 'CourseConfigurationController@index')->name('index');
                Route::get('novo', 'CourseConfigurationController@create')->name('novo');
                Route::post('salvar', 'CourseConfigurationController@store')->name('salvar');

                Route::prefix('{id_config}')->where(['id_config' => '[0-9]+'])->group(function () {
                    Route::get('editar', 'CourseConfigurationController@edit')->name('editar');
                    Route::put('alterar', 'CourseConfigurationController@update')->name('alterar');
                });
            });
        });
    });

    Route::prefix('mensagem')->name('mensagem.')->group(function () {
        Route::get('', 'MessageController@adminIndex')->name('index');
        Route::post('enviar', 'MessageController@sendEmail')->name('enviar');
    });
});

Route::prefix('coordenador')->name('coordenador.')->middleware('auth')->group(function () {
    Route::prefix('empresa')->name('empresa.')->group(function () {
        Route::get('', 'CompanyController@index')->name('index');
        Route::get('novo', 'CompanyController@create')->name('novo');
        Route::post('salvar', 'CompanyController@store')->name('salvar');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'CompanyController@details')->name('detalhes');
            Route::get('editar', 'CompanyController@edit')->name('editar');
            Route::put('alterar', 'CompanyController@update')->name('alterar');

            Route::get('supervisor', 'SupervisorController@indexByCompany')->name('supervisor');
            Route::get('convenio', 'AgreementController@indexByCompany')->name('convenio');
        });

        Route::prefix('setor')->name('setor.')->group(function () {
            Route::get('', 'SectorController@index')->name('index');
            Route::get('novo', 'SectorController@create')->name('novo');
            Route::post('salvar', 'SectorController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'SectorController@edit')->name('editar');
                Route::put('alterar', 'SectorController@update')->name('alterar');
            });
        });

        Route::prefix('convenio')->name('convenio.')->group(function () {
            Route::get('', 'AgreementController@index')->name('index');
            Route::get('novo', 'AgreementController@create')->name('novo');
            Route::post('salvar', 'AgreementController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'AgreementController@edit')->name('editar');
                Route::put('alterar', 'AgreementController@update')->name('alterar');
            });
        });

        Route::prefix('supervisor')->name('supervisor.')->group(function () {
            Route::get('', 'SupervisorController@index')->name('index');
            Route::get('novo', 'SupervisorController@create')->name('novo');
            Route::post('salvar', 'SupervisorController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'SupervisorController@edit')->name('editar');
                Route::put('alterar', 'SupervisorController@update')->name('alterar');
            });
        });
    });

    Route::prefix('estagio')->name('estagio.')->group(function () {
        Route::get('', 'InternshipController@index')->name('index');
        Route::get('novo', 'InternshipController@create')->name('novo');
        Route::post('salvar', 'InternshipController@store')->name('salvar');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'InternshipController@details')->name('detalhes');
            Route::get('editar', 'InternshipController@edit')->name('editar');
            Route::put('alterar', 'InternshipController@update')->name('alterar');
            Route::put('cancelar', 'InternshipController@cancel')->name('cancelar');
            Route::put('reativar', 'InternshipController@reactivate')->name('reativar');

            Route::get('aditivo', 'AmendmentController@indexByInternship')->name('aditivo');
        });

        Route::prefix('aditivo')->name('aditivo.')->group(function () {
            Route::get('', 'AmendmentController@index')->name('index');
            Route::get('novo', 'AmendmentController@create')->name('novo');
            Route::post('salvar', 'AmendmentController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'AmendmentController@edit')->name('editar');
                Route::put('alterar', 'AmendmentController@update')->name('alterar');
            });
        });
    });

    Route::prefix('trabalho')->name('trabalho.')->group(function () {
        Route::get('', 'JobController@index')->name('index');
        Route::get('novo', 'JobController@create')->name('novo');
        Route::post('salvar', 'JobController@store')->name('salvar');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'JobController@details')->name('detalhes');
            Route::get('editar', 'JobController@edit')->name('editar');
            Route::put('alterar', 'JobController@update')->name('alterar');
            Route::put('cancelar', 'JobController@cancel')->name('cancelar');
            Route::put('reativar', 'JobController@reactivate')->name('reativar');
        });

        Route::prefix('empresa')->name('empresa.')->group(function () {
            Route::get('', 'JobCompanyController@index')->name('index');
            Route::get('novo', 'JobCompanyController@create')->name('novo');
            Route::post('salvar', 'JobCompanyController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('', 'JobCompanyController@details')->name('detalhes');
                Route::get('editar', 'JobCompanyController@edit')->name('editar');
                Route::put('alterar', 'JobCompanyController@update')->name('alterar');
            });
        });
    });

    Route::prefix('relatorio')->name('relatorio.')->group(function () {
        Route::get('', 'ReportController@index')->name('index');

        Route::prefix('bimestral')->name('bimestral.')->group(function () {
            Route::get('novo', 'ReportController@createBimestral')->name('novo');
            Route::post('salvar', 'ReportController@storeBimestral')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'ReportController@editBimestral')->name('editar');
                Route::put('alterar', 'ReportController@updateBimestral')->name('alterar');
            });
        });

        Route::prefix('final')->name('final.')->group(function () {
            Route::get('novo', 'ReportController@createFinal')->name('novo');
            Route::post('salvar', 'ReportController@storeFinal')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('editar', 'ReportController@editFinal')->name('editar');
                Route::put('alterar', 'ReportController@updateFinal')->name('alterar');
                Route::get('pdf', 'ReportController@pdfFinal')->name('pdf');
            });
        });
    });

    Route::prefix('mensagem')->name('mensagem.')->group(function () {
        Route::get('', 'MessageController@coordinatorIndex')->name('index');
        Route::post('enviar', 'MessageController@sendEmail')->name('enviar');
    });

    Route::prefix('aluno')->name('aluno.')->group(function () {
        Route::get('', 'StudentController@index')->name('index');
        Route::get('pdf', 'StudentController@pdf')->name('pdf');
        Route::post('gerarPDF', 'StudentController@makePDF')->name('gerarPDF');

        Route::prefix('{ra}')->where(['ra' => '[0-9]+'])->group(function () {
            Route::get('', 'StudentController@details')->name('detalhes');
        });
    });
});

Route::prefix('aluno')->name('aluno.')->middleware('auth')->group(function () {

});

Route::prefix('empresa')->name('empresa.')->middleware('auth')->group(function () {
    Route::prefix('proposta')->name('proposta.')->group(function () {
        Route::get('', 'Company\ProposalController@index')->name('index');
        Route::get('novo', 'Company\ProposalController@create')->name('novo');
        Route::post('salvar', 'Company\ProposalController@store')->name('salvar');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'Company\ProposalController@details')->name('detalhes');
            Route::get('editar', 'Company\ProposalController@edit')->name('editar');
            Route::put('alterar', 'Company\ProposalController@update')->name('alterar');
        });
    });
});

Route::prefix('ajuda')->name('ajuda.')->group(function () {
    Route::get('', 'HelpController@index')->name('index');
});

Route::prefix('sobre')->name('sobre.')->group(function () {
    Route::get('', 'AboutController@index')->name('index');
});
