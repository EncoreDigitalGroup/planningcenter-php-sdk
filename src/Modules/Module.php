<?php

namespace EncoreDigitalGroup\PlanningCenter\Modules;

use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;

abstract class Module
{
    use HasClient;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }
}
