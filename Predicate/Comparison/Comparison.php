<?php

abstract class Comparison implements ComparisonInterface{
    private $left;
    private $right;

    public function __construct(ExpressionInterface $left, ExpressionInterface $right){
        $this->left = $left;
        $this->right = $right;
    }

    public function getLeft(): ExpressionInterface{
        return $this->left;
    }

    public function getRight(): ExpressionInterface{
        return $this->right;
    }
}