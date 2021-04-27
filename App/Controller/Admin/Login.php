<?php

namespace App\Controller\Admin;

use App\Model\Entity\User;
use App\Utils\View;

class Login extends Page
{
    /**
     * Método reponsável por retornar a renderização da página de login
     *
     * @param Reqeust $request
     * @param string $errorMessage
     * @return string
     */
    public static function getLogin($request, $errorMessage = null)
    {
        //STATUS
        $status = !is_null($errorMessage) ? View::render('Admin/login/status', [
            'mensagem' => $errorMessage
        ]) : '';

        //CONTEÚDO DA PÁGINA DE LOGIN
        $content = View::render('Admin/login', [
            'status' => $status
        ]);

        //RETORNA A PÁGINA COMLETA
        return parent::getPage('Login > João Vitor', $content);
    }

    /**
     * Método reponsável por definir o login do usuário
     *
     * @param Reqeust $request
     * @return string
     */
    public static function setLogin($request)
    {
        //POST VARS
        $postVars = $request->getPostVars();

        $email = $postVars['email'] ?? '';
        $senha = $postVars['pass'] ?? '';

        //BUSCA USER PELO E-MAIL
        $obUser = User::getUserByEmail($email);
        if (!$obUser instanceof User) {
            return self::getLogin($request, 'E-mail ou senha inválidos.');
        }

        //VERIFICA A SENHA DO USER
        if (!password_verify($senha, $obUser->senha)) {
            return self::getLogin($request, 'E-mail ou senha inválidos.');
        }
        echo '<pre>';
        print_r($obUser);
    }
}
