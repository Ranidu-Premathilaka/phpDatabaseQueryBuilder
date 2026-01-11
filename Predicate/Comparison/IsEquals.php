<?php

/**
 * Represents an equality comparison (EQUALS / =).
 * 
 * Usage:
 * ```php
 * new IsEquals(new Column('country'), new Literal('USA'))
 * new IsEquals(new Column('user_id'), new Column('id', new Table('users')))
 * ```
 */
final class IsEquals extends Comparison{

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitEquals($this);
    }
}
