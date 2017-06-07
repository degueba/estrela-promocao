<?php
use src\Helper\Original;
?>

<body>

<?php
if(isset($container['retorno'])){
    echo $container['retorno']['msg'].'<hr>';
}
?>

CUPONS:<br>
<?php
if(isset($container['cupom'])){
    foreach($container['cupom'] as $c){
        echo $c['numero'].' - '.$c['created'].'<br>';
    }
}else{
    echo 'nenhum cupom';
}
?>

<hr>
CADASTRO:<br>
<form method="post" action="">
    <input type="text" name="numero" placeholder="Numero">
    <br>
    <input type="email" name="data_compra" placeholder="Data da compra">
    <br>
    <input type="text" name="telefone" placeholder="Seu telefone">
    <br>
    <input type="password" name="senha" placeholder="Sua senha">
    <br>
    <button type="submit">CADASTRAR</button>
</form>

</body>

<?php
Original::loadBlock('footer');
?>