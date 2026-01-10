<?php
Interface QueryInterface{
    public function setTable(ExpressionInterface $table);
    public function setWhere(?PredicateInterface $where);
    public function getTable(): ExpressionInterface;
    public function getWhere(): ?PredicateInterface;
}
