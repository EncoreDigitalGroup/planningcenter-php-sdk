<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Traits;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use PHPGenesis\Http\HttpClient;

trait HasPlanningCenterClient
{
    protected const string HOSTNAME = "https://api.planningcenteronline.com";

    protected string $clientId;
    protected string $clientSecret;
    protected string $apiVersion = "";

    public function __construct(?string $clientId = null, ?string $clientSecret = null)
    {
        $this->clientId = $clientId ?? "";
        $this->clientSecret = $clientSecret ?? "";
    }

    public function client(): PendingRequest
    {
        return HttpClient::withBasicAuth($this->clientId, $this->clientSecret)
            ->withHeader("X-PCO-API-Version", $this->apiVersion);
    }

    public function hostname(): string
    {
        return self::HOSTNAME;
    }

    public function setApiVersion(string $apiVersion): static
    {
        $this->apiVersion = $apiVersion;

        return $this;
    }

    protected function processResponse(Response $http): ClientResponse
    {
        $clientResponse = new ClientResponse($http);

        if (
            $this->apiVersion == PlanningCenterApiVersion::PEOPLE_DEFAULT
            || $this->apiVersion == PlanningCenterApiVersion::GROUPS_DEFAULT
            || $this->apiVersion == PlanningCenterApiVersion::CALENDAR_DEFAULT
        ) {
            $this->mapFromPco($http->json("data"));
            if (!is_null($http->json("data"))) {
                $clientResponse->data->add($this);
            }
        }

        return $clientResponse;
    }
}
