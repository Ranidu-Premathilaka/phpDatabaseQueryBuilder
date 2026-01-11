<?php

/**
 * Represents a less than comparison (<).
 * 
 * Usage:
 * ```php
 * new LessThan(new Column('age'), new Literal(18))
 * new LessThan(new Column('price'), new Column('budget'))
 * ```
 */
final class LessThan extends Comparison{

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitLessThan($this);
    }
}
