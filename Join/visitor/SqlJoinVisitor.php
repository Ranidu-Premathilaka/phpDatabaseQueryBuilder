<?php

final class SqlJoinVisitor implements JoinVisitorInterface{
    private $sqlExpressionVisitor;
    private $sqlPredicateVisitor;
    private $parameterContainerReference;

    public function __construct(ParameterContainerInterface &$parameterContainerReference){
        $this->sqlExpressionVisitor = new SqlExpressionVisitor($parameterContainerReference);
        $this->sqlPredicateVisitor = new SqlPredicateVisitor($parameterContainerReference);
        
        $this->parameterContainerReference = $parameterContainerReference;
    }

    public function visitJoin(JoinInterface $join){
        $type = $join->getType()->value; 
        $tableSql = $join->getTable()->accept($this->sqlExpressionVisitor)->getString();
        $conditionSql = $join->getCondition()->accept($this->sqlPredicateVisitor)->getString();

        return new QueryFragment(sprintf("%s JOIN %s ON %s", $type, $tableSql, $conditionSql));
    }
}