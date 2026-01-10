<?php
Interface LogicalInterface extends PredicateInterface{
    public function __construct(PredicateInterface ...$conditions);
    public function getConditions(): array; // of PredicateInterface
}
