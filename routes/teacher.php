<?php


use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:teacher']
    ], function () {

    //==============================dashboard============================
    Route::get('/teacher/dashboard', function () {
        $ids = Teacher::findorFail(auth()->user()->id)->Sections()->pluck('sectoins_id');

        
        $data['count_sections']= $ids->count();
        $data['count_students']= \App\Models\Students::whereIn('section_id',$ids)->count();


        return view('pages.Teachers.dashboard.dashboard',$data);
    });


    Route::group(['namespace' => 'Teacher\dashboard'], function () {
        //==============================students============================
        Route::get('student','StudentController@index')->name('teacher_student');

        Route::get('sections','StudentController@section')->name('section');

        Route::post('attendance','StudentController@attendance')->name('attendance');
        Route::post('edit_attendance','StudentController@editAttendance')->name('attendance.edit');

        Route::get('attendance_report','StudentController@attendanceReport')->name('attendance.report');
        Route::post('attendance_report','StudentController@attendanceSearch')->name('attendance.search');


        Route::resource('quizzes', 'QuizzController');
        Route::get('/Get_classrooms/{id}', 'QuizzController@getClassrooms');
        Route::get('/Get_Sections/{id}', 'QuizzController@Get_Sections');


        Route::resource('questions', 'QuestionController');

    });

});