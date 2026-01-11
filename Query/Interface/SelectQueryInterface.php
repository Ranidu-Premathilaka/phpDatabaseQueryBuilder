<?php

interface SelectQueryInterface extends QueryInterface {
    public function setColumns(ExpressionInterface ...$columns);
    public function addOrderBy(ExpressionInterface ...$expression);
    public function addLimit(ExpressionInterface $limit);
    public function addOffset(ExpressionInterface $offset);
    public function innerJoin(ExpressionInterface $table, PredicateInterface $onCondition);
    public function leftJoin(ExpressionInterface $table, PredicateInterface $onCondition);
    public function rightJoin(ExpressionInterface $table, PredicateInterface $onCondition);
    public function outerJoin(ExpressionInterface $table, PredicateInterface $onCondition);
    public function getColumns(): array;
    public function getOrderBy(): array;
    public function getLimit(): ?ExpressionInterface;
    public function getOffset(): ?ExpressionInterface;
    public function getJoins(): array;
}