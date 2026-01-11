<?php
// ========== INTERFACES ==========

// Type interfaces
require_once __DIR__ . '/Type/Interface/ParameterInterface.php';
require_once __DIR__ . '/Type/Interface/ParameterContainerInterface.php';
require_once __DIR__ . '/Type/Interface/QueryFragmentInterface.php';
require_once __DIR__ . '/Type/Interface/CompiledQueryInterface.php';

// Expression interfaces
require_once __DIR__ . '/Expression/Interface/ExpressionInterface.php';
require_once __DIR__ . '/Expression/Interface/ExpressionVisitorInterface.php';

// Predicate interfaces
require_once __DIR__ . '/Predicate/Interface/PredicateInterface.php';
require_once __DIR__ . '/Predicate/Interface/ComparisonInterface.php';
require_once __DIR__ . '/Predicate/Interface/LogicalInterface.php';
require_once __DIR__ . '/Predicate/Interface/InInterface.php';
require_once __DIR__ . '/Predicate/Interface/PredicateVisitorInterface.php';
require_once __DIR__ . '/Predicate/Interface/ComparisonVisitorInterface.php';
require_once __DIR__ . '/Predicate/Interface/LogicalVisitorInterface.php';
require_once __DIR__ . '/Predicate/Interface/InVisitorInterface.php';
require_once __DIR__ . '/Predicate/Interface/TotalPredicateVisitorInterface.php';

// Join interfaces
require_once __DIR__ . '/Join/Interface/JoinInterface.php';
require_once __DIR__ . '/Join/Interface/JoinVisitorInterface.php';

// Query interfaces
require_once __DIR__ . '/Query/Interface/QueryInterface.php';
require_once __DIR__ . '/Query/Interface/SelectQueryInterface.php';
require_once __DIR__ . '/Query/Interface/UpdateQueryInterface.php';
require_once __DIR__ . '/Query/Interface/DeleteQueryInterface.php';

// Compiler interfaces
require_once __DIR__ . '/Compiler/Interface/QueryCompilerInterface.php';


// ========== ENUMS ==========
// Join Enums
require_once __DIR__ . '/Join/Enum/JoinEnum.php';

// ========== IMPLEMENTATIONS ==========

// Type implementations
require_once __DIR__ . '/Type/Parameter.php';
require_once __DIR__ . '/Type/ParameterContainer.php';
require_once __DIR__ . '/Type/QueryFragment.php';
require_once __DIR__ . '/Type/CompiledQuery.php';

// Expression implementations
require_once __DIR__ . '/Expression/Column.php';
require_once __DIR__ . '/Expression/FunctionCall.php';
require_once __DIR__ . '/Expression/Literal.php';
require_once __DIR__ . '/Expression/Asc.php';
require_once __DIR__ . '/Expression/Desc.php';
require_once __DIR__ . '/Expression/Table.php';
require_once __DIR__ . '/Expression/Boolean.php';
require_once __DIR__ . '/Expression/NullLiteral.php';
require_once __DIR__ . '/Expression/Visitor/sqlExpressionVisitor.php';

// Predicate implementations
require_once __DIR__ . '/Predicate/Comparison/Comparison.php';
require_once __DIR__ . '/Predicate/Comparison/IsEquals.php';
require_once __DIR__ . '/Predicate/Comparison/NotEquals.php';
require_once __DIR__ . '/Predicate/Comparison/LessThan.php';
require_once __DIR__ . '/Predicate/Comparison/GreaterThan.php';
require_once __DIR__ . '/Predicate/Comparison/LessThanOrEquals.php';
require_once __DIR__ . '/Predicate/Comparison/GreaterThanOrEquals.php';
require_once __DIR__ . '/Predicate/Comparison/Is.php';
require_once __DIR__ . '/Predicate/In/In.php';
require_once __DIR__ . '/Predicate/In/IsIn.php';
require_once __DIR__ . '/Predicate/In/IsNotIn.php';
require_once __DIR__ . '/Predicate/Logical/AndCondition.php';
require_once __DIR__ . '/Predicate/Logical/OrCondition.php';
require_once __DIR__ . '/Predicate/Visitor/SqlPredicateVisitor.php';

// Join implementations
require_once __DIR__ . '/Join/Join.php';
require_once __DIR__ . '/Join/Visitor/SqlJoinVisitor.php';

// Query implementations
require_once __DIR__ . '/Query/SelectQuery.php';
require_once __DIR__ . '/Query/UpdateQuery.php';
require_once __DIR__ . '/Query/DeleteQuery.php';

// Compiler implementations
require_once __DIR__ . '/Compiler/SqlQueryCompiler.php';
require_once __DIR__ . '/Compiler/SelectSqlQueryCompiler.php';
require_once __DIR__ . '/Compiler/UpdateSqlQueryCompiler.php';
require_once __DIR__ . '/Compiler/DeleteSqlQueryCompiler.php';