<?php

/**
 * Represents a DESCENDING sort order expression.
 *
 * Usage:
 * ```php
 * $query->addOrderBy(new Desc(new Column('created_at')));
 * ```
 */
class Desc implements ExpressionInterface{
    private ExpressionInterface $expression;

    public function __construct(ExpressionInterface $expression){
        $this->expression = $expression;
    }

    public function getExpression(): ExpressionInterface{
        return $this->expression;
    }

    public function accept(ExpressionVisitorInterface $visitor){
        return $visitor->visitDesc($this);
    }
}