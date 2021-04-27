<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Page
{
    /**
     * Método reponsável por retronar o conteúdo da estruta de página generica do painel
     *
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render('Admin/page', [
            'title' => $title,
            'content' => $content
        ]);
    }
}
