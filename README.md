# PHP Database Query Builder

A type-safe query builder for PostgreSQL written in PHP

## What it does

Basically lets you build SQL queries using PHP objects instead of writing raw SQL strings. Uses the visitor pattern to compile queries for different databases (currently only supports PostgreSQL though).

## Features

- SELECT, INSERT, UPDATE, DELETE queries
- WHERE clauses with AND/OR logic
- Comparison operators (=, !=, <, >, <=, >=)
- IN and NOT IN clauses
- JOINs (INNER, LEFT, RIGHT, OUTER)
- ORDER BY with ASC/DESC
- LIMIT and OFFSET
- Parameterized queries to prevent SQL injection

## Usage

Check out `test.php` for examples. Basic select query looks like:

```php
<?php
require_once 'init.php';

$query = new SelectQuery();
$query->setTable(new Table('users'))
      ->setColumns(new Column('id'), new Column('name'))
      ->setWhere(new IsEquals(new Column('status'), new Literal('active')))
      ->addLimit(new Literal(10));

$compiler = new SelectPostgresQueryCompiler();
$result = $compiler->compile($query);
```

The compiler returns a CompiledQuery object with the SQL string and parameters separated out.

## Project Structure

- `Query/` - Query builder classes (SelectQuery, UpdateQuery, etc)
- `Compiler/` - Query compilers that turn query objects into SQL
- `Expression/` - Things like columns, literals, function calls
- `Predicate/` - WHERE clause conditions
- `Join/` - JOIN clause stuff
- `Type/` - Helper types for parameters and query fragments
