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
            ->addOrderBy(new Desc(new Column('created_at')))
            ->addOrderBy(new Asc(new Column('name')))
            ->addLimit(new Literal(10))
            ->addOffset(new Literal(5))
            ->innerJoin(new Table('orders'), new IsEquals(new Column('users.id'), new Literal('1234')))
            ->leftJoin(new Table('profiles'), new IsEquals(new Column('users.id'), new Column('profiles.user_id')))
            ->rightJoin(new Table('payments'), new IsEquals(new Column('users.id'), new Column('payments.user_id')))
            ->outerJoin(new Table('subscriptions'), new IsEquals(new Column('users.id'), new Column('subscriptions.user_id')))
;

$queryCompiler = new SelectSqlQueryCompiler();
$sql = $queryCompiler->compile($selectQuery);
echo print_r($sql, true);
