<?php

use Illuminate\Support\Facades\Route;
use App\Mail\TestMail2;

use App\user;
use Illuminate\Support\Facades\Mail;

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






Route::get('/', 'HomeController@index')->name('selection');

Route::group(['namespace' => 'Auth'], function () {


    Route::get('/login/{type}', 'LoginController@loginForm')->middleware('guest')->name('login.show');

    Route::post('/login', 'LoginController@login')->name('login');

    Route::get('/logout/{type}', 'LoginController@logout')->name('logout');
});




Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ],
    function () { //...

        Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');


        Route::group(['prefix' => 'user', 'namespace' => 'Grade'], function () {
            Route::resource('Grades', 'GradeController');
        });


        Route::group(['namespace' => 'Classroom'], function () {
            Route::resource('classes', 'ClassroomController');

            Route::post('delete_all', 'ClassroomController@delete_all')->name('delete_all');

            Route::post('Filter_Classes', 'ClassroomController@Filter_Classes')->name('Filter_Classes');
        });


        Route::group(['namespace' => 'sections'], function () {
            Route::resource('Sections', 'SectoinsController');

            Route::get('ahmed/{id}', 'SectoinsController@ahmed');
        });


        Route::view('add_parent', 'livewire.show_form')->name('add_parent');


        Route::group(['namespace' => 'Teacher'], function () {
            Route::resource('Teachers', 'TeacherController');
        });


        Route::group(['namespace' => 'Students'], function () {
            Route::resource('Students', 'StudentsController');

            Route::get('Get_classrooms/{id}', 'StudentsController@Get_classrooms');

            Route::get('Get_Sections/{id}', 'StudentsController@Get_Sections');


            Route::post('Upload_attachment', 'StudentsController@Upload_attachment')->name('Upload_attachment');
            Route::get('Download_attachment/{studentsname}/{filename}', 'StudentsController@Download_attachment')->name('Download_attachment');
            Route::post('Delete_attachment', 'StudentsController@Delete_attachment')->name('Delete_attachment');

            Route::resource('Promotion', 'PromotionsController');

            Route::resource('Graduated', 'GraduatedController');


            Route::get('attendance_report1','StudentController@attendanceReport')->name('report1');
            Route::post('attendance_report1','StudentController@attendanceSearch')->name('search1');

            Route::resource('Attendance', 'AttendanceController');

            Route::resource('Fees', 'FeesController');
            Route::resource('Fees_Invoices', 'FeesInvoicesController');
            Route::resource('receipt_students', 'ReceiptStudentController');

            Route::resource('ProcessingFee', 'ProcessingFeeController');

            Route::resource('online_classes', 'OnlineCourceController');


            Route::get('/indirect', 'OnlineCourceController@indirectCreate')->name('indirect.create');

            Route::post('/indirect', 'OnlineCourceController@storeIndirect')->name('indirect.store');

            Route::resource('library', 'LibraryController');
            Route::get('downloadAttachment/{bookname}', 'LibraryController@downloadAttachments')->name('downloadAttachment');
        });

        Route::group(["namespace" => "subjects"], function () {
            Route::resource('subjects', 'SubjectController');

            Route::get('get_classes/{id}', 'SubjectController@getClass');
        });





        Route::group(['namespace' => 'Quizzes'], function () {
            Route::resource('Quizzes', 'QuizzeController');
        });

        Route::group(['namespace' => 'questions'], function () {
            Route::resource('questions', 'QuestionsController');
        });

        //==============================settings============================
        Route::group(['namespace' => 'Setting'], function () {
            Route::resource('settings', 'SettingController');
        });


        Route::get('qr','QRController@index')->name('qr');

        Route::post('qr','QRController@insert')->name('addQr');


        Route::get('/send',function(){

            $user = 'ahmed';

            Mail::to('ae676430@gmail.com')->send(new TestMail2($user));

            return 'done...........';
        });

    }
);
