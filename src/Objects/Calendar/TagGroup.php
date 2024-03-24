<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;

/**
 * Class TagGroup
 *
 * @property int $tagGroupId
 * @property int $tagId
 */
class TagGroup
{
    use HasPlanningCenterClient;

    public int $tagGroupId;
    public int $tagId;

    public function all(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'calendar/v2/tag_groups?' . $query, $headers);

        return $this->client->send($request);
    }

    public function tag(array $query = []): ClientResponse
    {

        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $tagGroupId = $this->tagGroupId ?? '';

        $request = new Request('GET', 'calendar/v2/tag_groups/' . $tagGroupId . '/tags/' . $this->tagId . '?' . $query, $headers);

        return $this->client->send($request);
    }
}
