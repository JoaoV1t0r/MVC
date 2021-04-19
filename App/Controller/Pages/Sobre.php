<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Sobre extends Page
{
    /**
     * Método responsável por retornar a View da página de Sobre
     * @return string
     **/
    public static function getSobre()
    {
        //ORGANIZAÇÃO
        $obOrganization = new Organization;

        //VIEW DA HOME
        $content = View::render('pages/sobre', [
            'name' => $obOrganization->name,
            'description' => $obOrganization->description,
            'site' => $obOrganization->site,
        ]);

        //RETORNA A VIEW DA PÁGINA
        return parent::getPage('Sobre', $content);
    }
}
