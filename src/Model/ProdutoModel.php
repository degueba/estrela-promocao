<?php

namespace src\Model;

class ProdutoModel extends BaseModel {

    public function findProduto($produto)
    {
        $sql = "SELECT
                *
                FROM
                produto
                WHERE 1=1";
        if(!empty($produto['id'])){
            $sql .= " AND produto.id = ".$produto['id'];
        }
        if(!empty($produto['nota_id'])){
            $sql .= " AND produto.nota_id = ".$produto['nota_id'];
        }

        $retorno = $this->DB->get_results($sql);
        if(count($retorno) > 0){
            return $retorno;
        }else{
            return null;
        }
    }

    public function addProduto($produto)
    {
        if($this->DB->insert('produto', $produto)){
            return $this->DB->lastid();
        }else{
            return false;
        }
    }

    public function updateProduto($produto, $id)
    {
        $where_clause = array(
            'id' => $id
        );
        $this->DB->update('produto', $produto, $where_clause, 1);
        return true;
    }
}