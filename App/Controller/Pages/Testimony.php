<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;
use \App\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
{
    /**
     * Método responsável por retornar a View de depoimentos
     * 
     * @param Resquest $request
     * @return string
     **/
    public static function getTestimonies($request)
    {
        //VIEW DA HOME
        $content = View::render('pages/testimonies', [
            'itens' => self::getTestimoniesItens($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ]);

        //RETORNA A VIEW DA PÁGINA
        return parent::getPage('Depoimentos', $content);
    }

    /**
     * Método responsável por obter a renderização dos depoimentos
     * 
     * @param Resquest $request
     * @param Pagination $obPagination
     * @return string
     **/
    private static function getTestimoniesItens($request, &$obPagination)
    {
        //DEPOIMENTOS
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
        // echo '<pre>';
        // print_r($quantidadeTotal);
        // exit;
        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTANCIA DA PÁGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 3);

        //RETORNA OS DEPOIMENTOS
        $obTestimony = new EntityTestimony;

        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            $itens .= View::render('pages/testimony/item', [
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d/m/Y H:i:s', strtotime($obTestimony->data))
            ]);
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
    }

    /**
     * Método responsável por cadastrar um depoimento
     *
     * @param Resquest $request
     * @return string
     */
    public static function insertTestimony($request)
    {
        //DADOS DO POST
        $postVars = $request->getPostVars();

        //NOVA INSTANCIA DE DEPOIMENTO
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();

        return self::getTestimonies($request);
    }
}
