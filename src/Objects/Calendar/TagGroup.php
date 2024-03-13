<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use stdClass;

/**
 * Class TagGroup
 *
 * @property int $tagGroupId
 * @property int $tagId
 */
class TagGroup
{
    use HasPlanningCenterClient;

    public mixed $tagGroupId;
    public mixed $tagId;

    public function all($query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/tag_groups?' . $query, $headers);

        return $this->client->send($request, $query);
    }

    public function tag($query = []): stdClass
    {

        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];

        $query = http_build_query($query);

        $tagGroupId = $this->tagGroupId ?? '';
        $request = new Request('GET', 'calendar/v2/tag_groups/' . $tagGroupId . '/tags/' . $this->tagId . '?' . $query, $headers);

        return $this->client->send($request, $query);
    }
}
