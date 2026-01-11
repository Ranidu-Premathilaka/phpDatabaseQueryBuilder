<?php

/**
 * Represents a not equal comparison (NOT EQUALS / !=).
 * 
 * Usage:
 * ```php
 * new NotEquals(new Column('status'), new Literal('inactive'))
 * new NotEquals(new Column('user_id'), new Column('id', new Table('users')))
 * ```
 */
final class NotEquals extends Comparison{

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitNotEquals($this);
    }
}
