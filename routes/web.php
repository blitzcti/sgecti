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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('usuario')->name( 'usuario.')->group(function () {
        Route::get('', 'UserController@index')->name('index');
        Route::get('novo', 'UserController@new')->name('novo');
        Route::get('detalhes', 'UserController@new')->name('detalhes');
        Route::get('editar', 'UserController@new')->name('editar');
    });

    Route::prefix('grupo')->name( 'grupo.')->group(function () {
        Route::get('', 'UserGroupController@index')->name('index');
        Route::get('novo', 'UserGroupController@new')->name('novo');
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

    Route::prefix('empresa')->name('empresa.')->group(function () {
        Route::get('', 'CourseController@index')->name('index');
        Route::get('novo', 'CourseController@new')->name('novo');
    });
});
