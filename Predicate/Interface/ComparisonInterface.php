<?php
Interface ComparisonInterface extends PredicateInterface{
    public function __construct(ExpressionInterface $left,  ExpressionInterface $right);
    public function getLeft(): ExpressionInterface;
    public function getRight(): ExpressionInterface;
}
