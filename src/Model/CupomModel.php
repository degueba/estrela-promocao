<?php

namespace src\Model;

class CupomModel extends BaseModel {

    public function findCupom($cupom, $sortear = false)
    {
        $sql = "SELECT
                cupom.id,
                cupom.numero,
                cupom.serie,
                cupom.nota_id,
                cupom.usuario_id
                FROM
                cupom
                INNER JOIN nota ON nota.id = cupom.nota_id
                INNER JOIN usuario ON usuario.id = cupom.usuario_id";
        if(!empty($cupom['id'])){
            $sql .= " AND cupom.id = ".$cupom['id'];
        }
        if(!empty($cupom['numero'])){
            $sql .= " AND cupom.numero = '".$cupom['numero']."'";
        }
        if(!empty($cupom['usuario_id'])){
            $sql .= " AND cupom.usuario_id = ".$cupom['usuario_id'];
        }
        if(!empty($cupom['nota_id'])){
            $sql .= " AND cupom.nota_id = ".$cupom['nota_id'];
        }

        if($sortear){
            $sql .= " AND cupom.usuario_id IS NULL AND cupom.nota_id IS NULL ORDER BY RAND() LIMIT 0,10000";
        }

        $retorno = $this->DB->get_results($sql);
        if(count($retorno) > 0){
            return $retorno;
        }else{
            return null;
        }
    }

    public function addCupom($cupom)
    {
        if($this->DB->insert('cupom', $cupom)){
            return $this->DB->lastid();
        }else{
            return false;
        }
    }

    public function updateCupom($cupom, $id)
    {
        $where_clause = array(
            'id' => $id
        );
        $this->DB->update('cupom', $cupom, $where_clause, 1);
        return true;
    }
}