<?php
class AndCondition implements LogicalInterface{
    private $conditions = [];

    public function __construct(PredicateInterface ...$conditions){
        count($conditions) < 2 and throw new InvalidArgumentException("AndCondition requires at least two conditions.");
        $this->conditions = $conditions;
    }

    public function getConditions(): array{
        return $this->conditions;
    }

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitAnd($this);
    }
}
