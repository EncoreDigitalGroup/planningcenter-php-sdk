<?php
namespace EncoreDigitalGroup\PlanningCenter\Calendar;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;

class Event
{
    public function getAll()
    {
        $config = $GLOBALS['pcoClientConfig'];
        $client = new GuzzleClient();
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['calendar']['apiVersion'],
        ];
        $request = new Request('GET', 'https://api.planningcenteronline.com/calendar/v2/events', $headers);
        $res = $client->sendAsync($request)->wait();
        return $res->getBody(); 
    }
}


