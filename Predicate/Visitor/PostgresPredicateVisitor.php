<?php
final class PostgresPredicateVisitor implements TotalPredicateVisitorInterface{
    private $postgresExpressionVisitor;

    public function __construct(ParameterContainerInterface &$parameterContainerReference){
        $this->postgresExpressionVisitor = new PostgresExpressionVisitor($parameterContainerReference);
    }

    private function comparisonToSql(ComparisonInterface $comparison, string $operator): QueryFragmentInterface{
        $columnFragment = $comparison->getLeft()->accept($this->postgresExpressionVisitor);
        $valueFragment = $comparison->getRight()->accept($this->postgresExpressionVisitor);
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
        $leftFragment = $is->getLeft()->accept($this->postgresExpressionVisitor);
        $rightFragment = $is->getRight()->accept($this->postgresExpressionVisitor);
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

    public function visitIsIn(IsIn $isIn): QueryFragmentInterface{
        $columnFragment = $isIn->getColumn()->accept($this->postgresExpressionVisitor);
        $values = $isIn->getValues();
        $valueFragments = array_map(function($value) {
            return $value->accept($this->postgresExpressionVisitor)->getString();
        }, $values);
        return new QueryFragment($columnFragment->getString() . ' IN (' . implode(', ', $valueFragments) . ')');
    }

    public function visitIsNotIn(IsNotIn $isNotIn): QueryFragmentInterface{
        $columnFragment = $isNotIn->getColumn()->accept($this->postgresExpressionVisitor);
        $values = $isNotIn->getValues();
        $valueFragments = array_map(function($value) {
            return $value->accept($this->postgresExpressionVisitor)->getString();
        }, $values);
        return new QueryFragment($columnFragment->getString() . ' NOT IN (' . implode(', ', $valueFragments) . ')');
    }
}
