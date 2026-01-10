<?php
class SelectQuery implements QueryInterface{
    private $table;
    private $columns = [];
    private $where = null;

    public function setTable($table){
        $this->table = $table;
        return $this;
    }

    public function setColumns(array $columns){
        $this->columns = $columns;
        return $this;
    }

    public function addWhere(PredicateInterface $conditions){
        $this->where = $conditions;
        return $this;
    }

    public function getTable(): string{
        return $this->table;
    }

    public function getColumns(): array{
        return $this->columns;
    }

    public function getWhere(): ?PredicateInterface{
        return $this->where;
    }

}
