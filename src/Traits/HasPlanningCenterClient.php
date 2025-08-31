<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2025. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Traits;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\AuthType;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use PHPGenesis\Http\HttpClient;
use PHPGenesis\Http\HttpClientBuilder;

trait HasPlanningCenterClient
{
    protected const string HOSTNAME = "https://api.planningcenteronline.com";

    /** @experimental This could change. Use with caution. */
    protected const string X_PCO_API_VERSION_HEADER = "X-PCO-API-Version";

    protected string $clientId;
    protected string $clientSecret;
    protected string $apiVersion = "";

    /** @experimental This could change. Use with caution. */
    protected AuthType $authType = AuthType::Basic;

    public function __construct(?string $clientId = null, ?string $clientSecret = null)
    {
        $this->clientId = $clientId ?? "";
        $this->clientSecret = $clientSecret ?? "";

        new HttpClientBuilder;
    }

    public function client(): PendingRequest
    {
        if ($this->authType == AuthType::Token) {
            return HttpClient::withToken($this->clientId)
                ->withHeader(self::X_PCO_API_VERSION_HEADER, $this->apiVersion);
        }

        return HttpClient::withBasicAuth($this->clientId, $this->clientSecret)
            ->withHeader(self::X_PCO_API_VERSION_HEADER, $this->apiVersion);
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

    /** @experimental This could change. Use with caution. */
    public function setAuthType(AuthType $authType): static
    {
        $this->authType = $authType;

        return $this;
    }

    /** @experimental This could change. Use with caution. */
    public function withBasicAuth(?string $clientId = null, ?string $clientSecret = null): static
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;

        return $this->setAuthType(AuthType::Basic);
    }

    /** @experimental This could change. Use with caution. */
    public function withToken(?string $token = null): static
    {
        $this->clientId = $token;
        $this->clientSecret = null;

        return $this->setAuthType(AuthType::Token);
    }

    protected function processResponse(Response $http): ClientResponse
    {
        $clientResponse = new ClientResponse($http);

        if ($this->isUsingSupportedApiVersion()) {
            $this->mapFromPco($clientResponse);
        }

        return $clientResponse;
    }

    protected function isUsingSupportedApiVersion(): bool
    {
        return $this->apiVersion == PlanningCenterApiVersion::PEOPLE_DEFAULT
            || $this->apiVersion == PlanningCenterApiVersion::GROUPS_DEFAULT
            || $this->apiVersion == PlanningCenterApiVersion::CALENDAR_DEFAULT;
    }
}
