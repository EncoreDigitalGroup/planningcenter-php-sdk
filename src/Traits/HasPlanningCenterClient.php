<?php

namespace EncoreDigitalGroup\PlanningCenter\Traits;

use EncoreDigitalGroup\PlanningCenter\ClientConfiguration;
use EncoreDigitalGroup\PlanningCenter\PlanningCenterClient;

trait HasPlanningCenterClient
{
    protected mixed $config;
    protected mixed $client;
    public function __construct(mixed $client){
        $this->config = $client->getConfiguration();
        $this->client = $client;
    }
}