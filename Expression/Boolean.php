<?php

/**
 * Represents a boolean value (TRUE/FALSE).
 * 
 * Usage:
 * ```php
 * new Boolean(true)
 * new Boolean(false)
 * ```
 */
class Boolean implements ExpressionInterface{
    private $value;

    public function __construct(bool $value){
        $this->value = $value;
    }

    public function getValue(): bool{
        return $this->value;
    }
    
    public function accept(ExpressionVisitorInterface $visitor){
        return $visitor->visitBoolean($this);
    }
}