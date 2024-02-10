<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use stdClass;

class Event
{
    use HasPlanningCenterClient;

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
        $query = array_merge(
            [
                'filter' => 'future',
            ], $query);
        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get($id, $query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getCalenderApiVersion(),
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events/' . $id . '?' . $query, $headers);

        return $this->client->send($request);
    }

    public function instance($eventId, $eventInstanceId = '', $query = []): stdClass
    {
        $EventInstance = new EventInstance($this->client);
        if($eventInstanceId == '' || $eventInstanceId == null){
            return $EventInstance->all($eventId, $query);
        }

        return $EventInstance->get($eventId, $eventInstanceId, $query);
    }

    public function connection($id, $connection = '', $query = []): stdClass
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
