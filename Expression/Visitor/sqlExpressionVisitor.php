<?php
class sqlExpressionVisitor implements ExpressionVisitorInterface{
    private $parameterContainerReference;

    public function __construct(ParameterContainerInterface &$parameterContainerReference){
        $this->parameterContainerReference = $parameterContainerReference;
    }

    public function visitColumn(Column $column){
        $columnObj = $column->getName();
        $tableObject = $column->getTable(); // Should just have the table name or alias set
        $tableReference = "";

        if($tableObject !== null){
            $tableFragment = $tableObject->accept($this);
            $tableReference = $tableFragment->getString() . ".";
        }

        return new QueryFragment($tableReference . $columnObj);
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

    public function visitBoolean(Boolean $boolean){
        $value = $boolean->getValue() ? 'TRUE' : 'FALSE';
        return new QueryFragment($value);
    }

    public function visitNullLiteral(NullLiteral $null){
        return new QueryFragment('NULL');
    }

    public function visitBinaryOperation(BinaryOperation $binaryOperation){
        $leftFragment = $binaryOperation->getLeft()->accept($this);
        $rightFragment = $binaryOperation->getRight()->accept($this);
        $operator = $binaryOperation->getOperator();
        
        return new QueryFragment($leftFragment->getString() . ' ' . $operator . ' ' . $rightFragment->getString());
    }
}
