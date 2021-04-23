<?php

use \App\Http\Router;
use \App\Http\Response;
use \App\Controller\Pages;


$app = new Router('http://localhost/MVC');

//ROTA HOME
$app->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

//ROTA SOBRE
$app->get('/sobre', [
    function () {
        return new Response(200, Pages\Sobre::getSobre());
    }
]);

//ROTA DEPOIMENTOS
$app->get('/depoimentos', [
    function () {
        return new Response(200, Pages\Testimony::getTestimonies());
    }
]);

//ROTA DEPOIMENTOS {INSERT}
$app->post('/depoimentos', [
    function ($request) {
        return new Response(200, Pages\Testimony::insertTestimony($request));
    }
]);
