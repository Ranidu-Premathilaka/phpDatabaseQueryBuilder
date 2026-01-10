<?php
class SelectQuery implements SelectQueryInterface{
    private $table;
    private $columns = [];
    private $where = null;
    private $orderBy = [];
    private $limit = null;
    private $offset = null;
    private $joins = [];

    public function setTable(ExpressionInterface $table){
        $this->table = $table;
        return $this;
    }

    public function setColumns(ExpressionInterface $columns){
        $this->columns[] = $columns;
        return $this;
    }

    public function setWhere(?PredicateInterface $where){
        $this->where = $where;
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

    public function innerJoin(ExpressionInterface $table, PredicateInterface $onCondition){
        $this->joins[] = new Join(JoinEnum::INNER, $table, $onCondition);
        return $this;
    }
    public function leftJoin(ExpressionInterface $table, PredicateInterface $onCondition){
        $this->joins[] = new Join(JoinEnum::LEFT, $table, $onCondition);
        return $this;
    }
    public function rightJoin(ExpressionInterface $table, PredicateInterface $onCondition){
        $this->joins[] = new Join(JoinEnum::RIGHT, $table, $onCondition);
        return $this;
    }
    public function outerJoin(ExpressionInterface $table, PredicateInterface $onCondition){
        $this->joins[] = new Join(JoinEnum::OUTER, $table, $onCondition);
        return $this;
    }

    public function getTable(): ExpressionInterface{
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

    public function getJoins(): array{
        // Return the joins
        return $this->joins;
    }
}
