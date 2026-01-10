<?php
interface QueryCompilerInterface{
    public function compile(QueryInterface $query) : CompiledQueryInterface;
}
