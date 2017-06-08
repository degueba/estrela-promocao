<?php

namespace src\Helper;


class Session
{

    public static function logar($usuario){
        $_SESSION["usuario"] = $usuario;
    }

    public static function deslogar(){
        $_SESSION = null;
        session_unset();
        session_destroy();
    }

    public static function logado(){
        if(isset($_SESSION["usuario"])){
            return $_SESSION["usuario"];
        }else{
            return null;
        }
    }

    public static function logarAdmin($usuario){
        $_SESSION["admin"] = $usuario;
    }

    public static function deslogarAdmin(){
        $_SESSION = null;
        session_unset();
        session_destroy();
    }

    public static function logadoAdmin(){
        if(isset($_SESSION["admin"])){
            return $_SESSION["admin"];
        }else{
            return null;
        }
    }

}