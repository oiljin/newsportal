<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// главная страница
Route::get('/', ['uses' => 'ArticlesController@index']);

// все новости или новости определенной категории
Route::get('/feed/{alias?}', ['uses' => 'ArticlesController@feed']);

// страница новости
Route::get('/news-{alias}', ['uses' => 'ArticlesController@article']);

// страница о проекте
Route::get('/about', ['uses' => 'ArticlesController@about']);

// результаты поиска
Route::get('/search', ['uses' => 'ArticlesController@search']);