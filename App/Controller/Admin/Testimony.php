<?php

namespace App\Controller\Admin;

use App\Utils\View;
use \App\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
{
    /**
     * Método responsável por renderizar a view de listagem de depoimentos
     * 
     * @param Request $request
     * @return string
     */
    public static function getTestimonies($request)
    {
        //CONTEÚDO DA HOME
        $content = View::render('Admin/modules/testimonies/index', [
            'itens' => self::getTestimoniesItens($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Depoimentos > João Vitor', $content, 'testimonies');
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

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTANCIA DA PÁGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);

        //RETORNA OS DEPOIMENTOS
        $obTestimony = new EntityTestimony;

        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            $itens .= View::render('admin/modules/testimonies/item', [
                'id' => $obTestimony->id,
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d/m/Y H:i:s', strtotime($obTestimony->data))
            ]);
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
    }

    /**
     * Método responsável por retronar o formulário de cadastro de um novo depoimento
     * 
     * @param Request $request
     * @return string
     */
    public static function getNewTestimony($request)
    {
        //CONTEÚDO DO FORM
        $content = View::render('Admin/modules/testimonies/form', [
            'title' => 'Cadastrar Depoimento.',
            'acao' => 'Cadastrar',
            'nome' => '',
            'mensagem' => ''
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Cadastrar Depoimento > João Vitor', $content, 'testimonies');
    }

    /**
     * Método responsável por cadastrar um depoimento
     *
     * @param Resquest $request
     * @return string
     */
    public static function setNewTestimony($request)
    {
        //DADOS DO POST
        $postVars = $request->getPostVars();

        //NOVA INSTANCIA DE DEPOIMENTO
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/testimonies/' . $obTestimony->id . '/edit?status=created');
    }

    /**
     * Método responsável por retronar o formulário de cadastro de um novo depoimento
     * 
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditTestimony($request, $id)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALÍDA INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
            return;
        }
        // echo '<pre>';
        // print_r($obTestimony);
        // exit;

        //CONTEÚDO DO FORM
        $content = View::render('Admin/modules/testimonies/form', [
            'title' => 'Editar Depoimento.',
            'acao' => 'Editar',
            'nome' => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Editar Depoimento > João Vitor', $content, 'testimonies');
    }
}
