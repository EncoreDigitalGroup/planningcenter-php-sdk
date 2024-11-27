<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

declare(strict_types=1);

use PHPGenesis\DevUtilities\Rector\Rector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
    ])
    ->withRules(Rector::rules());