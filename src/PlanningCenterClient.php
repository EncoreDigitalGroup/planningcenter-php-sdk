<?php

namespace EncoreDigitalGroup\PlanningCenter;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;

class PlanningCenterClient
{
    protected ClientConfiguration $config;
    protected GuzzleClient $client;

    public function __construct($config)
    {
        $this->config = $this->setConfiguration($config);
        $this->createClient();
    }

    public function setConfiguration(ClientConfiguration $config): ClientConfiguration
    {
        $this->config = $config;

        return $this->config;
    }

    public function getConfiguration(): ClientConfiguration
    {
        return $this->config;
    }

    public function createClient(): void
    {
        $handler = new CurlHandler;
        $stack = HandlerStack::create($handler);
        $this->client = new GuzzleClient([
            'base_uri' => 'https://api.planningcenteronline.com',
            'handler' => $stack,
        ]);
    }

    public function getClient(): GuzzleClient
    {
        return $this->client;
    }

    public function send($request, $query = [], $retry_limit = 5, $retry = 0): bool|string
    {
        $client = $this->getClient();
        try {
            $res = $client->sendAsync($request)->wait();
        } catch (ClientException $e) {
            if ($retry <= $retry_limit) {
                $i = $retry + 1;
                $GLOBALS['pcoRetryCount'] = $i - 1;

                return $this->send($request, $query, $retry_limit, $i);
            }

            return json_decode($this->processResponse($e->getResponse()));
        }

        return json_decode($this->processResponse($res));

    }

    protected function processResponse($res): string
    {
        $response_body = $res->getBody()->getContents();
        $http_response_code = $res->getStatusCode();
        $http_message = $res->getReasonPhrase();
        $success = false;
        $rate_limited = false;

        if ($http_response_code >= 200 && $http_response_code < 300) {
            $success = true;
        }

        if ($http_response_code == 429) {
            $rate_limited = true;
        }

        $response = [
            'sdk' => [
                'outcome' => [
                    'success' => $success ?? false,
                    'rate_limited' => $rate_limited ?? false,
                    'http' => [
                        'status_code' => $http_response_code ?? null,
                        'message' => $http_message ?? null,
                        'pco' => $response_body,
                        'retry_count' => $GLOBALS['pcoRetryCount'] ?? 0,
                    ],
                ],
            ],
        ];

        if ($success) {
            $response_body = json_decode($response_body);
            $response['pco'] = $response_body;
            $response['sdk']['page']['previous'] = $response_body->meta->prev->offset ?? null;
            $response['sdk']['page']['next'] = $response_body->meta->next->offset ?? null;
        }

        return json_encode($response);
    }
}
