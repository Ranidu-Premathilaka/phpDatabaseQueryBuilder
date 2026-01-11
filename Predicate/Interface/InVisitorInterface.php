<?php
interface InVisitorInterface extends PredicateVisitorInterface{
    public function visitIsIn(IsIn $isIn): QueryFragmentInterface;
    public function visitIsNotIn(IsNotIn $isNotIn): QueryFragmentInterface;
}
