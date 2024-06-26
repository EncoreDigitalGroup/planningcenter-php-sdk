<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;

class Group
{
    use HasPlanningCenterClient;

    public int $groupId;

    public function all(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/groups?' . $query, $headers);

        return $this->client->send($request);
    }

    public function mine(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = array_merge(['filter' => 'my_groups'], $query);
        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/groups?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/groups/' . $this->groupId . '?' . $query, $headers);

        return $this->client->send($request);
    }

    public function enrollment(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/groups/' . $this->groupId . '/enrollment?' . $query, $headers);

        return $this->client->send($request);
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
}
