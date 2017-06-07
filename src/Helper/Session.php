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
            return true;
        }else{
            return false;
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
            return true;
        }else{
            return false;
        }
    }

}