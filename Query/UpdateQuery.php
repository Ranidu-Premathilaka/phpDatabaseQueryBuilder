<?php

class UpdateQuery implements UpdateQueryInterface{
    private ExpressionInterface $table;
    private array $setClauses = [];
    private ?PredicateInterface $where = null;

    public function setTable(ExpressionInterface $table){
        $this->table = $table;
        return $this;
    }

    public function addSetClause(IsEquals ...$conditions){
        $this->setClauses = $conditions;
        return $this;
    }

    public function setWhere(?PredicateInterface $where){
        $this->where = $where;
        return $this;
    }

    public function getTable(): ExpressionInterface{
        return $this->table;
    }

    public function getSetClauses(): array{
        return $this->setClauses;
    }

    public function getWhere(): ?PredicateInterface{
        return $this->where;
    }
}