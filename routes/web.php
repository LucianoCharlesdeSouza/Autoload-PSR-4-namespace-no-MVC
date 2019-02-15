<?php

use App\Router;

Router::group([
  'namespace' => 'App\Http\Controllers\Site',
  'exceptionHandler' => \App\Handlers\CustomExceptionHandler::class], function () {

  Router::get('/', 'HomeController@index')->name('home.index');
  Router::get('/testando/{id}/{ids}', 'HomeController@teste')->name('home.teste');

});

Router::group([
  'namespace' => 'App\Http\Controllers\Painel',
  'exceptionHandler' => \App\Handlers\CustomExceptionHandler::class], function () {

  Router::get('/painel', 'HomeController@index')->name('painel');
  Router::get('/painel/testando/{id}/{ids}', 'HomeController@teste')->name('painel.teste');

});