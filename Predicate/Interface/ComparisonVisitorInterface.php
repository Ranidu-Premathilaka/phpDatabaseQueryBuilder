<?php
interface ComparisonVisitorInterface extends PredicateVisitorInterface{
    public function visitEquals(IsEquals $equals): QueryFragmentInterface;
    public function visitNotEquals(NotEquals $notEquals): QueryFragmentInterface;
    public function visitLessThan(LessThan $lessThan): QueryFragmentInterface;
    public function visitGreaterThan(GreaterThan $greaterThan): QueryFragmentInterface;
    public function visitLessThanOrEquals(LessThanOrEquals $lessThanOrEquals): QueryFragmentInterface;
    public function visitGreaterThanOrEquals(GreaterThanOrEquals $greaterThanOrEquals): QueryFragmentInterface;
}
