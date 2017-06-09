<?php

namespace src\Model;

class LojaModel extends BaseModel {

    public function findLoja($loja)
    {
        $limit = false;
        $sql = "SELECT
                loja.id,
                loja.nome,
                loja.cnpj
                FROM
                loja
                WHERE 1=1";
        if(!empty($loja['id'])){
            $sql .= " AND loja.id = ".$loja['id'];
            $limit = true;
        }
        if(!empty($loja['cnpj'])){
            $sql .= " AND loja.cnpj = '".$loja['cnpj']."'";
            $limit = true;
        }
        if($limit){
            $sql .= " LIMIT 0,1";
        }
        //echo $sql; die;
        $retorno = $this->DB->get_results($sql);
        if(count($retorno) > 0){
            return $retorno;
        }else{
            return null;
        }
    }

    public function findEstadosComLoja()
    {
        $sql = "SELECT DISTINCT 
                loja.uf
                FROM
                loja WHERE loja.uf IS NOT NULL";
        //echo $sql; die;
        $retorno = $this->DB->get_results($sql);
        if(count($retorno) > 0){
            return $retorno;
        }else{
            return null;
        }
    }

    public function findCidadesComLoja($uf = null)
    {
        $sql = "SELECT DISTINCT 
                loja.uf,
                loja.cidade
                FROM
                loja WHERE loja.uf IS NOT NULL";
        if($uf){
            $sql .= " AND loja.uf = '".$uf."'";
        }
        //echo $sql; die;
        $retorno = $this->DB->get_results($sql);
        if(count($retorno) > 0){
            return $retorno;
        }else{
            return null;
        }
    }

    public function addLoja($loja)
    {
        if($this->DB->insert('loja', $loja)){
            return $this->DB->lastid();
        }else{
            return false;
        }
    }

    public function updateLoja($loja, $id)
    {
        $where_clause = array(
            'id' => $id
        );
        $this->DB->update('nota', $loja, $where_clause, 1);
        return true;
    }
}