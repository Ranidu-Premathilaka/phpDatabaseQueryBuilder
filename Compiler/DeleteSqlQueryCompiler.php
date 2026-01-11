<?php

class DeleteSqlQueryCompiler extends SqlQueryCompiler{
    public function compile(QueryInterface $query): CompiledQueryInterface{
        $sql = "DELETE FROM ";
        $sql .= $this->compileTable($query->getTable())->getString();
        
        if($query->getWhere() !== null){
            $sql .= $this->compileWhere($query->getWhere())->getString();
        }
        
        return new CompiledQuery($sql, $this->ParameterContainer->getParameters());
    }
}