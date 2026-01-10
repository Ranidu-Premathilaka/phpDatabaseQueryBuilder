<?php

final class Join implements JoinInterface{
    private JoinEnum $type;
    private ExpressionInterface $table;
    private PredicateInterface $condition;

    public function __construct(JoinEnum $type, ExpressionInterface $table, PredicateInterface $condition){
        $this->type = $type;
        $this->table = $table;
        $this->condition = $condition;
    }

    public function getType(): JoinEnum{
        return $this->type;
    }

    public function getTable(): ExpressionInterface{
        return $this->table;
    }

    public function getCondition(): PredicateInterface{
        return $this->condition;
    }

    public function accept(JoinVisitorInterface $visitor){
        return $visitor->visitJoin($this);
    }
}