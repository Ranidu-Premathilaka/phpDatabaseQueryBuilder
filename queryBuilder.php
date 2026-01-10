<?php
Interface ExpressionInterface{
    public function accept(ExpressionVisitorInterface $visitor);
}

class Column implements ExpressionInterface{
    private $column;

    public function __construct(string $column){
        $this->column = $column;
    }

    public function getName(): string{
        return $this->column;
    }

    public function accept(ExpressionVisitorInterface $visitor){
        return $visitor->visitColumn($this);
    }

}

class FunctionCall implements ExpressionInterface{
    private $functionName;
    private $arguments = [];

    public function __construct(string $functionName, ExpressionInterface ...$arguments){
        $this->functionName = $functionName;
        $this->arguments = $arguments;
    }

    public function getFunctionName(): string{
        return $this->functionName;
    }
    public function getArguments(): array{
        return $this->arguments;
    }

    public function accept(ExpressionVisitorInterface $visitor){
        return $visitor->visitFunctionCall($this);
    }
}

class Literal implements ExpressionInterface{
    private $value;

    public function __construct(mixed $value){
        $this->value = $value;
    }

    public function getValue(): mixed{
        return $this->value;
    }
    public function accept(ExpressionVisitorInterface $visitor){
        return $visitor->visitLiteral($this);
    }
}




Interface ExpressionVisitorInterface{
    public function __construct(ParameterContainerInterface &$parameterContainerReference);
    public function visitColumn(Column $column);
    public function visitFunctionCall(FunctionCall $functionCall);
    public function visitLiteral(Literal $literal);

}

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

interface ParameterInterface{
    public function getValue(): mixed;
}

class Parameter implements ParameterInterface{
    private $value;

    public function __construct(mixed $value){
        $this->value = $value;
    }

    public function getValue(): mixed{
        return $this->value;
    }
}

interface ParameterContainerInterface{
    public function addParameter(ParameterInterface $parameter): string;
    public function getParameters(): array;
}

// parallel processing isn't allowed in this context
class ParameterContainer implements ParameterContainerInterface{
    private $parameters = [];

    public function addParameter(ParameterInterface $parameter): string{
        $this->parameters[] = $parameter;
        return "?";
    }

    public function getParameters(): array{
        $data = [];
        foreach($this->parameters as $param){
            $data[] = $param->getValue();
        }

        return $data;
    }
}

interface QueryFragmentInterface{
    public function getString(): string;
}

class QueryFragment implements QueryFragmentInterface{
    private $queryString;

    public function __construct(string $queryString){
        $this->queryString = $queryString;
    }

    public function getString(): string{
        return $this->queryString;
    }
}


Interface PredicateInterface{
    public function accept(TotalPredicateVisitorInterface $visitor);
}

Interface ComparisonInterface extends PredicateInterface{
    public function __construct(ExpressionInterface $column,  ExpressionInterface $value);
    public function getColumn(): ExpressionInterface;
    public function getValue(): ExpressionInterface;
}

Interface LogicalInterface extends PredicateInterface{
    public function __construct(PredicateInterface ...$conditions);
    public function getConditions(): array; // of PredicateInterface
}


class IsEquals implements ComparisonInterface{
    private $column;
    private $value;

    public function __construct(ExpressionInterface $column, ExpressionInterface $value){
        $this->column = $column;
        $this->value = $value;
    }

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitEquals($this);
    }
    public function getColumn(): ExpressionInterface{
        return $this->column;
    }
    public function getValue(): ExpressionInterface{
        return $this->value;
    }
}

class AndCondition implements LogicalInterface{
    private $conditions = [];

    public function __construct(PredicateInterface ...$conditions){
        count($conditions) < 2 and throw new InvalidArgumentException("AndCondition requires at least two conditions.");
        $this->conditions = $conditions;
    }

    public function getConditions(): array{
        return $this->conditions;
    }

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitAnd($this);
    }
}

class OrCondition implements LogicalInterface{
    private $conditions = [];

    public function __construct(PredicateInterface ...$conditions){
        count($conditions) < 2 and throw new InvalidArgumentException("OrCondition requires at least two conditions.");
        $this->conditions = $conditions;
    }

    public function getConditions(): array{
        return $this->conditions;
    }

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitOr($this);
    }
}

interface PredicateVisitorInterface{
    public function __construct(ParameterContainerInterface &$parameterContainerReference);
}

interface ComparisonVisitorInterface extends PredicateVisitorInterface{
    public function visitEquals(IsEquals $equals): QueryFragmentInterface;
}

interface LogicalVisitorInterface extends PredicateVisitorInterface{
    public function visitAnd(AndCondition $andCondition): QueryFragmentInterface;
    public function visitOr(OrCondition $orCondition): QueryFragmentInterface;
}

interface TotalPredicateVisitorInterface extends ComparisonVisitorInterface, LogicalVisitorInterface{
}

final class SqlPredicateVisitor implements TotalPredicateVisitorInterface{
    private $sqlExpressionVisitor;

    public function __construct(ParameterContainerInterface &$parameterContainerReference){
        $this->sqlExpressionVisitor = new sqlExpressionVisitor($parameterContainerReference);
    }

    public function visitEquals(IsEquals $equals): QueryFragmentInterface{
        $columnFragment = $equals->getColumn()->accept($this->sqlExpressionVisitor);
        $valueFragment = $equals->getValue()->accept($this->sqlExpressionVisitor);
        return new QueryFragment($columnFragment->getString() . ' = ' . $valueFragment->getString());

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
}

interface QueryCompilerInterface{
    public function compile(QueryInterface $query) : compiledQueryInterface;
}

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

// Final class for orchestrating SELECT query compilation
final class SelectSqlQueryCompiler extends SqlQueryCompiler{
    public function compile(QueryInterface $query) : compiledQueryInterface{
        $table = $query->getTable();
        $columns = implode(', ', $query->getColumns());
        $sql = "SELECT $columns FROM $table";

        if($query->getWhere()){
            $whereQueryFragment = $this->compileWhere($query->getWhere());
            $sql .= $whereQueryFragment->getString();
        }

        return new compiledQuery($sql, $this->ParameterContainer->getParameters());
    }
}

interface compiledQueryInterface{
    public function getString(): string;
    public function getParameters(): array;
}

class compiledQuery implements compiledQueryInterface{
    private $queryString;
    private $parameters = [];

    public function __construct(string $queryString, array $parameters){
        $this->queryString = $queryString;
        $this->parameters = $parameters;
    }

    public function getString(): string{
        return $this->queryString;
    }

    public function getParameters(): array{
        return $this->parameters;
    }
}








Interface QueryInterface{
    public function getTable(): string;
    public function getColumns(): array;
    public function getWhere(): ?PredicateInterface;
}

class SelectQuery implements QueryInterface{
    private $table;
    private $columns = [];
    private $where = null;

    public function setTable($table){
        $this->table = $table;
        return $this;
    }

    public function setColumns(array $columns){
        $this->columns = $columns;
        return $this;
    }

    public function addWhere(PredicateInterface $conditions){
        $this->where = $conditions;
        return $this;
    }

    public function getTable(): string{
        return $this->table;
    }

    public function getColumns(): array{
        return $this->columns;
    }

    public function getWhere(): ?PredicateInterface{
        return $this->where;
    }

}


$selectQuery = new SelectQuery();
echo "Init select Query...\n";
$selectQuery->setTable('users')
           ->setColumns(['id', 'name', 'email'])
           ->addWhere(new AndCondition(
                        new IsEquals(new Column('country'), new Literal('USA')),
                        new IsEquals(new Column('status'), new FunctionCall('LOWER',new Literal('active'), new Literal('inactive'))),
                        new IsEquals(new Column('age'), new Literal(30)),
                        new OrCondition(
                            new IsEquals(new Column('role'), new Literal('admin')),
                            new IsEquals(new Column('role'), new Literal('user'))
                        )
                    ))
;

$queryCompiler = new SelectSqlQueryCompiler();
$sql = $queryCompiler->compile($selectQuery);
echo print_r($sql, true); 
