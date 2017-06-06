<?php

namespace src\Model;

class Usuario extends BaseModel {

    public function findUsuario($usuario)
    {
        $sql = "SELECT * FROM usuario";
        $retorno = $this->DB->get_results($sql);
        if(count($retorno) > 0){
            return $retorno;
        }else{
            return null;
        }
    }

    public function addUsuario($usuario)
    {
        if($this->DB->insert('usuario', $usuario)){
            return true;
        }else{
            return false;
        }
    }
}