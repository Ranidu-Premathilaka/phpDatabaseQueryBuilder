<?php

/**
 * Represents a database column reference.
 *
 * Usage:
 * ```php
 * new Column('name')
 * new Column('id', new Table('users'))
 * ```
 */
class Column implements ExpressionInterface{
    private $column;
    private $table;

    public function __construct(string $column, ?ExpressionInterface $table = null){
        $this->column = $column;
        $this->table = $table;
    }

    public function getName(): string{
        return $this->column;
    }

    public function getTable(): ?ExpressionInterface{
        return $this->table;
    }

    public function accept(ExpressionVisitorInterface $visitor){
        return $visitor->visitColumn($this);
    }

}
