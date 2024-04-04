<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;

class Event
{
    use HasPlanningCenterClient;

    public int $eventId;

    public function all(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/events?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'groups/v2/events/' . $this->eventId . '?' . $query, $headers);

        return $this->client->send($request);
    }
}
