<?php
require_once __DIR__ . '/init.php';

$selectQuery = new SelectQuery();
echo "Init select Query...\n";
$selectQuery->setTable(new Table('users'))
           ->setColumns(new Column('id'))
           ->setColumns(new Column('name'))
           ->setColumns(new Column('email'))
           ->setWhere(new AndCondition(
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
            ->innerJoin(new Table('orders'), new IsEquals(new Column("id", new Table('users')), new Literal('1234')))
            ->leftJoin(new Table('profiles'), new IsEquals(new Column('id', new Table('profiles')), new Column('user_id', new Table('profiles'))))
            ->rightJoin(new Table('payments'), new IsEquals(new Column('id', new Table('users')), new Column('user_id', new Table('payments'))))
            ->outerJoin(new Table('subscriptions'), new IsEquals(new Column('id', new Table('users')), new Column('user_id', new Table('subscriptions'))))
;

$queryCompiler = new SelectSqlQueryCompiler();
$sql = $queryCompiler->compile($selectQuery);
echo print_r($sql, true);

echo "\n\n";
$updateQuery = new UpdateQuery();
echo "Init update Query...\n";
$updateQuery->setTable(new Table('users'))
            ->addSetClause(new IsEquals(new Column('status'), new FunctionCall('LOWER', new Literal('active'), new Literal('inactive'))))
            ->addSetClause(new IsEquals(new Column('last_login'), new Literal(date('Y-m-d H:i:s'))))
            ->setWhere(new IsEquals(new Column('id'), new Literal(1234)))
;

$queryCompiler = new UpdateSqlQueryCompiler();
$sql = $queryCompiler->compile($updateQuery);
echo print_r($sql, true);