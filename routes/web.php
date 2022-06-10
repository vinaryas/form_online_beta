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
Route::get('/user/Toko', 'registerController@createToko')->name('user.createCs');
Route::post('/user', 'registerController@store')->name('user.store');

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['middleware' => 'permission:form'], function (){
        Route::get('/form', 'formController@index')->name('form.index');
        Route::get('/form/create', 'formController@create')->name('form.create');
        Route::post('/form/create', 'formController@store')->name('form.store');
        Route::get('/form/status{id}', 'formController@status')->name('form.status');
    });

    Route::group(['middleware' => 'permission:approval'], function (){
        Route::get('/approval', 'approvalController@index')->name('approval.index');
        Route::get('/approval/{id}', 'approvalController@create')->name('approval.create');
        Route::post('/approval/store', 'approvalController@approve')->name('approval.store');
    });

    Route::get('/history', 'approvalController@historyApproval')->name('history');

    Route::group(['middleware' => 'permission:auth'], function (){
        Route::group(['prefix' => 'vega_void'], function(){
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
