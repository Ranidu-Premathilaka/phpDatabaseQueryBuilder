<?php
require_once __DIR__ . '/init.php';

$selectQuery = new SelectQuery();
echo "Init select Query...\n";
$selectQuery->setTable('users')
           ->setColumns(['id', 'name', 'email'])
           ->addWhere(new AndCondition(
                        new IsEquals(new Column('country'), new Literal('USA')),
                        new IsEquals(new Column('status'), new FunctionCall('LOWER',new Literal('active'), new Literal('inactive'))),
                        new IsEquals(new Column('age'), new Literal(30)),
                        new OrCondition(
                            new IsEquals(new Column('role'), new Literal('admin')),
                            new IsEquals(new Column('role'), new Literal('user'))
                        )
                    ))
;

$queryCompiler = new SelectSqlQueryCompiler();
$sql = $queryCompiler->compile($selectQuery);
echo print_r($sql, true);
