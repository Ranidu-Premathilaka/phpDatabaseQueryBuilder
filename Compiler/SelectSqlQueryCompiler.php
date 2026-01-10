<?php
// Final class for orchestrating SELECT query compilation
final class SelectSqlQueryCompiler extends SqlQueryCompiler{
    public function compile(QueryInterface $query) : CompiledQueryInterface{
        $table = $query->getTable();
        $columns = implode(', ', $query->getColumns());
        $sql = "SELECT $columns FROM $table";

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
