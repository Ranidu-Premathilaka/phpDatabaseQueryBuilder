<?php

/**
 * Represents a logical OR condition linking multiple predicates.
 * 
 * Usage:
 * ```php
 * new OrCondition(
 *     new IsEquals(new Column('role'), new Literal('admin')),
 *     new IsEquals(new Column('role'), new Literal('user'))
 * )
 * ```
 */
class OrCondition implements LogicalInterface{
    private $conditions = [];

    public function __construct(PredicateInterface ...$conditions){
        count($conditions) < 2 and throw new InvalidArgumentException("OrCondition requires at least two conditions.");
        $this->conditions = $conditions;
    }

    public function getConditions(): array{
        return $this->conditions;
    }

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitOr($this);
    }
}
