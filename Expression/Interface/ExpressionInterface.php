<?php
Interface ExpressionInterface{
    public function accept(ExpressionVisitorInterface $visitor);
}
