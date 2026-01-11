<?php

/**
 * Represents a greater than or equal comparison (>=).
 * 
 * Usage:
 * ```php
 * new GreaterThanOrEquals(new Column('age'), new Literal(18))
 * new GreaterThanOrEquals(new Column('price'), new Column('minimum'))
 * ```
 */
final class GreaterThanOrEquals extends Comparison{

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitGreaterThanOrEquals($this);
    }
}
