<?php
class QueryFragment implements QueryFragmentInterface{
    private $queryString;

    public function __construct(string $queryString){
        $this->queryString = $queryString;
    }

    public function getString(): string{
        return $this->queryString;
    }
}
