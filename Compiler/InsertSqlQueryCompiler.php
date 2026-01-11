<?php

final class InsertSqlQueryCompiler extends SqlQueryCompiler{

    public function compile(QueryInterface $query) : CompiledQueryInterface{
        $sql = "INSERT INTO ";

        // Compile table name
        $sql .= $this->compileTable($query->getTable())->getString();

        // Compile columns
        if(!empty($query->getColumns())){
            $columnsFragment = $this->compileColumns($query->getColumns());
            $sql .= "(". $columnsFragment->getString() . ') ';
        }

        // Compile values
        if(!empty($query->getRecords())){
            $valuesFragment = $this->compileValues($query->getRecords());
            $sql .= $valuesFragment->getString();
        }

        if(!empty($query->getReturning())){
            $returningFragment = $this->compileReturning($query->getReturning());
            $sql .= $returningFragment->getString();
        }

        return new CompiledQuery($sql, $this->ParameterContainer->getParameters());
    }
}
