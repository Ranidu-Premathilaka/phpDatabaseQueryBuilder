<?php

interface JoinVisitorInterface{
    public function __construct(ParameterContainerInterface &$parameterContainerReference);
    public function visitJoin(JoinInterface $visitor);
}