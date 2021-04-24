<?php

namespace App\Http;

class Request
{
    /** 
     * Instancia do Router
     * 
     * @var Router
     */
    private $router;

    /** 
     * Método Http da requisição
     * 
     * @var string
     */
    private $httpMethod;

    /**
     * URI da página
     * 
     * @var string
     */
    private $uri;

    /**
     * Parâmetros da URL ($_GET)
     *
     * @var array
     */
    private $queryParams = [];


    /**
     * Variáveis recebidas no POST da página ($_POST)
     *
     * @var array
     */
    private $postVars = [];


    /**
     * Cabeçalho da requisição
     *
     * @var array
     */
    private $headers = [];

    /**
     * Construtor da Classe
     * 
     * @return
     */
    public function __construct($router)
    {
        $this->router = $router;
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
    }

    /**
     * Método responsável por definir a URI
     *
     * @return void
     */
    private function setUri()
    {
        //URI COMPLETA
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';

        //REMOVE GETS DA URI
        $xUri = explode('?', $this->uri);
        $this->uri = $xUri[0];
    }

    /**
     * Método responsável por retornar a instancia do Router
     * 
     * @return string
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Método responsável por retornar o método Http da requisição
     * 
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * Método responsável por retornar a URI da requisição
     * 
     * @return string
     */
    public function getURI()
    {
        return $this->uri;
    }

    /**
     * Método responsável por retornar os Headers da requisição
     * 
     * @return array
     */
    public function getHeaders()
    {
        return $this->uri;
    }

    /**
     * Método responsável por retornar os parâmetros da URL
     * 
     * @return array
     */
    public function getQueryPArams()
    {
        return $this->queryParams;
    }

    /**
     * Método responsável por retornar as variáveis POST da requisição
     * 
     * @return array
     */
    public function getPostVars()
    {
        return $this->postVars;
    }
}
