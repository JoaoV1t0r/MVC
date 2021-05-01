<?php

use \App\Http\Response;
use App\Controller\Admin\Home;

//ROTA ADMIN
$app->get('/admin', [
    'middlewares' => [
        'require-admin-login'
    ],
    function ($request) {
        return new Response(200, Home::getHome($request));
    }
]);
