<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use stdClass;

class EventInstance
{
    use HasPlanningCenterClient;

    public int $eventInstanceId;
    public int $eventId;

    public function all(array $query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events/' . $this->eventId . '/event_instances/?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get(array $query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/event_instances/' . $this->eventInstanceId . '?' . $query, $headers);

        return $this->client->send($request);
    }
}
