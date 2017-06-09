<?php

namespace src\Controller;

use src\Helper\Original;
use src\Helper\Session;
use src\Model\UsuarioModel;
use src\Model\LojaModel;

class HomeController extends BaseController {

    public function index($request, $response, $service)
    {
        $lojaModel = new LojaModel();
        $container['uf'] = $lojaModel->findEstadosComLoja();
        $this->render('home', $container);
    }

    public function getCidades($request, $response, $service)
    {
        $container = [];
        $container['retorno']['msg'] = '';
        $container['retorno']['sucesso'] = true;
        if($request->method() == 'POST') {
            $post = $request->paramsPost();
            $uf = !empty($post['uf']) ? $post['uf'] : null;
            $lojaModel = new LojaModel();
            $container['cidades'] = $lojaModel->findCidadesComLoja($uf);
        }
        $this->json($container);
    }

    public function getLojas($request, $response, $service)
    {
        $container = [];
        $container['retorno']['msg'] = '';
        $container['retorno']['sucesso'] = true;
        if($request->method() == 'POST') {
            $post = $request->paramsPost();
            $loja = [];
            $loja['uf'] = !empty($post['uf']) ? $post['uf'] : null;
            $loja['cidade'] = !empty($post['cidade']) ? $post['cidade'] : null;
            $paginacao = ['page'=>$post['page'],'qtd'=>$post['qtd']];
            $lojaModel = new LojaModel();
            $container['lojas'] = $lojaModel->findLoja($loja, $paginacao);
        }
        $this->json($container);
    }

    public function cadastro($request, $response, $service)
    {
        $container = [];
        $container['retorno']['msg'] = '';
        $container['retorno']['sucesso'] = true;
        if($request->method() == 'POST'){
            $post = $request->paramsPost();
            if(!empty($post['nome']) && !empty($post['email']) && !empty($post['cpf']) && !empty($post['telefone']) && !empty($post['senha'])){
                $usuario = [];
                $usuario['cpf'] = $post['cpf'];

                $usuarioModel = new UsuarioModel();
                $retorno = $usuarioModel->findUsuario($usuario);

                if(!$retorno){
                    $usuario['email'] = $post['email'];
                    $usuario['nome'] = $post['nome'];
                    $usuario['telefone'] = $post['telefone'];
                    $usuario['senha'] = md5($post['senha']);

                    $usuarioId = $usuarioModel->addUsuario($usuario);
                    if($usuarioId){
                        $usuario['id'] = $usuarioId;
                        Session::logar($usuario);
                        $container['retorno']['msg'] = 'Seu cadastro foi efetuado com sucesso!';
                        $container['retorno']['redirecionar'] = '/cupom';
                    }else{
                        $container['retorno']['sucesso'] = false;
                        $container['retorno']['msg'] = 'Erro ao Cadastrar. Verifique seus dados.';
                    }
                }else{
                    $container['retorno']['sucesso'] = false;
                    $container['retorno']['msg'] = 'Você já é cadastrado, recupere a sua senha.';
                }
            }else{
                $container['retorno']['sucesso'] = false;
                $container['retorno']['msg'] = 'Preencha corretamente os campos obrigatórios.';
            }
        }
        if(Original::isAjax()){
            $this->json($container);
        }else{
            $this->render('home', $container);
        }
    }

    public function logar($request, $response, $service)
    {
        $container = [];
        $container['retorno']['msg'] = '';
        $container['retorno']['sucesso'] = true;
        if($request->method() == 'POST'){
            $post = $request->paramsPost();
            if(!empty($post['email']) && !empty($post['senha'])){
                $usuario = [];
                $usuario['email'] = $post['email'];
                $usuario['senha'] = md5($post['senha']);
                $usuarioModel = new UsuarioModel();
                $retorno = $usuarioModel->findUsuario($usuario);
                if($retorno){
                    Session::logar($retorno[0]);
                    $container['retorno']['redirecionar'] = '/cupom';
                    $container['retorno']['msg'] = 'Login efetuado com sucesso!';
                }else{
                    $container['retorno']['sucesso'] = false;
                    $container['retorno']['msg'] = 'Erro ao se logar. Verifique seus dados ou recupere a sua senha.';
                }
            }else{
                $container['retorno']['sucesso'] = false;
                $container['retorno']['msg'] = 'Preencha corretamente os campos obrigatórios e tente novamente.';
            }
        }
        if(Original::isAjax()){
            $this->json($container);
        }else{
            $this->render('/home', $container);
        }
    }

    public function deslogar($request, $response, $service)
    {
        Session::deslogar();
        $this->redirect('/');
    }

}