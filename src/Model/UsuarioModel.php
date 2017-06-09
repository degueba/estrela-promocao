<?php

namespace src\Model;

class UsuarioModel extends BaseModel {

    public function findUsuario($usuario)
    {
        $limit = false;
        $sql = "SELECT * FROM usuario WHERE 1=1";
        if(!empty($usuario['id'])){
            $sql .= " AND usuario.id = ".$usuario['id'];
            $limit = true;
        }
        if(!empty($usuario['email'])){
            $sql .= " AND usuario.email = '".$usuario['email']."'";
            $limit = true;
        }
        if(!empty($usuario['cpf'])){
            $sql .= " AND usuario.cpf = '".$usuario['cpf']."'";
            $limit = true;
        }
        if(!empty($usuario['senha'])){
            $sql .= " AND usuario.senha = '".$usuario['senha']."'";
        }

        if($limit){
            $sql .= " LIMIT 0,1";
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

    public function updateUsuario($usuario, $id)
    {
        $where_clause = array(
            'id' => $id
        );
        $this->DB->update('usuario', $usuario, $where_clause, 1);
        return true;
    }
}