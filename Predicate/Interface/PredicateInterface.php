<?php
Interface PredicateInterface{
    public function accept(TotalPredicateVisitorInterface $visitor);
}
