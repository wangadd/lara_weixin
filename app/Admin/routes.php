<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('/wxuser','WxuserController@index');
    $router->get('/send','WxuserController@send');//群发
    $router->post('/','WxuserController@doSend');//执行群发

    $router->get('/menuview','WxuserController@menuview');
    $router->get('/createmenu','WxuserController@createMenu');

});


