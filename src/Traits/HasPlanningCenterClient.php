<?php

namespace EncoreDigitalGroup\PlanningCenter\Traits;

use EncoreDigitalGroup\PlanningCenter\ClientConfiguration;
use EncoreDigitalGroup\PlanningCenter\PlanningCenterClient;

trait HasPlanningCenterClient
{
    private ClientConfiguration $config;
    private PlanningCenterClient $client;
    public function __construct(PlanningCenterClient $client){
        $this->config = $client->getConfiguration();
        $this->client = new PlanningCenterClient($this->config);
    }
}