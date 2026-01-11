<?php

/**
 * Represents an IN predicate.
 * 
 * Usage:
 * ```php
 * new IsIn(new Column('status'), [new Literal('active'), new Literal('pending')])
 * new IsIn(new Column('id'), [new Literal(1), new Literal(2), new Literal(3)])
 * ```
 */
final class IsIn extends In{

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitIsIn($this);
    }
}
