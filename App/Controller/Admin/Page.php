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
            'link' => URL . '/admin/testimonies'
        ],
        'users' => [
            'label' => 'Usuários',
            'link' => URL . '/admin/user'
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

    /**
     * Método responsável por renderizar o layout de paginação
     *
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    public static function getPagination($request, $obPagination)
    {
        //PÁGINAS
        $pages = $obPagination->getPages();

        //VERIFICA A QUANTIDADE DE PÁGINAS
        if (count($pages) <= 1) return '';

        //LINKS
        $links = '';

        //URL ATUAL
        $url = $request->getRouter()->getCurrentUrl();

        //GET
        $queryParams = $request->getQueryParams();

        //RENDERIZA OS LINKS
        foreach ($pages as $page) {
            //ALTERA A PÁGINA 
            $queryParams['page'] = $page['page'];

            //LINK
            $link = $url . '?' . http_build_query($queryParams);

            //VIEW
            $links .= View::render('Admin/pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''

            ]);
        }
        return View::render('Admin/pagination/box', [
            'links' => $links

        ]);
    }
}
