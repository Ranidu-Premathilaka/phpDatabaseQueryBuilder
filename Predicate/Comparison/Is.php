<?php

/**
 * Represents an IS comparison (IS / IS NOT).
 * 
 * Usage:
 * ```php
 * new Is(new Column('email'), new NullLiteral())
 * new Is(new Column('status'), new Boolean(true))
 * ```
 */
class Is implements PredicateInterface{
    private ExpressionInterface $left;
    private ExpressionInterface $right;

    public function __construct(ExpressionInterface $left, ExpressionInterface $right){
        $this->left = $left;
        $this->right = $right;
    }

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitIs($this);
    }

    public function getLeft(): ExpressionInterface{
        return $this->left;
    }

    public function getRight(): ExpressionInterface{
        return $this->right;
    }
}