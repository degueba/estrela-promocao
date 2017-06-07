<?php

namespace src\Controller;

use src\Helper\Original;
use src\Helper\Session;
use src\Model\UsuarioModel;

class CupomController extends BaseController {


    public function index($request, $response, $service)
    {
        $container = [];
        $container['retorno']['msg'] = '';
        $container['retorno']['sucesso'] = true;
        if($request->method() == 'POST'){
            $post = $request->paramsPost();
            if(!empty($post['nome']) && !empty($post['email']) && !empty($post['telefone']) && !empty($post['senha'])){
                $usuario = [];
                $usuario['nome'] = $post['nome'];
                $usuario['email'] = $post['email'];
                $usuario['telefone'] = $post['telefone'];
                $usuario['senha'] = $post['senha'];

                $usuarioModel = new UsuarioModel();
                $usuarioId = $usuarioModel->addUsuario($usuario);
                if($usuarioId){
                    $usuario['id'] = $usuarioId;
                    Session::logar($usuario);
                    $container['retorno']['msg'] = 'Seu cadastro foi efetuado com sucesso!';
                }else{
                    $container['retorno']['sucesso'] = false;
                    $container['retorno']['msg'] = 'Erro ao Cadastrar. Você pode já ser cadastrado, tente recuperar a sua senha.';
                }
            }else{
                $container['retorno']['sucesso'] = false;
                $container['retorno']['msg'] = 'Preencha corretamente os campos obrigatórios.';
            }
        }
        if(Original::isAjax()){
            $this->json($container);
        }else{
            $this->render('cupom', $container);
        }
    }


}