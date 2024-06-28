<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter;

use PHPGenesis\Http\HttpClientBuilder;

class PlanningCenterClient
{
    protected HttpClientBuilder $builder;

    public function __construct()
    {
        $this->builder = new HttpClientBuilder;
    }
}
