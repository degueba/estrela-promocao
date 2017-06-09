<?php
use src\Helper\Original;
use src\Helper\Session;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/default.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>



<body class="container-fluid user-profile">
    <div class="row">
        <nav class="navbar navbar-default">

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <a class="navbar-brand" href="#">
                            <img alt="Brand" src="images/logo_estrela.png">
                        </a>
                        <ul class="nav navbar-nav pull-right">
                            <li class="active title-promocao--volta---mundo"><a href="#" class="pull-left">Promoção volta ao mundo</a> <img class="pull-right" src="images/globo_promocao_volta_ao_mundo.png" width="120"></li>
                            <li class=""><a href="/deslogar"><i class="fa fa-sign-out"></i> Sair</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <div class="container ">
        <div class="row ">
            <div class="col-lg-8 ">
                <h2 class="text-center title ">
                    
                    
                    <?php
                    
                       echo Session::logado()["nome"]. ", você ";

                        if(is_array($container['cupom'])){
                            foreach($container['cupom'] as $c){
                                
                                if($c['numero'] > 1){
                                    echo "<strong>" . $c['numero'].' - '.$c['created'].' cupons</strong><br>';
                                } else {
                                    echo "<strong>" . $c['numero'].' - '.$c['created'].' cupom</strong><br>';
                                }
                            }
                        }else{
                            echo 'não tem <strong>nenhum cupom</strong>';
                        }
                    ?>
                    
                    </h2>
                <div class="box-user cadastrar-nota ">
                    <header>
                        <h3 class="title pull-left ">Cadastrar Nota Fiscal</h3> <small class="pull-right "> <i class="fa fa-warning "></i> Cadastre somente produtos Estrela</small>
                    </header>
                    <form class="col-lg-12" method="post" id="form-cadastrar-nota">
                       
                        <div class="form-group ">
                            <div>
                                <div class="col-lg-2">
                                    <label for=" ">Dia da compra</label>
                                    <input type="text " name="dia" id="dia" value="" class="form-control ">
                                </div>
                                <div class="col-lg-2">
                                    <label for=" ">Mês da compra</label>
                                    <input type="text " name="mes" id="mes" value="" class="form-control ">
                                </div>
                                <div class="col-lg-3">
                                    <label for=" ">Ano da compra</label>
                                    <input type="text " name="ano" id="ano" value="<?php echo date('Y'); ?>" class="form-control ">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <label for=" ">Número da nota fiscal</label>
                                <input type="text " name="numero" value=" " class="form-control ">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-lg-6">
                                <label for=" ">CNPJ da Loja</label>
                                <input type="text " name="cnpj" value=" " class="form-control ">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-lg-3 ">
                                <label for=" ">Estado da Loja*</label>
                                <input type="text " name="uf" value=" " class="form-control ">
                            </div>
                            <div class="col-lg-3 ">
                                <label for=" ">Cidade*</label>
                                <input type="text " name="cidade" value=" " class="form-control ">
                            </div>
                            <div class="col-lg-12">
                                <label for=" ">Site da Loja **</label>
                                <!-- small class="help-msg ">* Somente para compras online</small-->
                                <div class="input-group ">
                                    <span class="input-group-addon ">www.</span>
                                    <input type="text " name="site" value=" " class="form-control ">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="produto_estrela">
                                <div class="col-lg-6 nome_produto">
                                    <label for=" ">Produto(s) Estrela comprados</label>
                                    <input type="text " name="produto[]" value=" " class="form-control ">
                                </div>
                                <div class="col-lg-6 valor_produto">
                                    <label for=" ">Valor do produto</label>
                                    <input type="text " name="valor_produto[]" value=" " class="form-control mask_valor_produto">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-default btn-add-produto"><i class="fa fa-plus "></i> Adicionar produto estrela</button>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-lg-8 ">
                                <button class="pull-right btn btn-cadastrar ">Cadastrar</button>
                            </div>
                            <small class="pull-right help-msg ">* Somente para lojas físicas</small>
                            <small class="pull-right help-msg ">** Somente para lojas online</small>
                        </div>
                    </form>
                </div>
                <div class="row ">
                    <div class="col-lg-12 ">
                        <div class="box-user meu-perfil ">
                            <header>
                                <h3 class="title pull-left ">Meu Perfil</h3> <small class="pull-right "> <a class="btn btn-default btn-edit--perfil ">Editar Perfil</a></small>
                            </header>
                            <div class="content ">
                                <ol class="lista-editar--perfil ">

                                        <li><b>Nome:</b> <?php echo Session::logado()["nome"]; ?></li>
                                        <li><b>Email:</b> <?php echo Session::logado()["email"]; ?></li>
                                        <li><b>Telefone:</b> <?php echo Session::logado()["telefone"]; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 ">

                <div class="box-user meus-cupons ">
                    <header>
                        <h3 class="title pull-left ">Meus cupons</h3>
                    </header>
                    <div class="content ">
                        <ul>
                            <?php if(is_array($container['cupom'])){ ?>
                                <?php foreach($container['cupom'] as $c){ ?>
                                <li class="lista-meus--cupons ">
                                    <div class="pull-left ">
                                        <h6>Cupom</h6>
                                        <strong><?php echo $c['numero']; ?></strong>
                                    </div>
                                    <div class="pull-right ">
                                        <h6>Entrada</h6>
                                        <strong><?php echo Original::formataData($c['created']); ?></strong>
                                    </div>
                                </li>
                                <?php } ?>
                            <?php }else{ ?>
                                <li class="lista-meus--cupons ">
                                    <div class="text-center">
                                        <h3>Cadastre a nota fiscal somente com os produtos Estrela comprados para ganhar seus cupons.</h3>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <footer>
                        <?php echo count($container['cupom']); ?> cupom(ns)
                    </footer>
                </div>
            </div>
        </div>
    </div>

<div class="row">
    <?php
Original::loadBlock('footer');
?>
</div>