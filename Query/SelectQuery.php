<?php
class SelectQuery implements QueryInterface{
    private $table;
    private $columns = [];
    private $where = null;
    private $orderBy = [];
    private $limit = null;
    private $offset = null;

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

    public function addOrderBy(ExpressionInterface $expression){
        $this ->orderBy[] = $expression;
        return $this;
    }

    public function addLimit(ExpressionInterface $limit){
        $this->limit = $limit;
        return $this;
    }

    public function addOffset(ExpressionInterface $offset){
        $this->offset = $offset;
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

    public function getOrderBy(): array{
        return $this->orderBy;
    }

    public function getLimit(): ?ExpressionInterface{
        return $this->limit;
    }

    public function getOffset(): ?ExpressionInterface{
        return $this->offset;
    }
}
