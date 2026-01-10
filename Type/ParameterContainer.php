<?php
// parallel processing isn't allowed in this context
class ParameterContainer implements ParameterContainerInterface{
    private $parameters = [];

    public function addParameter(ParameterInterface $parameter): string{
        $this->parameters[] = $parameter;
        return "?";
    }

    public function getParameters(): array{
        $data = [];
        foreach($this->parameters as $param){
            $data[] = $param->getValue();
        }

        return $data;
    }
}
