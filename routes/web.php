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

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', 'RoleController');
    Route::resource('users', 'UserController');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('logs', [
        'middleware' => 'role:admin',
        'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index'
    ])->name('logs');

    Route::prefix('usuario')->name('usuario.')->group(function () {
        Route::get('', 'UserController@index')->name('index');
        Route::get('novo', 'UserController@create')->name('novo');
        Route::post('salvar', 'UserController@store')->name('salvar');
        Route::post('salvarSenha', 'UserController@storePassword')->name('salvarSenha');

        Route::prefix('{id}')->group(function () {
            Route::get('editar', 'UserController@edit')->name('editar');
            Route::get('alterarSenha', 'UserController@changePassword')->name('alterarSenha');
            Route::put('alterar', 'UserController@update')->name('alterar');
        });
    });

    Route::prefix('configuracoes')->name('configuracoes.')->group(function () {
        Route::prefix('parametros')->name('parametros.')->group(function () {
            Route::get('', 'SystemConfigurationController@index')->name('index');
            Route::get('novo', 'SystemConfigurationController@create')->name('novo');
            Route::post('salvar', 'SystemConfigurationController@store')->name('salvar');

            Route::prefix('{id}')->group(function () {
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

        Route::prefix('{id}')->group(function () {
            Route::get('editar', 'CoordinatorController@edit')->name('editar');
            Route::put('alterar', 'CoordinatorController@update')->name('alterar');
        });
    });

    Route::prefix('curso')->name('curso.')->group(function () {
        Route::get('', 'CourseController@index')->name('index');
        Route::get('novo', 'CourseController@create')->name('novo');
        Route::post('salvar', 'CourseController@store')->name('salvar');
        Route::delete('excluir', 'CourseController@delete')->name('excluir');

        Route::prefix('{id}')->group(function () {
            Route::get('', 'CourseController@details')->name('detalhes');
            Route::get('editar', 'CourseController@edit')->name('editar');
            Route::put('alterar', 'CourseController@update')->name('alterar');

            Route::prefix('configuracao')->name('configuracao.')->group(function () {
                Route::get('', 'CourseConfigurationController@index')->name('index');
                Route::get('novo', 'CourseConfigurationController@create')->name('novo');
                Route::post('salvar', 'CourseConfigurationController@store')->name('salvar');

                Route::prefix('{id_config}')->group(function () {
                    Route::get('editar', 'CourseConfigurationController@edit')->name('editar');
                    Route::put('alterar', 'CourseConfigurationController@update')->name('alterar');
                });
            });
        });
    });

    Route::prefix('mensagem')->name('mensagem.')->group(function () {
        Route::get('', 'MessageController@adminIndex')->name('index');
    });
});

Route::prefix('coordenador')->name('coordenador.')->group(function () {
    Route::prefix('empresa')->name('empresa.')->group(function () {
        Route::get('', 'CompanyController@index')->name('index');
        Route::get('novo', 'CompanyController@create')->name('novo');
        Route::post('salvar', 'CompanyController@store')->name('salvar');

        Route::prefix('{id}')->group(function () {
            Route::get('editar', 'CompanyController@edit')->name('editar');
            Route::put('alterar', 'CompanyController@update')->name('alterar');
        });

        Route::prefix('setor')->name('setor.')->group(function () {
            Route::get('', 'SectorController@index')->name('index');
            Route::get('novo', 'SectorController@create')->name('novo');
            Route::post('salvar', 'SectorController@store')->name('salvar');

            Route::prefix('{id}')->group(function () {
                Route::get('editar', 'SectorController@edit')->name('editar');
                Route::put('alterar', 'SectorController@update')->name('alterar');
            });
        });

        Route::prefix('convenio')->name('convenio.')->group(function () {
            Route::get('', 'AgreementController@index')->name('index');
            Route::get('novo', 'AgreementController@create')->name('novo');
            Route::post('salvar', 'AgreementController@store')->name('salvar');

            Route::prefix('{id}')->group(function () {
                Route::get('editar', 'AgreementController@edit')->name('editar');
                Route::put('alterar', 'AgreementController@update')->name('alterar');
            });
        });

        Route::prefix('supervisor')->name('supervisor.')->group(function () {
            Route::get('', 'SupervisorController@index')->name('index');
            Route::get('novo', 'SupervisorController@create')->name('novo');
            Route::post('salvar', 'SupervisorController@store')->name('salvar');

            Route::prefix('{id}')->group(function () {
                Route::get('editar', 'SupervisorController@edit')->name('editar');
                Route::put('alterar', 'SupervisorController@update')->name('alterar');
            });
        });
    });

    Route::prefix('estagio')->name('estagio.')->group(function () {
        Route::get('', 'InternshipController@index')->name('index');
        Route::get('novo', 'InternshipController@create')->name('novo');
        Route::post('salvar', 'InternshipController@store')->name('salvar');

        Route::prefix('{id}')->group(function () {
            Route::get('editar', 'InternshipController@edit')->name('editar');
            Route::put('alterar', 'InternshipController@update')->name('alterar');
        });

        Route::prefix('aditivo')->name('aditivo.')->group(function () {
            Route::get('', 'AditiveController@index')->name('index');
            Route::get('novo', 'AditiveController@create')->name('novo');
            Route::post('salvar', 'AditiveController@store')->name('salvar');
        });
    });

    Route::prefix('relatorio')->name('relatorio.')->group(function () {
        Route::get('', 'ReportController@index')->name('index');
        Route::get('proposta', 'ReportController@proposal')->name('proposta');
        Route::get('bimestral', 'ReportController@bimestral')->name('bimestral');
        Route::get('final', 'ReportController@final')->name('final');
    });

    Route::prefix('mensagem')->name('mensagem.')->group(function () {
        Route::get('', 'MessageController@coordinatorIndex')->name('index');
        Route::get('teste', 'MessageController@sendInternshipProposalMail');
    });
});

Route::prefix('aluno')->name('aluno.')->group(function () {
    Route::get('', 'StudentController@index')->name('index');
});

Route::prefix('ajuda')->name('ajuda.')->group(function () {
    Route::get('', 'HelpController@index')->name('index');
});

Route::prefix('sobre')->name('sobre.')->group(function () {
    Route::get('', 'AboutController@index')->name('index');
});
