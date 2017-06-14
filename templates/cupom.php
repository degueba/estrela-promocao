<?php
use src\Helper\Original;
use src\Helper\Session;
Original::loadBlock('head');
?>

<body class="container-fluid user-profile">
    <!-- MENU LATERAL MOBILE -->
    <nav class="hidden-lg nav-lateral-mobile">
        <!-- La cruz para cerrar el menu lateral -->
        <div class="cruz">
            <!-- Los span van a ser las dos barras de la cruz! -->
            <span></span>
            <span></span>
        </div>
        
        <!-- imagen -->
        <!--div class="img"></div -->
        
        <ul>
            <li><a href="#form-cadastrar-nota" class="scroll-suave">Cadastrar nota fiscal</a></li>
            <li><a href="#cupons-cadastrados" class="scroll-suave">Cupons cadastrados</a></li>
            <li><a href="#meu-perfil" class="scroll-suave">Meu Perfil</a></li>
            <li class=""><a href="/deslogar"><i class="fa fa-sign-out"></i> Sair</a></li>
        </ul>
    </nav>

    <div class="row">
        <nav class="navbar navbar-default">

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="http://voltaaomundo.estrela.com.br/" class="navbar-brand" href="#">
                            <img  alt="Brand" src="images/logo_estrela.png">
                        </a>
                        <!-- HAMBURGUER -->
                    <div class="barra-sup hidden-lg">
                        <div class="hamburguer">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <!---->
                        <ul class="nav navbar-nav pull-right">
                            <li class="active title-promocao--volta---mundo"><a href="#" class="pull-left">Promoção volta ao mundo</a> <img class="hidden-xs pull-right" src="images/globo_promocao_volta_ao_mundo.png" width="120"></li>
                            <li class="hidden-xs"><a href="/deslogar"><i class="fa fa-sign-out"></i> Sair</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        
    </div>
    <div class="container ">
        <?php  if(isset($container['retorno']['msg'])) : ?>
            <div class="alert alert-<?php echo ($container['retorno']['sucesso'] ? 'success' : 'danger')  ?>"><?php echo $container["retorno"]["msg"]; ?></div>
        <?php endif; ?>
        <div class="row ">
            <div class="col-lg-8 ">
                <h2 class="text-center title ">
                    <?php
                    
                       echo Session::logado()["nome"]. ", você ";

                        if(is_array($container['cupom'])){  
                            $qtdCupom = count($container['cupom']);
                            if($qtdCupom > 1){
                                echo "<strong> têm " . $qtdCupom.' cupons</strong><br>';
                            } else {
                                echo "<strong> tem " . $qtdCupom.'  cupom</strong><br>';
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
                    <form class="col-lg-12 col-xs-12" method="post" id="form-cadastrar-nota">
                       
                        <div class="form-group ">
                            <div>
                                <div class="col-lg-2 col-xs-12">
                                    <label for=" ">Dia da compra*</label>
                                    <input type="text" required="required" name="dia" id="dia" class="form-control ">
                                </div>
                                <div class="col-lg-2 col-xs-12">
                                    <label for=" ">Mês da compra*</label>
                                    <input type="text" required="required" name="mes" id="mes" class="form-control ">
                                </div>
                                <div class="col-lg-3 col-xs-12">
                                    <label for=" ">Ano da compra*</label>
                                    <input type="text" required="required" name="ano" id="ano" value="<?php echo date('Y'); ?>" class="form-control ">
                                </div>
                            </div>
                            <div class="col-lg-5 col-xs-12">
                                <label for=" ">Número da nota fiscal</label>
                                <input type="text" required name="numero" class="form-control ">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-lg-6 col-xs-12">
                                <label for=" ">CNPJ da Loja</label>
                                <input type="text" required name="cnpj" class="form-control ">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-lg-3 col-xs-12">
                                <label for="">Estado da Loja**</label>
                                 <select class="form-control" name="uf" id="slt_estados">
                                        <option value="">Estado</option>
                                        <?php foreach($container["uf"] as $uf){ ?>
                                             <option value="<?php echo $uf["uf"]; ?>"><?php echo $uf["uf"]; ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-xs-12">
                                <label for="">Cidade**</label>
                                <select class="form-control"  name="cidade" id="slt_cidades">
                                        <option value="" selected>Cidade</option>
                                </select>
                            </div>
                            <div class="col-lg-12 col-xs-12">
                                <label for="">Site da Loja ***</label>
                                <!-- small class="help-msg ">* Somente para compras online</small-->
                                <div class="input-group">
                                    <span class="input-group-addon ">www.</span>
                                    <input type="text" name="site" class="form-control ">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="produto_estrela">
                                <div class="col-lg-6 nome_produto">
                                    <label for=" ">Produto Estrela comprado</label>
                                    <input type="text" required name="produto[]"  class="form-control ">
                                </div>
                                <div class="col-lg-6 valor_produto">
                                    <label for="">Valor do produto</label>
                                    <input type="text" required name="valor_produto[]"  class="form-control mask_valor_produto">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12 col-xs-12">
                                <button type="button" class="btn btn-default btn-add-produto"><i class="fa fa-plus "></i> Adicionar produto estrela</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-8  col-xs-11">
                                <button type="submit" class="pull-right btn btn-cadastrar ">Cadastrar</button>
                            </div>
                            
                            <div class="col-lg-12">
                                <small class="help-msg">* Somente compras realizadas a partir do dia 15/06/2017</small><br>
                                <small class="help-msg">** Somente para compras realizadas em lojas físicas</small><br>
                                <small class="help-msg">*** Somente para compras realizadas em lojas online</small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row" id="meu-perfil">
                    <div class="col-lg-12 col-xs-12">
                        <div class="box-user meu-perfil">
                            <header>
                                <h3 class="title pull-left">Meu Perfil</h3> <small class="pull-right"> <!-- a class="btn btn-default btn-edit--perfil ">Editar Perfil</a --></small>
                            </header>
                            <div class="content">
                                <ol class="lista-editar--perfil">
                                    <li><b>Nome:</b> <?php echo Session::logado()["nome"]; ?></li>
                                    <li><b>Email:</b> <?php echo Session::logado()["email"]; ?></li>
                                    <li><b>CPF:</b> <?php echo Session::logado()["cpf"]; ?></li>
                                    <li><b>Telefone:</b> <?php echo Session::logado()["telefone"]; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 ">

                <div class="box-user meus-cupons" id="cupons-cadastrados">
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
                                        <strong><?php echo $c['serie'] . '-' .$c['numero']; ?></strong>
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

<?php
Original::loadBlock('footer');
?>

<?php if($container['retorno']['sucesso'] && !empty($container['retorno']['msg'])){ ?>
    <script>
        swal(
            'Sucesso!',
            '<?php echo $container['retorno']['msg']; ?>',
            'success'
        )
    </script>
<?php } ?>
