<?php

use \App\Http\Response;
use \App\Controller\Admin;

//ROTA ADMIN
$app->get('/admin', [
    'middlewares' => [
        'require-admin-login'
    ],
    function () {
        return new Response(200, 'Admin :)');
    }
]);

//ROTA LOGIN
$app->get('/admin/login', [
    'middlewares' => [
        'require-admin-logout'
    ],
    function ($request) {
        return new Response(200, Admin\Login::getLogin($request));
    }
]);

//ROTA LOGIN (POST)
$app->post('/admin/login', [
    'middlewares' => [
        'require-admin-logout'
    ],
    function ($request) {
        return new Response(200, Admin\Login::setLogin($request));
    }
]);

//ROTA Logout
$app->get('/admin/logout', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Login::setLogout($request));
    }
]);
