<?php
// Base class for handling SQL compilation tasks
abstract class SqlQueryCompiler implements QueryCompilerInterface{
    protected ParameterContainerInterface $ParameterContainer;    

    public function __construct(){
        $this->ParameterContainer = new ParameterContainer();
    }

    protected function compileWhere(PredicateInterface $predicate): QueryFragmentInterface{
        $visitor = new SqlPredicateVisitor($this->ParameterContainer);
        $queryFragment = $predicate->accept($visitor);
        return new QueryFragment(' WHERE ' . $queryFragment->getString());
    }

    protected function compileOrderBy(array $orderBy): QueryFragmentInterface{
        $fragments = [];
        $visitor = new sqlExpressionVisitor($this->ParameterContainer);

        foreach($orderBy as $orderExpression){
            $fragments[] = $orderExpression->accept($visitor)->getString();
        }

        return new QueryFragment(' ORDER BY ' . implode(', ', $fragments));        

    }

    protected function compileJoins(array $joins): QueryFragmentInterface{
        $fragments = [];
        $visitor = new SqlJoinVisitor($this->ParameterContainer);

        foreach($joins as $join){
            $fragments[] = $join->accept($visitor)->getString();
        }

        return new QueryFragment(' ' . implode(' ', $fragments));        
    }

    protected function compileLimit(ExpressionInterface $limit): QueryFragmentInterface{
        $visitor = new sqlExpressionVisitor($this->ParameterContainer);
        $limitFragment = $limit->accept($visitor);
        return new QueryFragment(' LIMIT ' . $limitFragment->getString());
    }

    protected function compileOffset(ExpressionInterface $offset): QueryFragmentInterface{
        $visitor = new sqlExpressionVisitor($this->ParameterContainer);
        $offsetFragment = $offset->accept($visitor);
        return new QueryFragment(' OFFSET ' . $offsetFragment->getString());
    }
}
