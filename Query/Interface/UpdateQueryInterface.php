<?php

interface UpdateQueryInterface extends QueryInterface{
    public function __construct();
    public function addSetClause(IsEquals $conditions): void;
    public function getSetClauses(): array;
}