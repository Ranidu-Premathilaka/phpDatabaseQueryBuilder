<?php

/**
 * Represents a binary operation between two expressions.
 * 
 * Supports arithmetic operations: +, -, *, /
 * 
 * Usage:
 * ```php
 * new BinaryOperation(new Column('balance'), '+', new Literal(100))
 * new BinaryOperation(new Column('price'), '*', new Literal(1.1))
 * new BinaryOperation(new Column('quantity'), '-', new Literal(5))
 * ```
 */
class BinaryOperation implements ExpressionInterface{
    private $left;
    private $operator;
    private $right;
    private static $validOperators = ['+', '-', '*', '/'];

    public function __construct(ExpressionInterface $left, string $operator, ExpressionInterface $right){
        if (!in_array($operator, self::$validOperators)) {
            throw new InvalidArgumentException("Invalid operator '$operator' for BinaryOperation. Valid operators are: " . implode(', ', self::$validOperators));
        }
        $this->left = $left;
        $this->operator = $operator;
        $this->right = $right;
    }

    public function getLeft(): ExpressionInterface{
        return $this->left;
    }

    public function getOperator(): string{
        return $this->operator;
    }

    public function getRight(): ExpressionInterface{
        return $this->right;
    }

    public function accept(ExpressionVisitorInterface $visitor){
        return $visitor->visitBinaryOperation($this);
    }
}
