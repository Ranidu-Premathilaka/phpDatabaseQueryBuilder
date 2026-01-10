<?php
interface ComparisonVisitorInterface extends PredicateVisitorInterface{
    public function visitEquals(IsEquals $equals): QueryFragmentInterface;
}
