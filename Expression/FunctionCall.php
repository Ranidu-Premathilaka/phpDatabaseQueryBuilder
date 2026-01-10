<?php

/**
 * Represents a SQL function call.
 * 
 * Usage:
 * ```php
 * new FunctionCall('LOWER', new Literal('active'), new Literal('inactive'))
 * new FunctionCall('COUNT', new Column('id'))
 * ```
 */
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
