<?php
use src\Helper\Original;
Original::loadBlock('head');
?>

<body>
LOGIN:<br>
<form method="post">
    <input type="email" name="email" placeholder="Seu email">
    <br>
    <input type="password" name="senha" placeholder="Sua senha">
    <br>
    <button type="submit">LOGAR</button>
</form>

<hr>
CADASTRO:<br>
<form method="post">
    <input type="text" name="nome" placeholder="Seu nome">
    <br>
    <input type="email" name="email" placeholder="Seu email">
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