<?php

/**
 * Represents an equality comparison (EQUALS / =).
 * 
 * Usage:
 * ```php
 * new IsEquals(new Column('country'), new Literal('USA'))
 * new IsEquals(new Column('user_id'), new Column('id', new Table('users')))
 * ```
 */
class IsEquals implements ComparisonInterface{
    private $column;
    private $value;

    public function __construct(ExpressionInterface $column, ExpressionInterface $value){
        $this->column = $column;
        $this->value = $value;
    }

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitEquals($this);
    }
    public function getColumn(): ExpressionInterface{
        return $this->column;
    }
    public function getValue(): ExpressionInterface{
        return $this->value;
    }
}
