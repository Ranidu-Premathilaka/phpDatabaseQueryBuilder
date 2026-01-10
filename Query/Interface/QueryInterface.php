<?php
Interface QueryInterface{
    public function getTable(): string;
    public function getColumns(): array;
    public function getWhere(): ?PredicateInterface;
}
