<?php

/**
 * Represents a less than or equal comparison (<=).
 * 
 * Usage:
 * ```php
 * new LessThanOrEquals(new Column('age'), new Literal(18))
 * new LessThanOrEquals(new Column('price'), new Column('max_budget'))
 * ```
 */
final class LessThanOrEquals extends Comparison{

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitLessThanOrEquals($this);
    }
}
