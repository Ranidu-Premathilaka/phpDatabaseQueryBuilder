<?php
final class SqlPredicateVisitor implements TotalPredicateVisitorInterface{
    private $sqlExpressionVisitor;

    public function __construct(ParameterContainerInterface &$parameterContainerReference){
        $this->sqlExpressionVisitor = new sqlExpressionVisitor($parameterContainerReference);
    }

    private function comparisonToSql(ComparisonInterface $comparison, string $operator): QueryFragmentInterface{
        $columnFragment = $comparison->getLeft()->accept($this->sqlExpressionVisitor);
        $valueFragment = $comparison->getRight()->accept($this->sqlExpressionVisitor);
        return new QueryFragment($columnFragment->getString() . ' ' . $operator . ' ' . $valueFragment->getString());
    }

    public function visitEquals(IsEquals $equals): QueryFragmentInterface{
        return $this->comparisonToSql($equals, '=');
    }

    public function visitNotEquals(NotEquals $notEquals): QueryFragmentInterface{
        return $this->comparisonToSql($notEquals, '!=');
    }

    public function visitLessThan(LessThan $lessThan): QueryFragmentInterface{
        return $this->comparisonToSql($lessThan, '<');
    }

    public function visitGreaterThan(GreaterThan $greaterThan): QueryFragmentInterface{
        return $this->comparisonToSql($greaterThan, '>');
    }

    public function visitLessThanOrEquals(LessThanOrEquals $lessThanOrEquals): QueryFragmentInterface{
        return $this->comparisonToSql($lessThanOrEquals, '<=');
    }

    public function visitGreaterThanOrEquals(GreaterThanOrEquals $greaterThanOrEquals): QueryFragmentInterface{
        return $this->comparisonToSql($greaterThanOrEquals, '>=');
    }

    public function visitIs(Is $is): QueryFragmentInterface{
        $leftFragment = $is->getLeft()->accept($this->sqlExpressionVisitor);
        $rightFragment = $is->getRight()->accept($this->sqlExpressionVisitor);
        return new QueryFragment($leftFragment->getString() . ' IS ' . $rightFragment->getString());
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
