<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class User
{
    /**
     * Id do usuário
     *
     * @var int
     */
    public $id;

    /**
     * Nome do usuário
     *
     * @var string
     */
    public $nome;

    /**
     * E-mail do usuário
     *
     * @var string
     */
    public $email;

    /**
     * Senha do usuário
     *
     * @var string
     */
    public $senha;

    /**
     * Método responsável por retornar um usuário pelo seu e-mail
     *
     * @param string $email
     * @return User
     */
    public static function getUserByEmail($email)
    {
        return (new Database('usuarios'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar todos os usuários
     **
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatement
     */
    public static function getUsers($where = null, $order = null, $limit = null, $field = '*')
    {
        return (new Database('usuarios'))->select($where, $order, $limit, $field);
    }
}
