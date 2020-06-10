<?php

use DIY\Base\Router;
use Pecee\Http\Middleware\BaseCsrfVerifier;

if(APP_TYPE !== 'api') Router::csrfVerifier(new BaseCsrfVerifier());
Router::group(['namespace' => "\App\Controllers"], function(){
    Router::get('/', 'HomeController@index')->name("index");
});