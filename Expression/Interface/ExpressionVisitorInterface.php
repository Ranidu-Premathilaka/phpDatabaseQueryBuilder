<?php
Interface ExpressionVisitorInterface{
    public function __construct(ParameterContainerInterface &$parameterContainerReference);
    public function visitColumn(Column $column);
    public function visitFunctionCall(FunctionCall $functionCall);
    public function visitLiteral(Literal $literal);
    public function visitAsc(Asc $asc);
    public function visitDesc(Desc $desc);
    public function visitTable(Table $table);

}
