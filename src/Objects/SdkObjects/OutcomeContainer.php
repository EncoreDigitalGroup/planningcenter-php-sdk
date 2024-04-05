<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects;

class OutcomeContainer
{
    public bool $success;
    public bool $rateLimited;
    public HttpContainer $http;

    public function __construct()
    {
        $this->http = new HttpContainer;
    }
}
