<?php
use src\Helper\Original;
?>

<body>

<?php
if(isset($container['retorno']['msg'])){
    echo $container['retorno']['msg'].'<hr>';
}
?>

CUPONS:<br>
<?php
if(isset($container['cupom'])){
    foreach($container['cupom'] as $c){
        echo $c['serie'].' - '.$c['numero'].' - '.$c['created'].'<br>';
    }
}else{
    echo 'nenhum cupom';
}
?>

<hr>
CADASTRO:<br>
<form method="post" action="">
    <input type="text" name="numero" placeholder="Numero da nota">
    <br>
    <input type="text" name="dia" placeholder="Dia da compra"> <input type="text" name="mes" placeholder="Mes da compra"> <input type="text" name="ano" placeholder="Ano da compra">
    <br>
    <input type="text" name="cnpj" placeholder="CNPJ da loja">
    <br>
    <input type="text" name="uf" placeholder="Estado">
    <br>
    <input type="text" name="cidade" placeholder="Cidade">
    <br>
    <input type="text" name="site" placeholder="Site da loja">
    <br>
    produtos:
    <br>
    <input type="text" name="produto[]" placeholder="Nome do produto">
    <br>
    <input type="text" name="valor_produto[]" placeholder="valor">
    <br>
    <input type="text" name="produto[]" placeholder="Nome do produto">
    <br>
    <input type="text" name="valor_produto[]" placeholder="Valor">
    <br>
    <button type="submit">CADASTRAR</button>
</form>

</body>

<?php
Original::loadBlock('footer');
?>