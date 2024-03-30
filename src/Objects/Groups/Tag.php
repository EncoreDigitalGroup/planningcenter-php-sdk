<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;

class Tag
{
    use HasPlanningCenterClient;

    public int $tagId;

    public function all(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/tag_groups?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/tags/' . $this->tagId . '?' . $query, $headers);

        return $this->client->send($request);
    }

    public function groups(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/tags/' . $this->tagId . '/groups?' . $query, $headers);

        return $this->client->send($request);
    }
}
