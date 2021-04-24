<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Testimony
{

    /**
     * ID do depoimento
     *
     * @var integer
     */
    public $id;

    /**
     * Nome do usuário que fez o depoimento
     *
     * @var string
     */
    public $nome;

    /**
     * Mensagem do depoimento
     *
     * @var string
     */
    public $mensagem;

    /**
     * Data de publicação do depoimento
     *
     * @var string
     */
    public $data;

    /**
     * Método responsável por cadastrar a instancia atual no banco de dados
     *
     * @return boolean
     */
    public function cadastrar()
    {
        //DEFINE A DATA 
        $this->data = date('Y-m-d h:i:s');

        //INSERE O DEPOIMENTO NO BANCO DE DADOS
        $this->id = (new Database('depoimentos'))->insert([
            'nome' => $this->nome,
            'mensagem' => $this->mensagem,
            'data' => $this->data
        ]);
    }

    /**
     * Método responsável por retornar os depoimentos do banco de dados
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $field = '*')
    {
        return (new Database('depoimentos'))->select($where, $order, $limit, $field);
    }
}
