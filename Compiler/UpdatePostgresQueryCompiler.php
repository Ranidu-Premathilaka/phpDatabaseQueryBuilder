<?php

final class UpdatePostgresQueryCompiler extends PostgresQueryCompiler{

    public function compile(QueryInterface $query) : CompiledQueryInterface{
        $sql = "UPDATE ";

        $sql .= $this->compileTable($query->getTable())->getString();
        
        $sql .= $this->compileSetClauses($query->getSetClauses())->getString();

        if($query->getWhere() !== null){
            $sql .= $this->compileWhere($query->getWhere())->getString();
        }

        return new CompiledQuery($sql, $this->ParameterContainer->getParameters());
    }
}
