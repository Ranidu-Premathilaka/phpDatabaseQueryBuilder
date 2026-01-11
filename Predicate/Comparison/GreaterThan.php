<?php

/**
 * Represents a greater than comparison (>).
 * 
 * Usage:
 * ```php
 * new GreaterThan(new Column('age'), new Literal(18))
 * new GreaterThan(new Column('price'), new Column('minimum'))
 * ```
 */
final class GreaterThan extends Comparison{

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitGreaterThan($this);
    }
}
