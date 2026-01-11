<?php

/**
 * Represents an IS comparison (IS / IS NOT).
 * 
 * Usage:
 * ```php
 * new Is(new Column('email'), new NullLiteral())
 * new Is(new Column('status'), new Boolean(true))
 * ```
 */
final class Is extends Comparison{

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitIs($this);
    }
}