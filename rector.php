<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

declare(strict_types=1);

use PHPGenesis\Common\Resources\Rector\ReplaceSingleQuotesWithDoubleRector;
use Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector;
use Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector;
use Rector\CodeQuality\Rector\If_\CompleteMissingIfElseBracketRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\Config\RectorConfig;
use Rector\EarlyReturn\Rector\StmtsAwareInterface\ReturnEarlyIfVariableRector;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\Strict\Rector\BooleanNot\BooleanInBooleanNotRuleFixerRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
    ])
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    ->withRules([
        AddVoidReturnTypeWhereNoReturnRector::class,
        ReplaceSingleQuotesWithDoubleRector::class,
    ])
    ->withSkip([
        BooleanInBooleanNotRuleFixerRector::class,
        CatchExceptionNameMatchingTypeRector::class,
        CompactToVariablesRector::class,
        CompleteMissingIfElseBracketRector::class,
        EncapsedStringsToSprintfRector::class,
        LogicalToBooleanRector::class,
        NewlineAfterStatementRector::class,
        RemoveExtraParametersRector::class,
        RenameForeachValueVariableToMatchExprVariableRector::class,
        RenameParamToMatchTypeRector::class,
        RenamePropertyToMatchTypeRector::class,
        RenameVariableToMatchMethodCallReturnTypeRector::class,
        RenameVariableToMatchNewTypeRector::class,
        ReturnEarlyIfVariableRector::class,
        SeparateMultiUseImportsRector::class,
        UseIdenticalOverEqualWithSameTypeRector::class,
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        strictBooleans: true
    );
