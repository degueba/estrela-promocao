<?php

namespace src\Model;

class LojaModel extends BaseModel {

    public function findLoja($loja, $paginacao = null)
    {
        $limitOne = false;
        $sql = "SELECT
                loja.id,
                loja.nome,
                loja.cnpj,
                loja.uf,
                loja.cidade,
                loja.endereco,
                loja.endereco_numero
                FROM
                loja
                WHERE 1=1";
        if(!empty($loja['id'])){
            $sql .= " AND loja.id = ".$loja['id'];
            $limitOne = true;
        }
        if(!empty($loja['cnpj'])){
            $sql .= " AND loja.cnpj = '".$loja['cnpj']."'";
            $limitOne = true;
        }
        if(!empty($loja['uf'])){
            $sql .= " AND loja.uf = '".$loja['uf']."'";
            $limitOne = true;
        }
        if(!empty($loja['cidade'])){
            $sql .= " AND loja.cidade = '".$loja['cidade']."'";
            $limitOne = true;
        }
        $pagina = $paginacao['page']<=1?0:($paginacao['page']-1)*$paginacao['qtd'];
        if($paginacao){
            $sql .= " AND loja.uf IS NOT NULL
                    LIMIT ".$pagina.','.$paginacao['qtd'];
        }else{
            if($limitOne){
                $sql .= " LIMIT 0,1";
            }
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
                loja WHERE loja.uf IS NOT NULL ORDER BY loja.uf ASC";
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
        $sql .= " ORDER BY loja.cidade ASC";
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