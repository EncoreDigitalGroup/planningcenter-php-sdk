<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use stdClass;

class Event
{
    use HasPlanningCenterClient;

    public int $eventId;
    public int $eventInstanceId;
    public int $connectionId;

    public function all(array $query = []): stdClass
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'calendar/v2/events?' . $query, $headers);

        return $this->client->send($request);
    }

    public function future(array $query = []): stdClass
    {
        $headers = $this->buildHeaders();

        $query = array_merge(['filter' => 'future'], $query);
        $query = http_build_query($query);

        $request = new Request('GET', 'calendar/v2/events?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get(array $query = []): stdClass
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'calendar/v2/events/' . $this->eventId . '?' . $query, $headers);

        return $this->client->send($request);
    }

    public function instance(array $query = []): stdClass
    {
        $eventInstance = new EventInstance($this->client);
        $eventInstance->eventInstanceId = $this->eventInstanceId;
        $eventInstance->eventId = $this->eventId;

        return $eventInstance->get($query);
    }

    public function instances(array $query = []): stdClass
    {
        $eventInstances = new EventInstance($this->client);
        $eventInstances->eventId = $this->eventId;

        return $eventInstances->all($query);
    }

    public function connection(array $query = []): stdClass
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);
        
        $request = new Request('GET', 'calendar/v2/events/' . $this->eventId . '/event_connections/' . $this->connectionId . '?' . $query, $headers);

        return $this->client->send($request);
    }
}
