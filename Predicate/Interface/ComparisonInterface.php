<?php
Interface ComparisonInterface extends PredicateInterface{
    public function __construct(ExpressionInterface $column,  ExpressionInterface $value);
    public function getColumn(): ExpressionInterface;
    public function getValue(): ExpressionInterface;
}
