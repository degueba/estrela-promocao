<?php

namespace src\Helper;


class Original
{

    public static function isAjax(){
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? $_SERVER['HTTP_X_REQUESTED_WITH'] : null;
        return (strtolower($isAjax) === 'xmlhttprequest');
    }

    public static function loadBlock($block, $container = null){
        require PATH_BLOCKS.$block.'.php';
    }

    public static function log($tipo, $message){
        $arquivo = ROOT.'logs/'.$tipo.'.log';
        $fp = '';
        if(file_exists($arquivo)){
            $fp = fopen($arquivo,"a+");
        }else{
            $fp = fopen($arquivo,"w");
        }
        fputs($fp,$message."\r\n\r\n");
        fclose($fp);
    }

    public static function formataDataBanco($data){
        return implode("-",array_reverse(explode("/",$data)));
    }
}