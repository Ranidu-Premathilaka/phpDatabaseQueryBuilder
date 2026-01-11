<?php

/**
 * Represents a NULL value.
 * 
 * Usage:
 * ```php
 * new Null()
 * ```
 */
class NullLiteral implements ExpressionInterface{
    public function accept(ExpressionVisitorInterface $visitor){
        return $visitor->visitNullLiteral($this);
    }
}