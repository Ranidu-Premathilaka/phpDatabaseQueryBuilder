<?php
interface CompiledQueryInterface{
    public function getString(): string;
    public function getParameters(): array;
}
