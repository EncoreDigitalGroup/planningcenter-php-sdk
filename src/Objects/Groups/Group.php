<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use stdClass;

class Group
{
    use HasPlanningCenterClient;

    public int $groupId;

    public function all(array $query = []): stdClass
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/groups?' . $query, $headers);

        return $this->client->send($request, $query);
    }

    public function mine(array $query = []): stdClass
    {
        $headers = $this->buildHeaders();

        $query = array_merge(['filter' => 'my_groups',], $query);
        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/groups?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get(array $query = []): stdClass
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/groups/' . $this->groupId . '?' . $query, $headers);

        return $this->client->send($request);
    }

    public function enrollment(array $query = []): stdClass
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/groups/' . $this->groupId . '/enrollment?' . $query, $headers);

        return $this->client->send($request);
    }

    public function event(array $query = []): stdClass
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/groups/' . $this->groupId . '/events?' . $query, $headers);

        return $this->client->send($request);
    }

    public function membership(array $query = []): stdClass
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/groups/' . $this->groupId . '/memberships?' . $query, $headers);

        return $this->client->send($request);
    }

    public function people(array $query = []): stdClass
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/groups/' . $this->groupId . '/people?' . $query, $headers);

        return $this->client->send($request);
    }
}
