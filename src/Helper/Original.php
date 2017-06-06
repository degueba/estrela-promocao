<?php

namespace src\Helper;


class Original
{

    public function teste(){
        echo 'TESTE';
    }

    public static function loadBlock($block, $container = null){
        require PATH_BLOCKS.$block.'.php';
    }
}