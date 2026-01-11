<?php

class InsertQuery implements InsertQueryInterface{
    private ExpressionInterface $table;
    private array $columns = [];
    private array $records = [];
    private ?PredicateInterface $where = null;
    private array $returning = [];

    public function setTable(ExpressionInterface $table){
        $this->table = $table;
        return $this;
    }

    public function setColumns(ExpressionInterface ...$columns){
        $this->columns = $columns;
        return $this;
    }

    public function addRecord(ExpressionInterface ...$values){
        $this->records[] = $values;
        return $this;
    }

    public function setReturning(ExpressionInterface ...$columns){
        $this->returning = $columns;
        return $this;
    }

    public function setWhere(?PredicateInterface $where){
        $this->where = $where;
        return $this;
    }

    public function getTable(): ExpressionInterface{
        return $this->table;
    }

    public function getColumns(): array{
        return $this->columns;
    }

    public function getRecords(): array{
        return $this->records;
    }

    public function getReturning(): array{
        return $this->returning;
    }

    public function getWhere(): ?PredicateInterface{
        return $this->where;
    }
}
