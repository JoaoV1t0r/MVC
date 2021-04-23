<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;
use \App\Model\Entity\Testimony as EntityTestimony;

class Testimony extends Page
{
    /**
     * Método responsável por retornar a View de depoimentos
     * @return string
     **/
    public static function getTestimonies()
    {
        //VIEW DA HOME
        $content = View::render('pages/testimonies', []);

        //RETORNA A VIEW DA PÁGINA
        return parent::getPage('Depoimentos', $content);
    }

    /**
     * Método responsável por cadastrar um depoimento
     *
     * @param Resquest $request
     * @return string
     */
    public static function insertTestimony($request)
    {
        //DADOS D POST
        $postVars = $request->getPostVars();

        //NOVA INSTANCIA DE DEPOIMENTO
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();

        return self::getTestimonies();
    }
}
