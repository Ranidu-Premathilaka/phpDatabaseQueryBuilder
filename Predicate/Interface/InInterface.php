<?php
interface InInterface extends PredicateInterface{
    public function __construct(ExpressionInterface $column, array $values);
    public function getColumn(): ExpressionInterface;
    public function getValues(): array; // array of ExpressionInterface
}
