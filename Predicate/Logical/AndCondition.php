<?php

/**
 * Represents a logical AND condition linking multiple predicates.
 * 
 * Usage:
 * ```php
 * new AndCondition(
 *     new IsEquals(new Column('age'), new Literal(30)),
 *     new IsEquals(new Column('active'), new Literal(true))
 * )
 * ```
 */
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
