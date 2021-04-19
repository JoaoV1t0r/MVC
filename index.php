<?php

require __DIR__ . '/vendor/autoload.php';


use \App\Http\Response;
use App\Utils\View;

define('URL', 'http://localhost/MVC');

View::init([
    'URL' => URL
]);

//INCLUI AS ROTAS DE PAGINAS
include __DIR__ . '/routes/pages.php';

$obRouter->run()->sendResponse();



// echo '<pre>';
// print_r($obRouter);
