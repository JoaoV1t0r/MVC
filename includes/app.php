<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Utils\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;
use \App\Http\Middlewares\Queue as MiddlewareQueue;
use App\Http\Router;

//CARREGA VARIÁVEIS DE AMBIENTE
Environment::load(__DIR__ . '/../');

//DEFINE AS CONFIG DO BANCO DE DADOS
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

define('URL', getenv('URL'));

$app = new Router(URL);

View::init([
    'URL' => URL
]);

//DEFINE O MAPEAMENTO DE MIDDLEWARES
MiddlewareQueue::setMap([
    'maintenance' => \App\Http\Middlewares\Maintenance::class,
    'require-admin-logout' => \App\Http\Middlewares\RequireAdminLogout::class,
    'require-admin-login' => \App\Http\Middlewares\RequireAdminLogin::class
]);

//DEFINE O MAPEAMENTO DE MIDDLEWARES (EXECUTADOS EM TODAS AS ROTAS)
MiddlewareQueue::setDefault([
    'maintenance'
]);
