<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('')->name('api.')->group(function () {
    Route::prefix('usuario')->name('usuario.')->group(function () {
        Route::prefix('notificacao')->name('notificacao.')->group(function () {
            Route::prefix('{id}')->group(function () {
                Route::put('lida', 'API\NotificationController@markAsSeen')->name('lida');
            });
        });
    });

    Route::prefix('external')->name('external.')->group(function () {
        Route::get('ufs', 'API\ExternalAPISController@getUFS')->name('ufs');
        Route::get('cities/{uf}', 'API\ExternalAPISController@getCities')->name('cities');
        Route::get('cep/{cep}', 'API\ExternalAPISController@getAddress')->name('cep');
        Route::get('cnpj/{cnpj}', 'API\ExternalAPISController@getCompanyInfo')->name('cnpj');
    });

    Route::prefix('aluno')->name('aluno.')->group(function () {
        Route::get('', 'API\NSac\StudentController@get')->name('get');
        Route::get('ano/{year}', 'API\NSac\StudentController@getByYear')->name('getByYear');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'API\NSac\StudentController@getByRA')->name('getByRA');
        });
    });

    Route::prefix('empresa')->name('empresa.')->group(function () {
        Route::get('', 'API\CompanyController@get')->name('get');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'API\CompanyController@getById')->name('getById');

            Route::prefix('setor')->name('setor.')->group(function () {
                Route::get('', 'API\SectorController@getFromCompany')->name('getFromCompany');
            });

            Route::prefix('supervisor')->name('supervisor.')->group(function () {
                Route::get('', 'API\SupervisorController@getFromCompany')->name('getFromCompany');
            });
        });

        Route::prefix('setor')->name('setor.')->group(function () {
            Route::get('', 'API\SectorController@get')->name('get');
            Route::post('salvar', 'API\SectorController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('', 'API\SectorController@getById')->name('getById');
                Route::put('alterar', 'SectorController@update')->name('alterar');
            });
        });

        Route::prefix('supervisor')->name('supervisor.')->group(function () {
            Route::get('', 'API\SupervisorController@get')->name('get');
            Route::post('salvar', 'API\SupervisorController@store')->name('salvar');

            Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
                Route::get('', 'API\SupervisorController@getById')->name('getById');
                Route::put('alterar', 'SupervisorController@update')->name('alterar');
            });
        });
    });

    Route::prefix('estagio')->name('estagio.')->group(function () {
        Route::get('', 'API\InternshipController@get')->name('get');

        Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
            Route::get('', 'API\InternshipController@getById')->name('getById');
        });

        Route::prefix('ra')->group(function () {
            Route::get('{ra}', 'API\InternshipController@getByRA')->name('getByRA');
        });
    });
});
