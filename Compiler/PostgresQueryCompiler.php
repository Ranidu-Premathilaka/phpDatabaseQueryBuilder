<?php
// Base class for handling PostgreSQL compilation tasks
abstract class PostgresQueryCompiler implements QueryCompilerInterface{
    protected ParameterContainerInterface $ParameterContainer;    

    public function __construct(){
        $this->ParameterContainer = new ParameterContainer();
    }

    protected function compileTable(ExpressionInterface $table): QueryFragmentInterface{
        $visitor = new PostgresExpressionVisitor($this->ParameterContainer);
        $tableString = $table->accept($visitor)->getString();

        return new QueryFragment($tableString);
    }

    protected function compileColumns(array $columns): QueryFragmentInterface{
        $columnFragments = [];
        $visitor = new PostgresExpressionVisitor($this->ParameterContainer);

        foreach($columns as $column){
            $columnFragments[] = $column->accept($visitor)->getString();
        }

        return new QueryFragment(implode(', ', $columnFragments));
    }

    protected function compileWhere(PredicateInterface $predicate): QueryFragmentInterface{
        $visitor = new PostgresPredicateVisitor($this->ParameterContainer);
        $queryFragment = $predicate->accept($visitor);
        return new QueryFragment(' WHERE ' . $queryFragment->getString());
    }

    protected function compileSetClauses(array $setClauses): QueryFragmentInterface{
        $fragments = [];
        $visitor = new PostgresPredicateVisitor($this->ParameterContainer);

        foreach($setClauses as $expressionObject){
            $fragments[] = $expressionObject->accept($visitor)->getString();
        }

        return new QueryFragment(' SET ' . implode(', ', $fragments));        
    }

    protected function compileOrderBy(array $orderBy): QueryFragmentInterface{
        $fragments = [];
        $visitor = new PostgresExpressionVisitor($this->ParameterContainer);

        foreach($orderBy as $orderExpression){
            $fragments[] = $orderExpression->accept($visitor)->getString();
        }

        return new QueryFragment(' ORDER BY ' . implode(', ', $fragments));        

    }

    protected function compileJoins(array $joins): QueryFragmentInterface{
        $fragments = [];
        $visitor = new PostgresJoinVisitor($this->ParameterContainer);

        foreach($joins as $join){
            $fragments[] = $join->accept($visitor)->getString();
        }

        return new QueryFragment(' ' . implode(' ', $fragments));        
    }

    protected function compileLimit(ExpressionInterface $limit): QueryFragmentInterface{
        $visitor = new PostgresExpressionVisitor($this->ParameterContainer);
        $limitFragment = $limit->accept($visitor);
        return new QueryFragment(' LIMIT ' . $limitFragment->getString());
    }

    protected function compileOffset(ExpressionInterface $offset): QueryFragmentInterface{
        $visitor = new PostgresExpressionVisitor($this->ParameterContainer);
        $offsetFragment = $offset->accept($visitor);
        return new QueryFragment(' OFFSET ' . $offsetFragment->getString());
    }

    protected function compileValues(array $records): QueryFragmentInterface{
        $visitor = new PostgresExpressionVisitor($this->ParameterContainer);
        $recordFragments = [];

        foreach($records as $record){
            $valueFragments = [];
            foreach($record as $value){
                $valueFragments[] = $value->accept($visitor)->getString();
            }
            $recordFragments[] = '(' . implode(', ', $valueFragments) . ')';
        }

        return new QueryFragment(' VALUES ' . implode(', ', $recordFragments));
    }

    protected function compileReturning(array $columns): QueryFragmentInterface{
        $columnFragments = [];
        $visitor = new PostgresExpressionVisitor($this->ParameterContainer);

        foreach($columns as $column){
            $columnFragments[] = $column->accept($visitor)->getString();
        }

        return new QueryFragment(' RETURNING ' . implode(', ', $columnFragments));
    }
}
