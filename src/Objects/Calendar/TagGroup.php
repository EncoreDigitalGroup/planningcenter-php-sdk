<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;

class TagGroup
{
    use HasPlanningCenterClient;
    public function all($query = [])
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/tag_groups?' . $query, $headers);

        return $this->client->send($request, $query);
    }

    public function tag($id, $tag = '', $query = []): string
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/tag_groups/' . $id . '/tags/' . $tag . '?' . $query, $headers);

        return $this->client->send($request, $query);
    }
}
