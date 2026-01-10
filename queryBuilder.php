<?php

Interface PredicateInterface{
    public function accept(TotalPredicateVisitorInterface $visitor);
}

Interface ComparisonInterface extends PredicateInterface{
    public function __construct(string $column,mixed $value);
    public function getColumn(): string;
    public function getValue(): mixed;
}

Interface LogicalInterface extends PredicateInterface{
    public function __construct(PredicateInterface ...$conditions);
    public function getConditions(): array;
}


class IsEquals implements ComparisonInterface{
    private $column;
    private $value;

    public function __construct(string $column, mixed $value){
        $this->column = $column;
        $this->value = $value;
    }

    public function accept(TotalPredicateVisitorInterface $visitor){
        return $visitor->visitEquals($this);
    }
    public function getColumn(): string{
        return $this->column;
    }
    public function getValue(): mixed{
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
}

interface ComparisonVisitorInterface extends PredicateVisitorInterface{
    public function visitEquals(IsEquals $equals);
}

interface LogicalVisitorInterface extends PredicateVisitorInterface{
    public function visitAnd(AndCondition $andCondition);
    public function visitOr(OrCondition $orCondition);
}

interface TotalPredicateVisitorInterface extends ComparisonVisitorInterface, LogicalVisitorInterface{
}

final class SqlPredicateVisitor implements TotalPredicateVisitorInterface{
    public function visitEquals(IsEquals $equals){
        $column = $equals->getColumn();
        $value = $equals->getValue();
        return "($column = '$value')"; 
    }

    public function visitAnd(AndCondition $andCondition){
        $conditions = $andCondition->getConditions();
        $sqlConditions = array_map(function($condition) {
            return $condition->accept($this);
        }, $conditions);
        return '(' . implode(' AND ', $sqlConditions) . ')';
    }

    public function visitOr(OrCondition $orCondition){
        $conditions = $orCondition->getConditions();
        $sqlConditions = array_map(function($condition) {
            return $condition->accept($this);
        }, $conditions);
        return '(' . implode(' OR ', $sqlConditions) . ')';
    }
}

interface QueryCompilerInterface{
    public function compile(QueryInterface $query) : string;
}

// Base class for handling SQL compilation tasks
abstract class SqlQueryCompiler implements QueryCompilerInterface{

    protected function compileWhere(PredicateInterface $predicate): string{
        $visitor = new SqlPredicateVisitor();
        return $predicate->accept($visitor);
    }
}

// Final class for orchestrating SELECT query compilation
final class SelectSqlQueryCompiler extends SqlQueryCompiler{
    public function compile(QueryInterface $query) : string{
        $table = $query->getTable();
        $columns = implode(', ', $query->getColumns());
        $sql = "SELECT $columns FROM $table";

        $whereClause = $this->compileWhere($query->getWhere());
        if ($whereClause) {
            $sql .= " WHERE " . $whereClause;
        }

        return $sql;
    }
}









Interface QueryInterface{
    public function getTable(): string;
    public function getColumns(): array;
    public function getWhere(): PredicateInterface;
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

    public function getWhere(): PredicateInterface{
        return $this->where;
    }

}


$selectQuery = new SelectQuery();
echo "Init select Query...\n";
$selectQuery->setTable('users')
           ->setColumns(['id', 'name', 'email'])
           ->addWhere(new AndCondition(new IsEquals( 'status', 'active' ),
            new IsEquals( 'age', 30 ),
            new OrCondition( new IsEquals( 'role', 'admin' ), new IsEquals( 'role', 'editor' ) ) ));

$queryCompiler = new SelectSqlQueryCompiler();
$sql = $queryCompiler->compile($selectQuery);
echo $sql; 
