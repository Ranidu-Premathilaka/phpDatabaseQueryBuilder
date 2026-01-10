<?php
class CompiledQuery implements CompiledQueryInterface{
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
