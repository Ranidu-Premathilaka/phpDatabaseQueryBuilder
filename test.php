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
                            new LessThanOrEquals(new Column('signup_date'), new Literal('2022-01-01')),
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

$queryCompiler = new SelectPostgresQueryCompiler();
$sql = $queryCompiler->compile($selectQuery);
echo print_r($sql, true);

echo "\n\n";
$updateQuery = new UpdateQuery();
echo "Init update Query...\n";
$updateQuery->setTable(new Table('users'))
            ->addSetClause(new IsEquals(new Column('status'), new FunctionCall('LOWER', new Literal('active'), new Literal('inactive'))))
            ->addSetClause(new IsEquals(new Column('last_login'), new Literal(date('Y-m-d H:i:s'))))
            ->setWhere(new AndCondition(
                new Is(new Column('id'), new Boolean(false)),
                new IsEquals(new Column('role'), new Literal('user')),
                new Is(new Column('deleted_at'), new NullLiteral())
            ))
;

$queryCompiler = new UpdatePostgresQueryCompiler();
$sql = $queryCompiler->compile($updateQuery);
echo print_r($sql, true);

echo "\n\n";
$deleteQuery = new DeleteQuery();
echo "Init delete Query...\n";
$deleteQuery->setTable(new Table('users'))
            ->setWhere(new AndCondition(
                new IsEquals(new Column('id'), new Literal(1234)),
                new IsEquals(new Column('status'), new Literal('inactive')),
                new IsEquals(new Column('deleted'), new Boolean(true)),
            ))
;
$queryCompiler = new DeletePostgresQueryCompiler();
$sql = $queryCompiler->compile($deleteQuery);
echo print_r($sql, true);

echo "\n\n";
$inTestQuery = new SelectQuery();
echo "Init IN and NOT IN test Query...\n";
$inTestQuery->setTable(new Table('products'))
            ->setColumns(new Column('id'))
            ->setColumns(new Column('name'))
            ->setColumns(new Column('price'))
            ->setWhere(new AndCondition(
                new IsIn(new Column('category_id'), [
                    new Literal(1),
                    new Literal(2),
                    new Literal(3)
                ]),
                new IsNotIn(new Column('status'), [
                    new Literal('discontinued'),
                    new Literal('out_of_stock')
                ]),
                new IsIn(new Column('brand'), [
                    new FunctionCall('UPPER', new Literal('nike')),
                    new FunctionCall('UPPER', new Literal('adidas')),
                    new Literal('Puma')
                ]),
                new GreaterThanOrEquals(new Column('price'), new Literal(10.00)),
                new IsNotIn(new Column('supplier_id'), [
                    new Literal(999),
                    new Column('id', new Table('banned_suppliers'))
                ])
            ))
;
$queryCompiler = new SelectPostgresQueryCompiler();
$sql = $queryCompiler->compile($inTestQuery);
echo print_r($sql, true);

echo "\n\n";
$incrementQuery = new UpdateQuery();
echo "Init increment/decrement Query...\n";
$incrementQuery->setTable(new Table('accounts'))
               ->addSetClause(new IsEquals(
                   new Column('balance'), 
                   new BinaryOperation(new Column('balance'), '+', new Literal(100))
               ))
               ->addSetClause(new IsEquals(
                   new Column('total_transactions'), 
                   new BinaryOperation(new Column('total_transactions'), '+', new Literal(1))
               ))
               ->addSetClause(new IsEquals(
                   new Column('discount_percentage'), 
                   new BinaryOperation(new Column('discount_percentage'), '*', new Literal(1.1))
               ))
               ->setWhere(new AndCondition(
                   new IsEquals(new Column('id'), new Literal(42)),
                   new IsEquals(new Column('status'), new Literal('active'))
               ))
;

$queryCompiler = new UpdatePostgresQueryCompiler();
$sql = $queryCompiler->compile($incrementQuery);
echo print_r($sql, true);

echo "\n\n";
$insertQuery = new InsertQuery();
echo "Init INSERT Query with multiple records...\n";
$insertQuery->setTable(new Table('users'))
            ->setColumns(
                new Column('name'),
                new Column('email'),
                new Column('age'),
                new Column('status')
            )
            ->addRecord(
                new Literal('John Doe'),
                new Literal('john@example.com'),
                new Literal(25),
                new Literal('active')
            )
            ->addRecord(
                new Literal('Jane Smith'),
                new Literal('jane@example.com'),
                new Literal(30),
                new Literal('active')
            )
            ->addRecord(
                new Literal('Bob Johnson'),
                new Literal('bob@example.com'),
                new Literal(35),
                new FunctionCall('LOWER', new Literal('ACTIVE'))
            )
            ->setReturning(
                new Column('id'),
                new Column('name'),
                new Column('email')
            )
;

$queryCompiler = new InsertPostgresQueryCompiler();
$sql = $queryCompiler->compile($insertQuery);
echo print_r($sql, true);