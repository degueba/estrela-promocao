<?php

namespace src\Model;

class UsuarioModel extends BaseModel {

    public function findUsuario($usuario)
    {
        $sql = "SELECT * FROM usuario WHERE 1=1";
        if(!empty($usuario['id'])){
            $sql = " AND usuario.id = ".$usuario['id'];
        }
        if(!empty($usuario['email'])){
            $sql = " AND usuario.email = '".$usuario['email']."''";
        }
        if(!empty($usuario['senha'])){
            $sql = " AND usuario.senha = '".$usuario['senha']."''";
        }
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
            return $this->DB->lastid();
        }else{
            return false;
        }
    }
}