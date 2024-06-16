<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Traits;

use EncoreDigitalGroup\SdkClientFoundation\SdkObjects\ClientResponse;

trait HasPlanningCenterClient
{
    protected mixed $config;
    protected mixed $client;
    protected ClientResponse $clientResponse;

    public function __construct(mixed $client)
    {
        $this->config = $client->getConfiguration();
        $this->client = $client;
    }

    public function getClientResponse(): ClientResponse
    {
        return $this->clientResponse;
    }

    private function buildHeaders(): array
    {
        return [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getGroupsApiVersion(),
        ];
    }
}
