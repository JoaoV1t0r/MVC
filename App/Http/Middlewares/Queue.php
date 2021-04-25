<?php

namespace App\Http\Middlewares;

class Queue
{
    /**
     * Fila de middlewares a serem executados
     *
     * @var array
     */
    private $middlewares;

    /**
     * Função de execução do controlador
     *
     * @var Closure
     */
    private $controller;

    /**
     * Argumentos da função do controlador
     *
     * @var array
     */
    private $controllerArgs;

    /**
     * Método responsável por construir a classe de fila de middlewares
     *
     * @param array $middlewares
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct($middlewares, $controller, $controllerArgs)
    {
        $this->middlewares = $middlewares;
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
     * Método responsável por executar o próximo nível da fila de middlewares
     *
     * @param Request $request
     * @return Response
     */
    public function next($request)
    {
        echo '<pre>';
        print_r($this);
        exit;
    }
}
