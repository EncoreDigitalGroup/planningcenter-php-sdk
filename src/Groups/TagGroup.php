<?php
namespace EncoreDigitalGroup\PlanningCenter\Groups;

use GuzzleHttp\Psr7\Request;

class TagGroup
{
    public function all($PCOClient, $query = [])
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['groups']['apiVersion'],
        ];

       $query = http_build_query($query);
       $request = new Request('GET', 'groups/v2/tag_groups?' . $query, $headers);
       return $PCOClient->send($request, $query);
    }

    public function tag($PCOClient, $id, $tag = '', $query = []): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['groups']['apiVersion'],
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'groups/v2/tag_groups/' . $id . '/tags/' . $tag . '?' . $query, $headers);
        return $PCOClient->send($request);
    }
}


