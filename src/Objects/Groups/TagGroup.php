<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;

class TagGroup
{
    use HasPlanningCenterClient;

    public int $tagGroupId;
    public int $tagId;

    public function all(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/tag_groups?' . $query, $headers);

        return $this->client->send($request);
    }

    public function tags(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/tag_groups/' . $this->tagGroupId . '/tags?' . $query, $headers);

        return $this->client->send($request);
    }

    public function tag(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/tag_groups/' . $this->tagGroupId . '/tags/' . $this->tagId . '?' . $query, $headers);

        return $this->client->send($request);
    }
}
