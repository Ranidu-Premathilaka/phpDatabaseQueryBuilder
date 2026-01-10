<?php
Interface QueryInterface{
    public function setTable(ExpressionInterface $table);
    public function getTable(): ExpressionInterface;
    public function getWhere(): ?PredicateInterface;
}
