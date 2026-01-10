<?php
interface LogicalVisitorInterface extends PredicateVisitorInterface{
    public function visitAnd(AndCondition $andCondition): QueryFragmentInterface;
    public function visitOr(OrCondition $orCondition): QueryFragmentInterface;
}
