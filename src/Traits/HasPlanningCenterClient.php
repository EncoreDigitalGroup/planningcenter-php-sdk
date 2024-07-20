<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Traits;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\PlanningCenterClient;
use Illuminate\Http\Client\Response;

trait HasPlanningCenterClient
{
    protected string $baseUrl = 'https://api.planningcenteronline.com';
    protected PlanningCenterClient $client;

    public function __construct(?PlanningCenterClient $client = null)
    {
        $this->client = $client ?? new PlanningCenterClient();
    }

    public function client(): PlanningCenterClient
    {
        return $this->client;
    }

    protected function processResponse(Response $http): ClientResponse
    {
        $clientResponse = new ClientResponse($http);
        $this->mapFromPco($http->json('data'));
        $clientResponse->data = $this->attributes;

        return $clientResponse;
    }
}
