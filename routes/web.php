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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/tag/{tag}', 'TagController@show');

Route::get('/', 'QuestionController@index')->name('home');
Route::post('/questions', 'QuestionController@store');
Route::get('/questions/{question}', 'QuestionController@show')->name('questions.show');
Route::get('/questions/{question}/topanswer', 'QuestionController@showTopAnswer');
Route::get('/questions/{question}/edit', 'QuestionController@edit');
Route::patch('/questions/{question}', 'QuestionController@update');

Route::post('/questions/{question}/answers', 'AnswerController@store');
Route::post('/questions/{question}/answers/{answer}/select', 'AnswerController@select')->name('questions.answer.select');

Route::get('/profile/{user}', 'ProfileController@show');
Route::post('/profile/{user}/photo', 'ProfileController@store');

Route::get('/api/tags', function() {
    return App\Tag::where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);
});