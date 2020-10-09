<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Login Routes
$router->post('/register', 'UserController@register');
$router->post('/login', 'UserController@login');

// Token Refresh
$router->get('/refresh', [
    'as' => 'login.refresh',
    'uses' => 'UserController@refresh'
]);

// Post Routes
$router->group(['prefix' => 'posts'], function () use ($router) {
    $router->get('index' , [
        'as' => 'post.index',
        'uses' => 'PostController@index'
    ]);
    
    $router->get('show/{id}' , [
        'as' => 'post.show',
        'uses' => 'PostController@show'
    ]);
    
    $router->post('create' , [
        'as' => 'post.create',
        'uses' => 'PostController@create'
    ]);

    
    $router->put('update/{id}', [
        'as' => 'posts.update',
        'uses' => 'PostController@update'
    ]);
    
    $router->delete('delete/{id}', [
        'as' => 'posts.delete',
        'uses' => 'PostController@delete'
    ]);

    $router->get('self' , [
        'as' => 'post.self',
        'uses' => 'PostController@self'
    ]);
});

// $router->get('/admin', [
//     'as' => 'admin',
//     'uses' => 'DetailController@admin'
// ]);

$router->group(['prefix' => 'details'], function () use ($router) {
    
    $router->get('show/{id}' , [
        'as' => 'details.show',
        'uses' => 'DetailController@show'
    ]);

    $router->post('create', [
        'as' => 'details.create',
        'uses' => 'DetailController@create'
    ]);
    
    $router->put('update/{id}', [
        'as' => 'details.update',
        'uses' => 'DetailController@update'
    ]);
    
    $router->delete('delete/{id}', [
        'as' => 'details.delete',
        'uses' => 'DetailController@delete'
    ]);

    
});