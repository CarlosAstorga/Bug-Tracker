<?php

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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes(['verify' => true]);
Route::post('demo', '\App\Http\Controllers\Auth\LoginController@demo')->name('login.demo');

Route::middleware(['verified'])->group(function () {

    Route::get('sidebar/{state}', function ($state) {
        session(['toggled' => ($state === 'true')]);
    });

    Route::get('profile', 'ProfileController@index')->name('profile');
    Route::get('profile/edit', 'ProfileController@edit');
    Route::post('profile/{user}', 'ProfileController@update')->name('profile.update');

    Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']])->middleware("can:manage-users");
        Route::get('/users/list', 'UsersController@list');
    });

    Route::middleware('can:manage-projects')->group(function () {
        Route::get('projects/list', 'ProjectController@list')->name('projects.');
        Route::resource('projects', 'ProjectController');
        Route::get('projects/{project}/tickets/list', 'ProjectController@getTickets');
        Route::get('projects/{project}/users/list', 'ProjectController@getUsers');

        Route::get('projects/{project}/tickets/{ticket}', function ($project, $ticket) {
            return redirect(route('tickets.show', $ticket));
        });
    });

    Route::get('tickets/list', 'TicketController@list')->name('tickets.');
    Route::resource('tickets', 'TicketController');

    Route::get('chart', 'ChartController@chart');

    Route::post('comment/store', 'CommentController@store');
    Route::delete('comment/{comment}', 'CommentController@destroy');

    Route::post('file-upload', 'FileUploadController@fileUploadPost');
    Route::delete('file/{file}', 'FileUploadController@destroy');

    Route::get('download/{file}', 'FileUploadController@download')->name('file.download');

    Route::get('/home', 'HomeController@index')->name('home');
});
