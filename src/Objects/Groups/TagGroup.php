<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use stdClass;

class TagGroup
{
    use HasPlanningCenterClient;

    public function all($query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getGroupsApiVersion(),
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/tag_groups?' . $query, $headers);

        return $this->client->send($request, $query);
    }

    public function tag($id, $tag = '', $query = []): stdClass
    {
        if ($tag == null) {
            $tag = '';
        }

        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getGroupsApiVersion(),
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/tag_groups/' . $id . '/tags/' . $tag . '?' . $query, $headers);

        return $this->client->send($request);
    }
}
