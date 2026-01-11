<?php

abstract class In implements InInterface{
    private $column;
    private $values;

    public function __construct(ExpressionInterface $column, array $values){
        $this->column = $column;
        $this->values = $values;
    }

    public function getColumn(): ExpressionInterface{
        return $this->column;
    }

    public function getValues(): array{
        return $this->values;
    }
}
