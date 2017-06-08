<?php

namespace src\Model;

class NotaModel extends BaseModel {

    public function findNota($nota)
    {
        $limit = false;
        $sql = "SELECT
                nota.id,
                nota.numero,
                nota.data_compra,
                nota.usuario_id
                FROM
                nota
                WHERE 1=1";
        if(!empty($nota['id'])){
            $sql .= " AND nota.id = ".$nota['id'];
            $limit = true;
        }
        if(!empty($nota['numero'])){
            $sql .= " AND nota.numero = '".$nota['numero']."'";
            $limit = true;
        }
        if(!empty($nota['usuario_id'])){
            $sql .= " AND nota.usuario_id = ".$nota['usuario_id'];
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

    public function addNota($nota)
    {
        if($this->DB->insert('nota', $nota)){
            return $this->DB->lastid();
        }else{
            return false;
        }
    }

    public function addNotaHasLoja($notaHasLoja)
    {
        if($this->DB->insert('nota_has_loja', $notaHasLoja)){
            return $this->DB->lastid();
        }else{
            return false;
        }
    }

    public function updateNota($nota, $id)
    {
        $where_clause = array(
            'id' => $id
        );
        $this->DB->update('nota', $nota, $where_clause, 1);
        return true;
    }
}