<?php

namespace App\Controller\Admin;

use App\Utils\View;
use \App\Model\Entity\User as EntityUser;
use \WilliamCosta\DatabaseManager\Pagination;

class User extends Page
{
    /**
     * Método responsável por retornar a mensagem de status
     *
     * @param Request $request
     * @return string
     */
    private static function getStatus($request)
    {
        //QUERY PARAMS
        $queryParams = $request->getQueryParams();

        //STATUS
        if (!isset($queryParams['status'])) return '';

        //MENSAGEM DE STATUS
        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Usuário Criado com Sucesso');
                break;
            case 'updated':
                return Alert::getSuccess('Usuário Atualizado com Sucesso');
                break;
            case 'deleted':
                return Alert::getSuccess('Usuário Excluído com Sucesso');
                break;
            case 'duplicated':
                return Alert::getError('E-mail já cadastrado');
                break;
        }
    }

    /**
     * Método responsável por renderizar a view de listagem de usuários
     * 
     * @param Request $request
     * @return string
     */
    public static function getUsers($request)
    {
        //CONTEÚDO DA HOME
        $content = View::render('Admin/modules/users/index', [
            'itens' => self::getUserItens($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Usuários > João Vitor', $content, 'user');
    }

    /**
     * Método responsável por obter a renderização dos usuários
     * 
     * @param Resquest $request
     * @param Pagination $obPagination
     * @return string
     **/
    private static function getUserItens($request, &$obPagination)
    {
        //DEPOIMENTOS
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityUser::getUsers(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTANCIA DA PÁGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);

        //RETORNA OS DEPOIMENTOS
        $obUser = new EntityUser;

        $results = EntityUser::getUsers(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while ($obUser = $results->fetchObject(EntityUser::class)) {
            $itens .= View::render('admin/modules/users/item', [
                'id' => $obUser->id,
                'nome' => $obUser->nome,
                'email' => $obUser->email
            ]);
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
    }

    /**
     * Método responsável por retronar o formulário de cadastro de um novo Usuário
     * 
     * @param Request $request
     * @return string
     */
    public static function getNewUser($request)
    {
        //CONTEÚDO DO FORM
        $content = View::render('Admin/modules/users/form', [
            'title' => 'Cadastrar Usuário.',
            'acao' => 'Cadastrar',
            'status' => self::getStatus($request),
            'nome' => '',
            'email' => ''
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Cadastrar Usuário > João Vitor', $content, 'users');
    }

    /**
     * Método responsável por retronar o formulário de editar de um Usuário
     * 
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditUser($request, $id)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obUser = EntityUser::getUserId($id);

        //VALÍDA INSTANCIA
        if (!$obUser instanceof User) {
            $request->getRouter()->redirect('/admin/users');
            return;
        }

        //CONTEÚDO DO FORM
        $content = View::render('Admin/modules/testimonies/form', [
            'title' => 'Editar Depoimento.',
            'acao' => 'Editar',
            'status' => self::getStatus($request),
            'nome' => $obUser->nome,
            'mensagem' => $obUser->mensagem
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Editar Depoimento > João Vitor', $content, 'testimonies');
    }

    /**
     * Método responsável por retronar o formulário de exclusão de um novo depoimento
     * 
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteUser($request, $id)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obUser = EntityUser::getTestimonyById($id);

        //VALÍDA INSTANCIA
        if (!$obUser instanceof User) {
            $request->getRouter()->redirect('/admin/testimonies');
            return;
        }

        //CONTEÚDO DO FORM
        $content = View::render('Admin/modules/testimonies/delete', [
            'nome' => $obUser->nome,
            'mensagem' => $obUser->mensagem
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Excluir Depoimento > João Vitor', $content, 'testimonies');
    }

    /**
     * Método responsável por cadastrar um depoimento
     *
     * @param Resquest $request
     * @return string
     */
    public static function setNewUser($request)
    {
        //DADOS DO POST
        $postVars = $request->getPostVars();

        //VALIDA OS CAMPOS RECEBIDOS
        if ($postVars['nome'] == '' || $postVars['email'] == '' || $postVars['senha'] == '') {
            $request->getRouter()->redirect('/admin/users/new');
            return;
        }

        //NOVA INSTANCIA DE USUÁRIO
        $obUser = new EntityUser;
        $obUser->nome = trim($postVars['nome']);
        $obUser->email = trim($postVars['email']);
        $obUser->senha = password_hash($postVars['senha'], PASSWORD_DEFAULT);

        //VALIDA O EMAIL A SER CADASTRADO
        $emailValidacao = EntityUser::getUserByEmail($obUser->email);
        if ($emailValidacao instanceof EntityUser) {
            //REDIRECIONA O USUÁRIO
            $request->getRouter()->redirect('/admin/users/new?status=duplicated');
            return;
        };

        //CADASTRAR O USUARIO
        $obUser->cadastrar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users/' . $obUser->id . '/edit?status=created');
    }

    /**
     * Método responsável por gravar a atualização de um depoimento
     * 
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditUser($request, $id)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obUser = EntityUser::getTestimonyById($id);

        //VALÍDA INSTANCIA
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/testimonies');
            return;
        }

        //POST VARS
        $postVars = $request->getPostVars();

        //ATUALIZA A INSTANCIA
        $obUser->nome = $postVars['nome'] ?? $obUser->nome;
        $obUser->mensagem = $postVars['mensagem'] ?? $obUser->mensagem;
        $obUser->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/testimonies/' . $obUser->id . '/edit?status=updated');
    }

    /**
     * Método responsável por deletar um depoimento no banco de dados
     * 
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeleteUser($request, $id)
    {
        //OBTÉM O DEPOIMENTO DO BANCO DE DADOS
        $obUser = EntityUser::getTestimonyById($id);

        //VALÍDA INSTANCIA
        if (!$obUser instanceof User) {
            $request->getRouter()->redirect('/admin/testimonies');
            return;
        }

        //EXCLUI O DEPOIMENTO
        $obUser->excluir();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/testimonies?status=deleted');
    }
}
