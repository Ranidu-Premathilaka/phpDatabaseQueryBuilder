<?php
interface ParameterContainerInterface{
    public function addParameter(ParameterInterface $parameter): string;
    public function getParameters(): array;
}
