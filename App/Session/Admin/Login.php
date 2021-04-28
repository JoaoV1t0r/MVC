<?php

namespace App\Session\Admin;

class Login
{
    /**
     * Método responsável por iniciar a Sessão
     *
     * @return void
     */
    private static function init()
    {
        //VERIFICA SE A SESSÃO NÃO ESTÁ ATIVA
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * Método responsável por criar o Login
     *
     * @param User $obUser
     * @return boolean
     */
    public static function Login($obUser)
    {
        //INICIA A SESSÃO
        self::init();

        $_SESSION['admin']['usuario'] = [
            'id' => $obUser->id,
            'nome' => $obUser->nome,
            'email' => $obUser->email
        ];

        return true;
    }

    /**
     * Método responsável por executar o logout do User
     *
     * @return boolean
     */
    public static function Logout()
    {
        self::init();

        //DESLOGA O USER
        unset($_SESSION['admin']['usuario']);

        return true;
    }

    /**
     * Método responsável por verificar se o User está logado
     *
     * @return boolean
     */
    public static function isLogged()
    {
        self::init();

        //RETORNA A VERIFICAÇÃO
        return isset($_SESSION['admin']['usuario']['id']);
    }
}
