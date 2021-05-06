<?php

use \App\Http\Response;
use \App\Controller\Admin;

//ROTA DE LISTAGEM DE USUÁRIOS
$app->get('/admin/users', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\User::getUsers($request));
    }
]);

//ROTA DE CADASTRO DE USUÁRIOS
$app->get('/admin/users/new', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\User::getNewUser($request));
    }
]);

//ROTA DE CADASTRO DE USUÁRIOS (POST)
$app->post('/admin/users/new', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\User::setNewUser($request));
    }
]);

//ROTA DE EDIÇÃO DE USUÁRIOS
$app->get('/admin/users/{id}/edit', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\User::getEditUser($request, $id));
    }
]);

//ROTA DE EDIÇÃO DE USUÁRIOS (POST)
$app->post('/admin/users/{id}/edit', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\User::setEditUser($request, $id));
    }
]);

//ROTA DE EXCLUSÃO DE USUÁRIOS 
$app->get('/admin/users/{id}/delete', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\User::getDeleteUser($request, $id));
    }
]);

//ROTA DE EXCLUSÃO DE USUÁRIOS 
$app->post('/admin/users/{id}/delete', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\User::setDeleteUser($request, $id));
    }
]);