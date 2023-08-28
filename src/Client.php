<?php
namespace EncoreDigitalGroup\PlanningCenter;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

class Client
{
    public $config;
    
    public function configure($config = [])
    {
        $handler = new CurlHandler();
        $stack = HandlerStack::create($handler); // Wrap w/ middleware
        $GLOBALS['pcoClientConfig'] = array_merge(
            [
                'calendar' => [
                    'apiVersion' => '2021-07-20',
                ],
                'groups' => [
                    'apiVersion' => '2023-07-10',
                ],
                'people' => [
                    'apiVersion' => '2023-02-15',
                ],
            ], $config);
        
        $GLOBALS['pcoClient'] = new GuzzleClient(
            [
                'base_uri' => 'https://api.planningcenteronline.com',
                'handler' => $stack,
            ]
        );
    }
    
    public function send($request)
    {
        $client = $GLOBALS['pcoClient'];
        try {
            $res = $client->sendAsync($request)->wait();
        } catch (ClientException $e) {
            return $e->getResponse()->getBody();
        }
        return $res->getBody();
    }
}

