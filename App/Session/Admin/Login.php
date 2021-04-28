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
}
