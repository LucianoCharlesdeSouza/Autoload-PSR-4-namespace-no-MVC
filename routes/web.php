<?php

use App\Route;

Route::group([
  'namespace' => 'App\Http\Controllers\Site',
  'exceptionHandler' => \App\Handlers\CustomExceptionHandler::class], function () {

  Route::get('/', 'HomeController@index')->name('home.index');
  Route::get('/testando/{id}/{ids}', 'HomeController@teste')->name('home.teste');

});

Route::group([
  'namespace' => 'App\Http\Controllers\Painel',
  'exceptionHandler' => \App\Handlers\CustomExceptionHandler::class], function () {

  Route::get('/painel', 'HomeController@index')->name('painel');
  Route::get('/painel/testando/{id}/{ids}', 'HomeController@teste')->name('painel.teste');

});