<?php

class DeleteQuery implements DeleteQueryInterface{
    private $table;
    private $where = null;
    
    public function setTable(ExpressionInterface $table){
        $this->table = $table;
        return $this;
    }

    public function setWhere(?PredicateInterface $where){
        $this->where = $where;
        return $this;
    }

    public function getTable(): ExpressionInterface{
        return $this->table;
    }

    public function getWhere(): ?PredicateInterface{
        return $this->where;
    }
}