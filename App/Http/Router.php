<?php

namespace App\Http;

use App\Http\Middlewares\Queue;
use \Closure;
use \Exception;
use \ReflectionFunction;

class Router
{
    /**
     * URL completa do projeto(raiz)
     *
     * @var string
     */
    private $url = '';


    /**
     * Prefixo de todas as rotas
     *
     * @var string
     */
    private $prefix = 'http://localhost/MVC/';


    /**
     * Índice de rotas
     *
     * @var array
     */
    private $routes = [];

    /**
     * Instância de Resquest
     *
     * @var Request
     */
    private $request;

    /**
     * Método responsável por iniciar a classe
     * 
     * @param string $url
     */
    public function __construct($url)
    {
        $this->request = new Request($this);
        $this->url     = $url;
        $this->setPrefix();
    }

    /**
     * Método responsável por definir o prefixo das rotas
     * 
     */
    private function setPrefix()
    {
        //INFORMAÇÕES DA URL ATUAL
        $parseUrl = parse_url($this->url);

        //DEFINE O PREFIXO
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Método responsável por adicionar uma rota na classe
     * 
     * @param string $method
     * @param string $route
     * @param array $params
     * @return void
     */
    private function addRoute($method, $route, $params = [])
    {
        //VALIDAÇÃO DOS PARAMS
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['Controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        //MIDDLEWARES DA ROTA
        $params['middlewares'] = $params['middlewares'] ?? [];

        //VARIÁVEIS DA ROTA
        $params['variables'] = [];

        $patternVariable = '/{(.*?)}/';
        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        //PADRÃO DE VALIDAÇÃO DA URL
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        //ADICIONA A ROTA DENTRO DA CLASSE
        $this->routes[$patternRoute][$method] = $params;
    }

    /**
     * Método responsável por retornar a URI sem prefixo
     *
     * @return string
     */
    private function getUri()
    {
        //URI DA REQUEST
        $uri = $this->request->getUri();
        //FATIA A URI COM PREFIXO
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        return end($xUri);
    }

    /**
     * Método responsável por retornar os dados da rota atual
     *
     * @return array
     */
    private function getRoute()
    {
        //URI
        $uri = $this->getUri();

        //METHOD
        $httpMethod = $this->request->getHttpMethod();

        //VALIDA AS ROTAS
        foreach ($this->routes as $patternRoute => $methods) {
            //VERIFICA SE A URI É IGUAL AO PADRÃO
            if (preg_match($patternRoute, $uri, $matches)) {
                //VERIFICA O MÉTODO
                if (isset($methods[$httpMethod])) {
                    unset($matches[0]);
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    //RETORNO DOS PARÂMETROS DA ROTA
                    return $methods[$httpMethod];
                }
                //MÉTODO NÃO DEFINIDO
                throw new Exception("Método não permitido", 405);
            }
        }
        //URL NÃO ENCONTRADA
        throw new Exception("URL não encontrada", 404);
    }

    /**
     * Método responsável por executar a rota atual
     * 
     * @return Response
     */
    public function run()
    {
        try {
            //OBTEM A ROTA ATUAL
            $route = $this->getRoute();

            //VERIFICA O CONTROLLER
            if (!isset($route['Controller'])) {
                throw new Exception("A URL não pôde ser processada", 500);
                return;
            }
            //ARGUMENTOS DA FUNÇÃO
            $args = [];

            $reflection = new ReflectionFunction($route['Controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            //RETORNA A EXECUSÃO DA FILA MIDDLEWARES
            return (new Queue($route['middlewares'], $route['Controller'], $args))->next($this->request);
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Método responsável por definir uma rota de GET
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function get($route, $params = [])
    {
        $this->addRoute('GET', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de POST
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function post($route, $params = [])
    {
        $this->addRoute('POST', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de PUT
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function put($route, $params = [])
    {
        $this->addRoute('PUT', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de DELETE
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function delete($route, $params = [])
    {
        $this->addRoute('DELETE', $route, $params);
    }

    /**
     * Método responsável por retornar a url atual
     *
     * @return string
     */
    public function getCurrentUrl()
    {
        return $this->url . $this->getUri();
    }
}
