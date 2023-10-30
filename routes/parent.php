<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| student Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//==============================Translate all pages============================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:parent']
    ],
    function () {

        //==============================dashboard============================
        Route::get('/parent/dashboard', function () {
            return view('pages.parents.dashboard');
        })->name('dashboard.parents');

        Route::group(['namespace' => 'Parents\dashboard'], function () {
            Route::get('sons', 'ChildrenController@index');

            Route::get('children', 'ChildrenController@children')->name('children');
           

            Route::get('attendences', 'ChildrenController@attendences')->name('sons.attendances');

            Route::post('attendances','ChildrenController@attendanceSearch')->name('sons.attendance.search');



        });
    }
);
