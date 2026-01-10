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
require_once __DIR__ . '/Predicate/Interface/PredicateVisitorInterface.php';
require_once __DIR__ . '/Predicate/Interface/ComparisonVisitorInterface.php';
require_once __DIR__ . '/Predicate/Interface/LogicalVisitorInterface.php';
require_once __DIR__ . '/Predicate/Interface/TotalPredicateVisitorInterface.php';

// Query interfaces
require_once __DIR__ . '/Query/Interface/QueryInterface.php';

// Compiler interfaces
require_once __DIR__ . '/Compiler/Interface/QueryCompilerInterface.php';


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
require_once __DIR__ . '/Expression/Visitor/sqlExpressionVisitor.php';

// Predicate implementations
require_once __DIR__ . '/Predicate/Comparison/IsEquals.php';
require_once __DIR__ . '/Predicate/Logical/AndCondition.php';
require_once __DIR__ . '/Predicate/Logical/OrCondition.php';
require_once __DIR__ . '/Predicate/Visitor/SqlPredicateVisitor.php';

// Query implementations
require_once __DIR__ . '/Query/SelectQuery.php';

// Compiler implementations
require_once __DIR__ . '/Compiler/SqlQueryCompiler.php';
require_once __DIR__ . '/Compiler/SelectSqlQueryCompiler.php';
