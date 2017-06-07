<?php

namespace src\Controller;

use src\Helper\Original;
use src\Helper\Session;
use src\Model\UsuarioModel;
use src\Model\CupomModel;

class CupomController extends BaseController {


    public function index($request, $response, $service)
    {
        if(!Session::logado()){
            $this->redirect('/');
        }

        $container = [];

        if($request->method() == 'POST'){
            $post = $request->paramsPost();
            if(!empty($post['nome']) && !empty($post['email']) && !empty($post['telefone']) && !empty($post['senha'])){

            }else{
                $container['retorno']['sucesso'] = false;
                $container['retorno']['msg'] = 'Preencha corretamente os campos obrigatórios.';
            }
        }

        $cupomModel = new CupomModel();
        $cupom = [];
        $cupom['usuario_id'] = Session::logado()['id'];
        $container['cupom'] = $cupomModel->findCupom($cupom);

        $this->render('cupom', $container);
    }


}