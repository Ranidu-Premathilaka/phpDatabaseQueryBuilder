<?php
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
