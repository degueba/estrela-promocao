<?php
use src\Helper\Original;
?>

<body>

<?php
if(isset($container['retorno'])){
    echo $container['retorno']['msg'].'<hr>';
}
?>



</body>

<?php
Original::loadBlock('footer');
?>