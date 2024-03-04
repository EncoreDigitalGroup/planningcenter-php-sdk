<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;

class Group
{
    use HasPlanningCenterClient;

    public function all($query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getGroupsApiVersion(),
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/groups?' . $query, $headers);

        return $this->client->send($request, $query);
    }

    public function mine($query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getGroupsApiVersion(),
        ];
        $query = array_merge(
            [
                'filter' => 'my_groups',
            ], $query);
        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/groups?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get($id, $query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getGroupsApiVersion(),
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/groups/' . $id . '?' . $query, $headers);

        return $this->client->send($request);
    }

    public function enrollment($id, $query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getGroupsApiVersion(),
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/groups/' . $id . '/enrollment?' . $query, $headers);

        return $this->client->send($request);
    }

    public function event($id, $query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getGroupsApiVersion(),
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/groups/' . $id . '/events?' . $query, $headers);

        return $this->client->send($request);
    }

    public function membership($id, $query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getGroupsApiVersion(),
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/groups/' . $id . '/memberships?' . $query, $headers);

        return $this->client->send($request);
    }

    public function people($id, $query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getGroupsApiVersion(),
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/groups/' . $id . '/people?' . $query, $headers);

        return $this->client->send($request);
    }
}
