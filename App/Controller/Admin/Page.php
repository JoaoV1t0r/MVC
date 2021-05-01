<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Page
{
    /**
     * Módulos disponíveis no painel
     *
     * @var array
     */
    private static $modules = [
        'home' => [
            'label' => 'Home',
            'link' => URL . '/admin'
        ],
        'testimonies' => [
            'label' => 'Depoimentos',
            'link' => URL . '/testimonies'
        ],
        'users' => [
            'label' => 'Usuários',
            'link' => URL . '/user'
        ]
    ];
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

    /**
     * Método responsável por renderizar o Menu do painel
     *
     * @param string $currrentModule
     * @return string
     */
    private static function getMenu($currrentModule)
    {
        //LINKS DO MENU
        $links = '';

        //ITERA OS MÓDULOS
        foreach (self::$modules as $hash => $module) {
            $links .= View::render('admin/menu/link', [
                'label' => $module['label'],
                'link' => $module['link'],
                'current' => $hash == $currrentModule ? 'text-danger' : ''
            ]);
        }
        return View::render('admin/menu/box', [
            'links' => $links
        ]);
    }

    /**
     * Método reponsável por renderizar a view do painel com conteúdos dinâmicos
     *
     * @param string $title
     * @param string $content
     * @param string $currrentModule
     * @return string
     */
    public static function getPanel($title, $content, $currrentModule)
    {
        //RENDERIZA VIEW DO PAINEL
        $contentPanel = View::render('admin/panel', [
            'menu' => self::getMenu($currrentModule),
            'content' => $content
        ]);

        return self::getPage($title, $contentPanel);
    }
}
