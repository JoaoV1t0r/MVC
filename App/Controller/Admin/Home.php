<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Utils\View;

class Home extends Page
{
    /**
     * Método responsável por renderizar a view de home do painel
     * 
     *
     * @param Request $request
     * @return string
     */
    public static function getHome($request)
    {
        //CONTEÚDO DA HOME
        $content = View::render('Admin/modules/home/index', []);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Home > João Vitor', $content, 'home');
    }
}
