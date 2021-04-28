<?php

namespace App\Http\Middlewares;

use App\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogin
{
    /**
     * Método responsável por executar o middleware
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        //VERIFICA SE O USER EDTÁ LOGADO
        if (!SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect('/admin/login');
        }

        //CONTINUA A EXECUÇÃO
        return $next($request);
    }
}
