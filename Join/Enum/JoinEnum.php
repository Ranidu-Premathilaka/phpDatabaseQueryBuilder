<?php

enum JoinEnum : string{
    case INNER = 'INNER';
    case LEFT = 'LEFT';
    case RIGHT = 'RIGHT';
    case OUTER = 'OUTER';
}