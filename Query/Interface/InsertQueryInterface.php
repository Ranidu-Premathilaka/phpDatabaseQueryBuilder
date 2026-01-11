<?php
Interface InsertQueryInterface extends QueryInterface{
    public function setColumns(ExpressionInterface ...$columns);
    public function addRecord(ExpressionInterface ...$values);
    public function setReturning(ExpressionInterface ...$columns);
    public function getColumns(): array;
    public function getRecords(): array;
    public function getReturning(): array;
}
