<?php
class sqlExpressionVisitor implements ExpressionVisitorInterface{
    private $parameterContainerReference;

    public function __construct(ParameterContainerInterface &$parameterContainerReference){
        $this->parameterContainerReference = $parameterContainerReference;
    }

    public function visitColumn(Column $column){
        return new QueryFragment($column->getName());
    }

    public function visitFunctionCall(FunctionCall $functionCall){
        $functionName = $functionCall->getFunctionName();
        $argStrings = array_map(function($arg) {
            return $arg->accept($this)->getString();
        }, $functionCall->getArguments());

        return new QueryFragment($functionName . '(' . implode(', ', $argStrings) . ')');
    }

    public function visitLiteral(Literal $literal){
        $parameterPlaceholder = $this->parameterContainerReference->addParameter(new Parameter($literal->getValue()));
        
        return new QueryFragment($parameterPlaceholder);
    }

}
