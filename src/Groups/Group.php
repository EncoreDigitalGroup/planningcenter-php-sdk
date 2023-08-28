<?php
namespace EncoreDigitalGroup\PlanningCenter\Groups;

use GuzzleHttp\Psr7\Request;

class Group
{
    public function all($PCOClient, $query = [])
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['groups']['apiVersion'],
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/groups?' . $query, $headers);
        return $PCOClient->send($request, $query);
    }

    public function mine($PCOClient, $query = []): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['groups']['apiVersion'],
        ];
        $query = array_merge(
            [
                'filter' => 'my_groups',
            ], $query);
        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/groups?' . $query, $headers);
        return $PCOClient->send($request);
    }

    public function get($PCOClient, $id, $query = []): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['groups']['apiVersion'],
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/groups/' . $id . '?' . $query, $headers);
        return $PCOClient->send($request);
    }

    public function enrollment($PCOClient, $id, $query = []): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['groups']['apiVersion'],
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/groups/' . $id . '/enrollment?' . $query, $headers);
        return $PCOClient->send($request);
    }

    public function event($PCOClient, $id, $query = []): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['groups']['apiVersion'],
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/groups/' . $id . '/events?' . $query, $headers);
        return $PCOClient->send($request);
    }

    public function membership($PCOClient, $id, $query = []): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['groups']['apiVersion'],
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/groups/' . $id . '/memberships?' . $query, $headers);
        return $PCOClient->send($request);
    }

    public function people($PCOClient, $id, $query = []): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['groups']['apiVersion'],
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/groups/' . $id . '/people?' . $query, $headers);
        return $PCOClient->send($request);
    }
}


