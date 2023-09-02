<?php

namespace EncoreDigitalGroup\PlanningCenter;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;

class Client
{
    public $config;

    public function configure($config = [])
    {
        $handler = new CurlHandler;
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

    public function send($request, $query = [], $retry_limit = 5, $retry = 0)
    {
        $client = $GLOBALS['pcoClient'];
        try {
            $res = $client->sendAsync($request)->wait();
        } catch (ClientException $e) {
            if ($retry <= $retry_limit)
            {
                $i = $retry + 1;
                $GLOBALS['pcoRetryCount'] = $i - 1;
                return $this->send($request, $query, $retry_limit, $i);
            }
            return json_encode($this->processResponse($e->getResponse()));
        }

        return json_encode($this->processResponse($res));

    }
    protected function processResponse($res): array
    {
        $response_body = $res->getBody()->getContents();
        $http_response_code = $res->getStatusCode();
        $http_message = $res->getReasonPhrase();
        $success = false;
        if ($http_response_code >= 200 && $http_response_code < 300) {
            $success = true;
        }

        $response = [
            'sdk' => [
                'outcome' => [
                    'success' => $success ?? false,
                    'http' => [
                        'status_code' => $http_response_code ?? null,
                        'message' => $http_message ?? null,
                        'retry_count' => $GLOBALS['pcoRetryCount'] ?? 0,
                    ],
                ],
            ]
        ];

        if ($success) {
            $response_body = json_decode($response_body);
            $response['pco'] = $response_body;
            $response['sdk']['page']['previous'] = $response_body->meta->prev->offset ?? null;
            $response['sdk']['page']['next'] = $response_body->meta->next->offset ?? null;
        }

        return $response;
    }

    
}
