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

                        $mail->Subject = 'Promoção Volta ao Mundo Estrela 80 anos - Cadastro';
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
                                                    <td style="background-color: #fff; width: 500px; height: auto; border-radius: 30px; border: 1px solid #999; margin: 0 auto; display: block;">
                                                        <p style="width: 80%;
                                            text-align: center;
                                            color: #999;
                                            font-size: 25px;
                                            margin: 30px auto;">
                                                            Oi, '.Session::logado()['nome'].'! <br> Seu cadastro foi efetuado com sucesso. <br> Agora comece a torcida para ganhar essa promo&ccedil;&atilde;o! <br> N&atilde;o deixe de cadastrar sua nota fiscal para receber o n&uacute;mero da sorte. <br> Confira o regulamento
                                                            da promo&ccedil;&atilde;o e <br> BOA SORTE!
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
                    }else{
                        $container['retorno']['sucesso'] = false;
                        $container['retorno']['msg'] = 'Erro ao Cadastrar. Verifique seus dados.';
                    }
                }else{
                    $container['retorno']['sucesso'] = false;
                    $container['retorno']['msg'] = 'Parece que você já possui cadastro. Faça login para entrar no site.';
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

    public function esqueciSenha($request, $response, $service)
    {
        $container = [];
        $container['retorno']['msg'] = '';
        $container['retorno']['sucesso'] = true;

        if($request->method() == 'POST'){
            $post = $request->paramsPost();
            if(!empty($post['email'])){
                $usuario = [];
                $usuario['email'] = $post['email'];
                $usuarioModel = new UsuarioModel();
                $retorno = $usuarioModel->findUsuario($usuario);
                if($retorno){
                    $novaSenha = date('is');

                    $mail = new \PHPMailer;
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = 'ecommerce@estrela.com.br';                 // SMTP username
                    $mail->Password = 'estrela1234';                           // SMTP password
                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587;                                    // TCP port to connect to

                    $mail->setFrom('ecommerce@estrela.com.br', 'Estrela 80 anos');
                    $mail->addAddress($post['email']);     // Add a recipient

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = 'Promoção Volta ao Mundo Estrela 80 anos - Esqueci minha senha';
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
                                                    <td style="background-color: #fff; width: 500px; height: auto; border-radius: 30px; border: 1px solid #999; margin: 0 auto; display: block;">
                                                        <p style="width: 80%;
                                            text-align: center;
                                            color: #999;
                                            font-size: 25px;
                                            margin: 30px auto;">
                                                            Sua senha de acesso é: '.$novaSenha.'
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

                    if($mail->send()) {
                        $usuario = [];
                        $usuario['senha'] = md5($novaSenha);
                        $usuarioModel->updateUsuario($usuario, $retorno[0]['id']);
                        $container['retorno']['msg'] = 'Enviamos para o email '.$post['email'].' sua senha de acesso!';
                    } else {
                        $container['retorno']['sucesso'] = false;
                        $container['retorno']['msg'] = 'O email não pode ser enviado. Tente mais tarde.';
                    }
                }else{
                    $container['retorno']['sucesso'] = false;
                    $container['retorno']['msg'] = 'Email não encontrado.';
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