<?php

interface JoinInterface{
    public function accept(JoinVisitorInterface $visitor);
}