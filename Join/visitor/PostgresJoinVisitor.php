<?php

final class PostgresJoinVisitor implements JoinVisitorInterface{
    private $postgresExpressionVisitor;
    private $postgresPredicateVisitor;
    private $parameterContainerReference;

    public function __construct(ParameterContainerInterface &$parameterContainerReference){
        $this->postgresExpressionVisitor = new PostgresExpressionVisitor($parameterContainerReference);
        $this->postgresPredicateVisitor = new PostgresPredicateVisitor($parameterContainerReference);
        
        $this->parameterContainerReference = $parameterContainerReference;
    }

    public function visitJoin(JoinInterface $join){
        $type = $join->getType()->value; 
        $tableSql = $join->getTable()->accept($this->postgresExpressionVisitor)->getString();
        $conditionSql = $join->getCondition()->accept($this->postgresPredicateVisitor)->getString();

        return new QueryFragment(sprintf("%s JOIN %s ON %s", $type, $tableSql, $conditionSql));
    }
}