<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;

class Event
{
    use HasPlanningCenterClient;

    public int $eventId;

    public int $eventInstanceId;

    public int $connectionId;

    public function all(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'calendar/v2/events?' . $query, $headers);

        return $this->client->send($request);
    }

    public function future(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = array_merge(['filter' => 'future'], $query);
        $query = http_build_query($query);

        $request = new Request('GET', 'calendar/v2/events?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'calendar/v2/events/' . $this->eventId . '?' . $query, $headers);

        return $this->client->send($request);
    }

    public function instance(array $query = []): ClientResponse
    {
        $eventInstance = new EventInstance($this->client);
        $eventInstance->eventInstanceId = $this->eventInstanceId;
        $eventInstance->eventId = $this->eventId;

        return $eventInstance->get($query);
    }

    public function instances(array $query = []): ClientResponse
    {
        $eventInstances = new EventInstance($this->client);
        $eventInstances->eventId = $this->eventId;

        return $eventInstances->all($query);
    }

    public function connection(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'calendar/v2/events/' . $this->eventId . '/event_connections/' . $this->connectionId . '?' . $query, $headers);

        return $this->client->send($request);
    }
}
