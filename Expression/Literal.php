<?php

/**
 * Represents a literal value (number, string).
 * 
 * Usage:
 * ```php
 * new Literal('USA')
 * new Literal(30)
 * ```
 */
class Literal implements ExpressionInterface{
    private $value;

    public function __construct(mixed $value){
        $this->value = $value;
    }

    public function getValue(): mixed{
        return $this->value;
    }
    public function accept(ExpressionVisitorInterface $visitor){
        return $visitor->visitLiteral($this);
    }
}
