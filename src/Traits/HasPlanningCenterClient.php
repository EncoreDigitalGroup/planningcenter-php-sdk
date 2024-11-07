<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Traits;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\PlanningCenterClient;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use PHPGenesis\Http\HttpClient;

trait HasPlanningCenterClient
{
    protected const HOSTNAME = 'https://api.planningcenteronline.com';

    protected string $clientId;
    protected string $clientSecret;

    public function __construct(?string $clientId = null, ?string $clientSecret = null)
    {
        $this->clientId = $clientId ?? '';
        $this->clientSecret = $clientSecret ?? '';
    }

    public function client(): PendingRequest
    {
        return HttpClient::withBasicAuth($this->clientId, $this->clientSecret);
    }

    public function hostname(): string
    {
        return self::HOSTNAME;
    }

    protected function processResponse(Response $http): ClientResponse
    {
        $clientResponse = new ClientResponse($http);
        $this->mapFromPco($http->json('data'));
        $clientResponse->data = $this->attributes;

        return $clientResponse;
    }
}
