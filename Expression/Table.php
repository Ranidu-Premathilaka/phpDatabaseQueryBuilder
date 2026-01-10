<?php
class Table implements ExpressionInterface{
    private $name;
    private $alias;

    public function __construct(string $name, ?string $alias = ""){
        $this->name = $name;
        $this->alias = $alias;
    }

    public function getName(): mixed{
        return $this->name;
    }

    public function getAlias(): ?string{
        return $this->alias;
    }

    public function accept(ExpressionVisitorInterface $visitor){
        return $visitor->visitTable($this);
    }
}
