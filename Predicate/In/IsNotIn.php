<?php

/**
 * Represents a NOT IN predicate.
 * 
 * Usage:
 * ```php
 * new IsNotIn(new Column('status'), [new Literal('deleted'), new Literal('archived')])
 * new IsNotIn(new Column('id'), [new Literal(10), new Literal(20)])
 * ```
 */
final class IsNotIn extends In{

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitIsNotIn($this);
    }
}
