<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;

class Event
{
    use HasPlanningCenterClient;

    public function all($query = [])
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events?' . $query, $headers);

        return $this->client->send($request);
    }

    public function future($query = []): string
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];
        $query = array_merge(
            [
                'filter' => 'future',
            ], $query);
        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get($id, $query = []): string
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events/' . $id . '?' . $query, $headers);

        return $this->client->send($request);
    }

    public function instance($eventId, $eventInstanceId = '', $query = []): string
    {
        $EventInstance = new EventInstance($this->client);
        if($eventInstanceId == '' || $eventInstanceId == null){
            return $EventInstance->all($eventId, $query);
        }

        return $EventInstance->get($eventId, $eventInstanceId, $query);
    }

    public function connection($id, $connection = '', $query = []): string
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events/' . $id . '/event_connections/' . $connection . '?' . $query, $headers);

        return $this->client->send($request);
    }
}
