<?php
final class SqlPredicateVisitor implements TotalPredicateVisitorInterface{
    private $sqlExpressionVisitor;

    public function __construct(ParameterContainerInterface &$parameterContainerReference){
        $this->sqlExpressionVisitor = new sqlExpressionVisitor($parameterContainerReference);
    }

    public function visitEquals(IsEquals $equals): QueryFragmentInterface{
        $columnFragment = $equals->getColumn()->accept($this->sqlExpressionVisitor);
        $valueFragment = $equals->getValue()->accept($this->sqlExpressionVisitor);
        return new QueryFragment($columnFragment->getString() . ' = ' . $valueFragment->getString());

    }

    public function visitAnd(AndCondition $andCondition): QueryFragmentInterface{
        $conditions = $andCondition->getConditions();
        $sqlConditions = array_map(function($condition) {
            return $condition->accept($this)->getString();
        }, $conditions);
        return new QueryFragment('(' . implode(' AND ', $sqlConditions) . ')');
    }

    public function visitOr(OrCondition $orCondition): QueryFragmentInterface{
        $conditions = $orCondition->getConditions();
        $sqlConditions = array_map(function($condition) {
            return $condition->accept($this)->getString();
        }, $conditions);
        return new QueryFragment('(' . implode(' OR ', $sqlConditions) . ')');
    }
}
