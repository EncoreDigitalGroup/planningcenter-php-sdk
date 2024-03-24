<?php

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
