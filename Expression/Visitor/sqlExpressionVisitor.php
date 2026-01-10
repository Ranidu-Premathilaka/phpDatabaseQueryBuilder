<?php
class sqlExpressionVisitor implements ExpressionVisitorInterface{
    private $parameterContainerReference;

    public function __construct(ParameterContainerInterface &$parameterContainerReference){
        $this->parameterContainerReference = $parameterContainerReference;
    }

    public function visitColumn(Column $column){
        $columnName = $column->getName();
        $tableObject = $column->getTable();
        $tableReference = "";

        if($tableObject !== null && $tableObject instanceof Table){
            $tableName = $tableObject->getAlias() ?: $tableObject->getName();
            $tableReference = $tableName . ".";
        }

        return new QueryFragment($tableReference . $columnName);
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

    public function visitAsc(Asc $asc){
        $exprFragment = $asc->getExpression()->accept($this);
        return new QueryFragment($exprFragment->getString() . ' ASC');
    }

    public function visitDesc(Desc $desc){
        $exprFragment = $desc->getExpression()->accept($this);
        return new QueryFragment($exprFragment->getString() . ' DESC');
    }

    public function visitTable(Table $table){
        $aliasString = "";
        if(!empty($table->getAlias())){
            $aliasString = " AS " . $table->getAlias();
        }
        return new QueryFragment($table->getName() . $aliasString);
    }
}
