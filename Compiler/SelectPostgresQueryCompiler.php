<?php
// Final class for orchestrating SELECT query compilation
final class SelectPostgresQueryCompiler extends PostgresQueryCompiler{
    public function compile(QueryInterface $query) : CompiledQueryInterface{
        $sql = "SELECT ";

        $columnsFragment = $this->compileColumns($query->getColumns());
        $sql .= $columnsFragment->getString();

        $sql .= " FROM ";
        $tableFragment = $this->compileTable($query->getTable());
        $sql .= $tableFragment->getString();

        if($query->getJoins()){
            $joinFragment = $this->compileJoins($query->getJoins());
            $sql .= ' ' . $joinFragment->getString();
        }

        if($query->getWhere()){
            $whereQueryFragment = $this->compileWhere($query->getWhere());
            $sql .= $whereQueryFragment->getString();
        }

        if($query->getOrderBy()){
            $orderByQueryFragment = $this->compileOrderBy($query->getOrderBy());
            $sql .= $orderByQueryFragment->getString();
        }

        if($query->getLimit()){
            $limitQueryFragment = $this->compileLimit($query->getLimit());
            $sql .= $limitQueryFragment->getString();
        }

        if($query->getOffset()){
            $offsetQueryFragment = $this->compileOffset($query->getOffset());
            $sql .= $offsetQueryFragment->getString();
        }

        return new CompiledQuery($sql, $this->ParameterContainer->getParameters());
    }
}
