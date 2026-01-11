<?php

class AllColumnsLiteral implements ExpressionInterface{
    public function accept(ExpressionVisitorInterface $visitor){
        return $visitor->visitAllColumnsLiteral($this);
    }
}