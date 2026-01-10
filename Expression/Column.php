<?php
class Column implements ExpressionInterface{
    private $column;

    public function __construct(string $column){
        $this->column = $column;
    }

    public function getName(): string{
        return $this->column;
    }

    public function accept(ExpressionVisitorInterface $visitor){
        return $visitor->visitColumn($this);
    }

}
