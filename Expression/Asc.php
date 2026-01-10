<?php

class Asc implements ExpressionInterface{
    private ExpressionInterface $expression;

    public function __construct(ExpressionInterface $expression){
        $this->expression = $expression;
    }

    public function getExpression(): ExpressionInterface{
        return $this->expression;
    }

    public function accept(ExpressionVisitorInterface $visitor){
        return $visitor->visitAsc($this);
    }
}