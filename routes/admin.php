<?php

use \App\Http\Response;
use \App\Controller\Admin;

//ROTA ADMIN
$app->get('/admin', [
    function () {
        return new Response(200, 'Admin :)');
    }
]);

//ROTA LOGIN
$app->get('/admin/login', [
    function ($request) {
        return new Response(200, Admin\Login::getLogin($request));
    }
]);


//ROTA LOGIN POST
$app->post('/admin/login', [
    function ($request) {
        return new Response(200, Admin\Login::setLogin($request));
    }
]);
