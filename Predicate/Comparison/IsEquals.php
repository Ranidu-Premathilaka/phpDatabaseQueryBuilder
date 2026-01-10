<?php
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
