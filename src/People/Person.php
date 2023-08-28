<?php
namespace EncoreDigitalGroup\PlanningCenter\People;

use GuzzleHttp\Psr7\Request;

class Person
{
    public function all($PCOClient, $query = [])
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['calendar']['apiVersion'],
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'people/v2/people?' . $query, $headers);
        return $PCOClient->send($request, $query);
    }

    public function get($PCOClient, $id, $query = []): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['calendar']['apiVersion'],
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'people/v2/people/' . $id . '?' . $query, $headers);
        return $PCOClient->send($request);
    }
}


