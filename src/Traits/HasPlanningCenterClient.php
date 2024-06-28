<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Traits;

use EncoreDigitalGroup\PlanningCenter\PlanningCenterClient;

trait HasPlanningCenterClient
{
    protected string $baseUrl = 'https://api.planningcenteronline.com';
    protected PlanningCenterClient $client;

    public function __construct(?PlanningCenterClient $client = null)
    {
        $this->client = $client ?? new PlanningCenterClient();
    }
}
