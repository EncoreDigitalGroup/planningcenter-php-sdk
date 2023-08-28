<?php

namespace EncoreDigitalGroup\PlanningCenter\Calendar;

use GuzzleHttp\Psr7\Request;

class Event
{
    public function all($PCOClient, $query = [])
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['calendar']['apiVersion'],
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events?' . $query, $headers);

        return $PCOClient->send($request, $query);
    }

    public function future($PCOClient, $query = []): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['calendar']['apiVersion'],
        ];
        $query = array_merge(
            [
                'filter' => 'future',
            ], $query);
        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events?' . $query, $headers);

        return $PCOClient->send($request);
    }

    public function get($PCOClient, $id, $query = []): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['calendar']['apiVersion'],
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events/' . $id . '?' . $query, $headers);

        return $PCOClient->send($request);
    }

    public function instance($PCOClient, $id, $instance = '', $query = []): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['calendar']['apiVersion'],
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events/' . $id . '/event_instances/' . $instance . '?' . $query, $headers);

        return $PCOClient->send($request);
    }

    public function connection($PCOClient, $id, $connection = '', $query = []): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['calendar']['apiVersion'],
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'calendar/v2/events/' . $id . '/event_connections/' . $connection . '?' . $query, $headers);

        return $PCOClient->send($request);
    }
}
