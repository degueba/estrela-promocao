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
                $dataInicioPromocao = strtotime('2017-06-14 00:00:00');
                $dataNota = strtotime($post['ano'].'-'.$post['mes'].'-'.$post['dia'].' 00:00:00');
                if($dataNota > $dataInicioPromocao){
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

                            $loja['cnpj'] = preg_replace('/[^0-9]/', '', $post['cnpj']);

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
                                $cuponsDistribuidos = '';
                                for($x=0; $x<$qtdCupons; $x++) {
                                    // Dar cupons dos sorteados
                                    $cupom = [];
                                    $cupom['nota_id'] = $notaId;
                                    $cupom['usuario_id'] = Session::logado()['id'];
                                    $cupomModel->updateCupom($cupom, $cuponsSorteados[$x]['id']);
                                    $cuponsDistribuidos .= $cuponsSorteados[$x]['serie'].' - '.$cuponsSorteados[$x]['numero'].'<br>';
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

                                $mail = new \PHPMailer;
                                $mail->isSMTP();                                      // Set mailer to use SMTP
                                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                $mail->Username = 'ecommerce@estrela.com.br';                 // SMTP username
                                $mail->Password = 'estrela1234';                           // SMTP password
                                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                                $mail->Port = 587;                                    // TCP port to connect to

                                $mail->setFrom('ecommerce@estrela.com.br', 'Estrela 80 anos');
                                $mail->addAddress(Session::logado()['email'], Session::logado()['nome']);     // Add a recipient

                                $mail->isHTML(true);                                  // Set email format to HTML

                                $mail->Subject = 'Estrela - Cupons da sorte';
                                $mail->Body    = '<table class="display: block; margin; 0 auto;" align="center">
                                                <thead>
                                                    <tr style="background-image: url(http://admin80anos.estrela.originalmedia.com.br/email/images/topo-cadastro-usuario.jpg); 
                                                    height: 205px;
                                                    width: 633px;
                                                    display: block;">
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="background-color: #f3f3f3; height: auto; padding:20px 0; width: 633px; display: block; padding-top: 40px;">
                                                        <td style="background-color: #fff; width: 550px; height: auto; border-radius: 30px; border: 1px solid #999; margin: 0 auto; display: block;">
                                                            <p style="width: 80%;
                                                text-align: center;
                                                color: #999;
                                                font-size: 25px;
                                                margin: 30px auto;">
                                                                Oi, '.Session::logado()['nome'].'! <br> Parab&eacute;ns! Voc&ecirc; ganhou n&uacute;mero(s) da sorte para concorrer a uma viagem pelo mundo!<br><br> 
                                                                '.$cuponsDistribuidos.'
                                                                <br> O pr&ecirc;mio &eacute; de R$ 40.000,00 (quarenta mil reais), entregue
                                                                em forma de pacote de viagem nacional ou internacional, e voc&ecirc; ainda pode escolher o(s) destino(s) para viajar sozinho ou acompanhado.
                                                                <br> Confira o regulamento da promo&ccedil;&atilde;o e <br><br> BOA SORTE!<br>
                                            
                                                            </p>
                                                            <p>
                                                                <a href="http://voltaaomundo.estrela.com.br#regulamento" target="_blank" style="    width: 220px;
                                                background-color: #B14599;
                                                padding: 15px;
                                                margin: 0 auto;
                                                display: block;
                                                border-radius: 40px;
                                                text-align: center;
                                                color: #fff;
                                                font-size: 20px;
                                                text-decoration: none;">Ver regulamento</a>
                                                                <a href="http://voltaaomundo.estrela.com.br#cadastro-ou-login" target="_blank" style="    width: 220px;
                                                background-color: #F38620;
                                                padding: 15px;
                                                margin: 20px auto;
                                                display: block;
                                                border-radius: 40px;
                                                text-align: center;
                                                color: #fff;
                                                font-size: 20px;
                                                text-decoration: none;">Entrar</a>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tfoot style="display: block; width: 100%; height: 30px; background-color: #0065A3;"></tfoot>
                                                </tbody>
                                            
                                            </table>';

                                $mail->send();
                                $container['retorno']['msg'] = 'Parabéns! Sua nota fiscal foi cadastrada com sucesso. Boa sorte!';
                            }else{
                                $container['retorno']['sucesso'] = false;
                                $container['retorno']['msg'] = 'A loja informada não participa da promoção! Verifique o CNPJ digitado.';
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
                    $container['retorno']['msg'] = 'Essa compra está fora da data da promoção!';
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
        
        $lojaModel = new LojaModel();
        $container['uf'] = $lojaModel->findEstadosComLoja();


        $this->render('cupom', $container);
    }


}