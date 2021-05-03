<?php

use \App\Http\Response;
use \App\Controller\Admin;

//ROTA DE LISTAGEM DE DEPOIMENTOS
$app->get('/admin/testimonies', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::getTestimonies($request));
    }
]);

//ROTA DE CADASTRO DE DEPOIMENTO
$app->get('/admin/testimonies/new', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::getNewTestimony($request));
    }
]);

//ROTA DE CADASTRO DE DEPOIMENTO (POST)
$app->post('/admin/testimonies/new', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::setNewTestimony($request));
    }
]);

//ROTA DE EDIÇÃO DE DEPOIMENTO
$app->get('/admin/testimonies/{id}/edit', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\Testimony::getEditTestimony($request, $id));
    }
]);
