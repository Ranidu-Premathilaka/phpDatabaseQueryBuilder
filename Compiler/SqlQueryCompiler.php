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
}
