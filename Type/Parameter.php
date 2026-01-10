<?php
class Parameter implements ParameterInterface{
    private $value;

    public function __construct(mixed $value){
        $this->value = $value;
    }

    public function getValue(): mixed{
        return $this->value;
    }
}
