<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;

class EventInstance
{
    use HasPlanningCenterClient;

    public function all($eventId, $query = [])
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events/' . $eventId . '/event_instances/?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get($eventId, $eventInstanceId, $query = []): string
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/event_instances/' . $eventInstanceId . '?' . $query, $headers);

        return $this->client->send($request);
    }
}
