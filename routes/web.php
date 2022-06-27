<?php

use App\Http\Controllers\UserController;
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

// user Register
Route::get('/user', 'registerController@create')->name('user.create');
Route::post('/user', 'registerController@store')->name('user.store');

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['middleware' => 'permission:form-pembuatan'], function (){
        Route::get('/form-pembuatan', 'formPembuatanController@index')->name('form-pembuatan.index');
        Route::get('/form-pembuatan/create', 'formPembuatanController@create')->name('form-pembuatan.create');
        Route::get('/form-pembuatan/detail/{id}', 'formPembuatanController@detail')->name('form-pembuatan.detail');
        Route::post('/form-pembuatan/create', 'formPembuatanController@store')->name('form-pembuatan.store');
        Route::get('/form-pembuatan/status/{id}', 'formPembuatanController@status')->name('form-pembuatan.status');
    });

    Route::group(['middleware' => 'permission:form-penghapusan'], function (){
        Route::group(['prefix' => 'form-penghapusan'], function(){
            Route::get('/form-penghapusan', 'formPenghapusanController@index')->name('form-penghapusan.index');
            Route::get('/form-penghapusan/create', 'formPenghapusanController@create')->name('form-penghapusan.create');
            Route::post('/form-penghapusan/store', 'formPenghapusanController@store')->name('form-penghapusan.store');
        });
    });

    Route::group(['middleware' => 'permission:form-pemindahan'], function (){
        Route::group(['prefix' => 'form-pemindahan'], function(){
            Route::get('/form-pemindahan', 'formPemindahanController@index')->name('form-pemindahan.index');
            Route::get('/form-pemindahan/create', 'formPemindahanController@create')->name('form-pemindahan.create');
            Route::post('/form-pemindahan/store', 'formPemindahanController@store')->name('form-pemindahan.store');
        });
    });

    Route::group(['middleware' => 'permission:approval-penghapusan'], function (){
        Route::group(['prefix' => 'approval-penghapusan'], function(){
            Route::get('/approval-penghapusan', 'approvalPenghapusanController@index')->name('approval-penghapusan.index');
            Route::get('/approval-penghapusan/{id}', 'approvalPenghapusanController@detail')->name('approval-penghapusan.create');
            Route::post('/approval-penghapusan/store', 'approvalPenghapusanController@approve')->name('approval-penghapusan.store');
        });
    });

    Route::group(['middleware' => 'permission:approval-pembuatan'], function (){
        Route::group(['prefix' => 'approval-pembuatan'], function(){
            Route::get('/approval-pembuatan', 'approvalPembuatanController@index')->name('approval-pembuatan.index');
            Route::get('/approval-pembuatan/{id}', 'approvalPembuatanController@create')->name('approval-pembuatan.create');
            Route::post('/approval-pembuatan/store', 'approvalPembuatanController@approve')->name('approval-pembuatan.store');
        });
    });

    Route::group(['middleware' => 'permission:rj-server-status'], function (){
        Route::group(['prefix' => 'rj_server'], function(){
            Route::get('rj_server', 'rj_server_statusController@index')->name('rj_server.index');
            Route::get('/rj_server/{id}', 'rj_server_statusController@detail')->name('rj_server.detail');
            Route::post('/rj_server/update', 'rj_server_statusController@status')->name('rj_server.status');
        });
    });

    Route::group(['middleware' => 'permission:auth'], function (){
        Route::group(['prefix' => 'register'], function(){
            Route::get('/vega/index', 'backGroundRegisterController@index')->name('back_register.index');
            Route::post('/vega/store', 'backGroundRegisterController@store')->name('back_register.store');
        });

        Route::group(['prefix' => 'vega'], function(){
            Route::get('/vega/index', 'vegaEditController@index')->name('vega.index');
            Route::get('/vega/{id}', 'vegaEditController@edit')->name('vega.edit');
            Route::post('/vega/update', 'vegaEditController@update')->name('vega.update');
        });

        Route::group(['prefix' => 'management'], function(){
            Route::get('/management/index', 'UserController@index')->name('management.index');
            Route::get('/management/{id}', 'UserController@edit')->name('management.edit');
            Route::post('/management/update', 'UserController@update')->name('management.update');
        });

        Route::group(['prefix' => 'role'], function (){
            Route::get('/role/index', 'roleApprovalController@index')->name('role.index');
            Route::get('/role/{id}', 'roleApprovalController@create')->name('role.create');
            Route::post('/role/store', 'roleApprovalController@update')->name('role.update');
        });

        Route::group(['prefix' => 'store'], function (){
            Route::get('/index', 'storeApprovalController@index')->name('store.index');
            Route::get('/select/{id}', 'storeApprovalController@create')->name('store.create');
            Route::post('/', 'storeApprovalController@store')->name('store.store');
            Route::get('/detail/{id}', 'storeApprovalController@detail')->name('store.detail');
            Route::get('/detail/delete/{id}', 'storeApprovalController@detailDeleteById')->name('store.deleteDetail');
            Route::post('/delete', 'storeApprovalController@delete')->name('store.delete');
        });
    });
});
