<?php

interface UpdateQueryInterface extends QueryInterface{
    public function addSetClause(IsEquals ...$conditions);
    public function getSetClauses(): array;
}