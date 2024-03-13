<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use stdClass;

/**
 * Class Event
 *
 * @property int $eventId
 * @property int $eventInstanceId
 * @property int $connectionId
 */
class Event
{
    use HasPlanningCenterClient;

    public mixed $eventId;
    public mixed $eventInstanceId;
    public mixed $connectionId;

    public function all($query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events?' . $query, $headers);

        return $this->client->send($request);
    }

    public function future($query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];

        $query = array_merge(['filter' => 'future'], $query);
        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get($query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events/' . $this->eventId . '?' . $query, $headers);

        return $this->client->send($request);
    }

    public function instance($query = []): stdClass
    {
        $eventInstance = new EventInstance($this->client);
        $eventInstance->eventInstanceId = $this->eventInstanceId;
        $eventInstance->eventId = $this->eventId;

        return $eventInstance->get($query);
    }

    public function instances($query = []): stdClass
    {
        $eventInstances = new EventInstance($this->client);
        $eventInstances->eventId = $this->eventId;

        return $eventInstances->all($this->eventId, $query);
    }

    public function connection($query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events/' . $this->eventId . '/event_connections/' . $this->connectionId . '?' . $query, $headers);

        return $this->client->send($request);
    }
}
