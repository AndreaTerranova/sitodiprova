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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.comics.index');
    })->name('index');

    Route::resource('comics', 'ComicController')->except(['index', 'show'])->middleware('auth.manager');

    Route::name('comics.')->group(function () {
        Route::get('comics', 'ComicController@index')->name('index')->middleware('auth.editor');
        Route::prefix('comics/{comic}')->middleware('can.edit')->group(function () {
            Route::get('', 'ComicController@show')->name('show');
            Route::resource('chapters', 'ChapterController')->except(['destroy']);
            Route::delete('chapters/{chapter}', 'ChapterController@destroy')->name('chapters.destroy')->middleware('auth.manager');
            Route::post('chapters/{chapter}/pages', 'PageController@store')->name('chapters.pages.store');
            Route::delete('chapters/{chapter}/pages/{page}', 'PageController@destroy')->name('chapters.pages.destroy');
        });
    });

    Route::resource('users', 'UserController', ['except' => ['show']])->middleware('auth.admin');
});
