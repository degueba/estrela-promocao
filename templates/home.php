<?php
use src\Helper\Original;
Original::loadBlock('head');
?>

<body>

<?php
if(isset($container['retorno'])){
    echo $container['retorno']['msg'].'<hr>';
}
?>

LOGIN:<br>
<form method="post" action="/logar">
    <input type="email" name="email" placeholder="Seu email">
    <br>
    <input type="password" name="senha" placeholder="Sua senha">
    <br>
    <button type="submit">LOGAR</button>
</form>

<hr>
CADASTRO:<br>
<form method="post" action="/cadastro">
    <input type="hidden" name="tipo_retorno" value="ajax">
    <input type="text" name="nome" placeholder="Seu nome">
    <br>
    <input type="email" name="email" placeholder="Seu email">
    <br>
    <input type="text" name="telefone" placeholder="Seu telefone">
    <br>
    <input type="text" name="cpf" placeholder="Seu CPF">
    <br>
    <input type="password" name="senha" placeholder="Sua senha">
    <br>
    <button type="submit">CADASTRAR</button>
</form>

</body>

<?php
Original::loadBlock('footer');
?>