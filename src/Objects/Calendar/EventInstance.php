<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;

/** @api */
class EventInstance
{
    use HasPlanningCenterClient;

    public int $eventInstanceId;
    public int $eventId;

    public function all(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'calendar/v2/events/' . $this->eventId . '/event_instances/?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'calendar/v2/event_instances/' . $this->eventInstanceId . '?' . $query, $headers);

        return $this->client->send($request);
    }
}
