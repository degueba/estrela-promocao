<?php

namespace src\Controller;

use src\Helper\Original;
use src\Helper\Session;
use src\Model\UsuarioModel;
use src\Model\CupomModel;
use src\Model\NotaModel;

class CupomController extends BaseController {


    public function index($request, $response, $service)
    {
        if(!Session::logado()){
            $this->redirect('/');
        }

        $container = [];
        $container['retorno']['sucesso'] = true;
        if($request->method() == 'POST'){
            $post = $request->paramsPost();
            if(!empty($post['numero']) && !empty($post['data_compra']) && !empty($post['loja']) && !empty($post['cnpj'])){
                $nota = [];
                $nota['numero'] = $post['numero'];
                $notaModel = new NotaModel();
                if(!$notaModel->findNota($nota)){
                    $valorProdutos = 0;
                    foreach ($post['produto'] as $k => $value) {
                        $valorProdutos += (int)$value;
                    }
                    if($valorProdutos >= VALOR_GASTO_POR_CUPOM){
                        // Inserir loja
                        foreach ($post['produto'] as $k => $value) {
                            $valorProdutos += (int)$value;
                        }
                    }else{
                        $container['retorno']['sucesso'] = false;
                        $container['retorno']['msg'] = 'O valor total de produtos estrela não foram suficientes para gerar cupons!';
                    }
                }else{
                    $container['retorno']['sucesso'] = false;
                    $container['retorno']['msg'] = 'Essa nota fiscal já foi cadastrada!';
                }
            }else{
                $container['retorno']['sucesso'] = false;
                $container['retorno']['msg'] = 'Preencha corretamente todos os campos. Você precisa cadastrar todos os brinquedos estrela da nota fiscal';
            }
        }

        $cupomModel = new CupomModel();
        $cupom = [];
        $cupom['usuario_id'] = Session::logado()['id'];
        $container['cupom'] = $cupomModel->findCupom($cupom);

        $this->render('cupom', $container);
    }


}