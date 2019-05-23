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
        Route::get('novo', 'UserController@new')->name('novo');
        Route::post('salvar', 'UserController@save')->name('salvar');
        Route::post('salvarSenha', 'UserController@savePassword')->name('salvarSenha');

        Route::prefix('{id}')->group(function () {
            Route::get('editar', 'UserController@edit')->name('editar');
            Route::get('alterarSenha', 'UserController@changePassword')->name('alterarSenha');
        });
    });

    Route::prefix('configuracoes')->name('configuracoes.')->group(function () {
        Route::prefix('parametros')->name('parametros.')->group(function () {
            Route::get('', 'SystemConfigurationController@index')->name('index');
            Route::get('novo', 'SystemConfigurationController@new')->name('novo');
            Route::post('salvar', 'SystemConfigurationController@save')->name('salvar');

            Route::prefix('{id}')->group(function () {
                Route::get('editar', 'SystemConfigurationController@edit')->name('editar');
            });
        });

        Route::prefix('backup')->name('backup.')->group(function () {
            Route::get('', 'BackupController@index')->name('index');
            Route::get('download', 'BackupController@backup')->name('download');
            Route::post('restaurar', 'BackupController@restore')->name('restaurar');
        });
    });

    Route::prefix('coordenador')->name('coordenador.')->group(function () {
        Route::get('', 'CoordinatorController@index')->name('index');
        Route::get('novo', 'CoordinatorController@new')->name('novo');
        Route::post('salvar', 'CoordinatorController@save')->name('salvar');

        Route::prefix('{id}')->group(function () {
            Route::get('editar', 'CoordinatorController@edit')->name('editar');
        });
    });

    Route::prefix('curso')->name('curso.')->group(function () {
        Route::get('', 'CourseController@index')->name('index');
        Route::get('novo', 'CourseController@new')->name('novo');
        Route::post('salvar', 'CourseController@save')->name('salvar');
        Route::post('excluir', 'CourseController@delete')->name('excluir');

        Route::prefix('{id}')->group(function () {
            Route::get('', 'CourseController@details')->name('detalhes');
            Route::get('editar', 'CourseController@edit')->name('editar');

            Route::prefix('configuracao')->name('configuracao.')->group(function () {
                Route::get('', 'CourseConfigurationController@index')->name('index');
                Route::get('novo', 'CourseConfigurationController@new')->name('novo');
                Route::post('salvar', 'CourseConfigurationController@save')->name('salvar');

                Route::prefix('{id_config}')->group(function () {
                    Route::get('editar', 'CourseConfigurationController@edit')->name('editar');
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
        Route::get('novo', 'CompanyController@new')->name('novo');
        Route::post('salvar', 'CompanyController@save')->name('salvar');

        Route::prefix('{id}')->group(function () {
            Route::get('editar', 'CompanyController@edit')->name('editar');
        });

        Route::prefix('setor')->name('setor.')->group(function () {
            Route::get('', 'SectorController@index')->name('index');
            Route::get('getAjax', 'SectorController@getAjax')->name('getAjax');
            Route::get('novo', 'SectorController@new')->name('novo');
            Route::post('salvar', 'SectorController@save')->name('salvar');
            Route::post('salvarAjax', 'SectorController@saveAjax')->name('salvarAjax');

            Route::prefix('{id}')->group(function () {
                Route::get('editar', 'SectorController@edit')->name('editar');
            });
        });
    });

    Route::prefix('estagio')->name('estagio.')->group(function () {
        Route::get('', 'InternshipController@index')->name('index');
        Route::get('novo', 'InternshipController@new')->name('novo');
        Route::get('ctps', 'InternshipController@ctps')->name('ctps');

        Route::prefix('aditivo')->name('aditivo.')->group(function () {
            Route::get('', 'AditiveController@index')->name('index');
            Route::get('novo', 'AditiveController@new')->name('novo');
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
    });
});

Route::prefix('aluno')->name('aluno.')->group(function () {
    Route::get('', 'StudentController@index')->name('index');
});

Route::prefix('ajuda')->name('ajuda.')->group(function () {
    Route::get('', 'HelpController@index')->name('index');
});