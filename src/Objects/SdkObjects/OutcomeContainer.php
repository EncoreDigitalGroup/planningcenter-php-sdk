<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects;

use EncoreDigitalGroup\SdkClientFoundation\SdkObjects\HttpContainer as BaseHttpContainer;
use EncoreDigitalGroup\SdkClientFoundation\SdkObjects\OutcomeContainer as BaseOutcomeContainer;

class OutcomeContainer extends BaseOutcomeContainer
{
    public bool $success;
    public bool $rateLimited;
    public BaseHttpContainer $http;

    public function __construct()
    {
        $this->http = new HttpContainer;
    }
}
