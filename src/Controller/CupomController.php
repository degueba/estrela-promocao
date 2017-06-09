<?php

namespace src\Controller;

use src\Helper\Original;
use src\Helper\Session;
use src\Model\LojaModel;
use src\Model\UsuarioModel;
use src\Model\CupomModel;
use src\Model\NotaModel;
use src\Model\ProdutoModel;

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
            if(!empty($post['numero']) && !empty($post['dia']) && !empty($post['mes']) && !empty($post['ano']) && !empty($post['cnpj'])){
                $nota = [];
                $nota['numero'] = $post['numero'];
                $notaModel = new NotaModel();
                if(!$notaModel->findNota($nota)){
                    $valorProdutos = 0;
                    foreach ($post['valor_produto'] as $k => $value) {
                        $valor = str_replace(['.', ','],['', '.'],$value);
                        $valorProdutos += (int)$valor;
                    }
                    if($valorProdutos >= VALOR_GASTO_POR_CUPOM){
                        // Pegar dados da loja
                        $loja = [];
                        $loja['cnpj'] = preg_replace('/[^-9]/', '', $post['cnpj']);
                        if(!empty($post['uf'])){
                            $loja['uf'] = $post['uf'];
                        }
                        if(!empty($post['cidade'])){
                            $loja['cidade'] = $post['cidade'];
                        }
                        $lojaModel = new LojaModel();
                        $retornoLoja = $lojaModel->findLoja($loja);
                        if($retornoLoja){
                            // Inserir nota
                            $nota = [];
                            $nota['numero'] = $post['numero'];
                            $nota['usuario_id'] = Session::logado()['id'];
                            $nota['data_compra'] = $post['ano'].'-'.$post['mes'].'-'.$post['dia'];
                            if(!empty($post['uf'])){
                                $nota['uf'] = $post['uf'];
                            }
                            if(!empty($post['cidade'])){
                                $nota['cidade'] = $post['cidade'];
                            }
                            if(!empty($post['site'])){
                                $nota['site'] = $post['site'];
                            }
                            $nota['valor_total_estrela'] = $valorProdutos;
                            $notaModel = new NotaModel();
                            $notaId = $notaModel->addNota($nota);

                            // Associa a nota a loja
                            $notaHasLoja = [];
                            $notaHasLoja['nota_id'] = $notaId;
                            $notaHasLoja['loja_id'] = $retornoLoja[0]['id'];
                            $notaModel->addNotaHasLoja($notaHasLoja);

                            // Sortear cupons
                            $cupomModel = new CupomModel();
                            $cuponsSorteados = $cupomModel->findCupom([], true);
                            // Mistura os cupons
                            shuffle($cuponsSorteados);
                            // Quantidade de cupons que o usuário tem direito
                            $qtdCupons = (int)($valorProdutos / VALOR_GASTO_POR_CUPOM);
                            for($x=0; $x<$qtdCupons; $x++) {
                                // Dar cupons dos sorteados
                                $cupom = [];
                                $cupom['nota_id'] = $notaId;
                                $cupom['usuario_id'] = Session::logado()['id'];
                                $cupomModel->updateCupom($cupom, $cuponsSorteados[$x]['id']);
                            }
                            // Insere os produtos
                            foreach ($post['valor_produto'] as $k => $value) {
                                $valor = str_replace(['.', ','],['', '.'],$value);
                                if($valor > 0){
                                    $produto = [];
                                    $produto['nota_id'] = $notaId;
                                    $produto['nome'] = $post['produto'][$k];
                                    $produto['valor'] = $valor;
                                    $produtoModel = new ProdutoModel();
                                    $produtoModel->addProduto($produto);
                                }
                            }
                        }else{
                            $container['retorno']['sucesso'] = false;
                            $container['retorno']['msg'] = 'A loja informada não particida da promoção! Verifique o CNPJ digitado.';
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