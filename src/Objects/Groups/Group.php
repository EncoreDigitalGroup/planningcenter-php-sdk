<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Configuration\AuthorizationOptions;
use EncoreDigitalGroup\PlanningCenter\Configuration\ClientConfiguration;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\GroupAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\PlanningCenterClient;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use PHPGenesis\Common\Container\PhpGenesisContainer;
use PHPGenesis\Http\HttpClient;

/** @api */
class Group
{
    use HasPlanningCenterClient;

    public GroupAttributes $attributes;
    protected AuthorizationOptions $auth;

    public function __construct(?PlanningCenterClient $client = null)
    {
        $this->client = $client ?? new PlanningCenterClient();
        $this->attributes = new GroupAttributes();
        $this->auth = PhpGenesisContainer::getInstance()->get(ClientConfiguration::class)->authorization();
    }

    public function all(array $query = []): ClientResponse
    {
        $http = HttpClient::withBasicAuth($this->auth->getClientId(), $this->auth->getClientSecret())
            ->get($this->client->getBaseUrl() . '/groups/v2/groups', $query);

        return $this->processResponse($http);
    }

    public function mine(array $query = []): ClientResponse
    {
        $query = array_merge(['filter' => 'my_groups'], $query);

        $http = HttpClient::withBasicAuth($this->auth->getClientId(), $this->auth->getClientSecret())
            ->get($this->client->getBaseUrl() . '/groups/v2/groups', $query);

        return $this->processResponse($http);
    }

    public function get(array $query = []): ClientResponse
    {
        $http = HttpClient::withBasicAuth($this->auth->getClientId(), $this->auth->getClientSecret())
            ->get($this->client->getBaseUrl() . '/groups/v2/groups/' . $this->attributes->groupId, $query);

        return $this->processResponse($http);
    }

    public function enrollment(): ClientResponse
    {
        $enrollment = new GroupEnrollment($this->client);
        $enrollment->attributes->groupId = $this->attributes->groupId;

        return $enrollment->get();
    }

    public function event(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/groups/' . $this->groupId . '/events?' . $query, $headers);

        return $this->client->send($request);
    }

    public function membership(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/groups/' . $this->groupId . '/memberships?' . $query, $headers);

        return $this->client->send($request);
    }

    public function people(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/groups/' . $this->groupId . '/people?' . $query, $headers);

        return $this->client->send($request);
    }

    protected function mapFromPco(array $pco): void
    {
        $pco = objectify($pco);

        $this->attributes->groupId = $pco->id;
        $this->attributes->archivedAt = $pco->attributes->archived_at;
        $this->attributes->contactEmail = $pco->attributes->contact_email;
        $this->attributes->createdAt = $pco->attributes->created_at;
        $this->attributes->description = $pco->attributes->description;
        $this->attributes->eventVisibility = $pco->attributes->event_visibility;
        $this->attributes->headerImage->thumbnail = $pco->attributes->header_image->thumbnail;
        $this->attributes->headerImage->medium = $pco->attributes->header_image->medium;
        $this->attributes->headerImage->original = $pco->attributes->header_image->original;
        $this->attributes->locationTypePreference = $pco->attributes->location_type_preference;
        $this->attributes->membershipsCount = $pco->attributes->memberships_count;
        $this->attributes->name = $pco->attributes->name;
        $this->attributes->publicChurchCenterUrl = $pco->attributes->public_church_center_url;
        $this->attributes->schedule = $pco->attributes->schedule;
        $this->attributes->virtualLocationUrl = $pco->attributes->virtual_location_url;


    }
}
