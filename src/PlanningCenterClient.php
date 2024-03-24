<?php

namespace EncoreDigitalGroup\PlanningCenter;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;

class PlanningCenterClient
{
    protected ClientConfiguration $config;
    protected GuzzleClient $client;
    protected int $attempts;

    public function __construct(mixed $config)
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

    public function send(Request $request, array $query = [], int $attemptLimit = 5, int $attempt = 1): ClientResponse
    {
        $this->attempts = $attempt;
        $client = $this->getClient();

        try {
            $res = $client->sendAsync($request)->wait();
        } catch (ClientException $e) {
            if ($attempt <= $attemptLimit) {
                $i = $attempt + 1;

                return $this->send($request, $query, $attemptLimit, $i);
            }

            return $this->processResponse($e->getResponse());
        }

        return $this->processResponse($res);

    }

    protected function processResponse(mixed $res): ClientResponse
    {
        $responseBody = $res->getBody()->getContents();
        $httpStatusCode = $res->getStatusCode();
        $httpMessage = $res->getReasonPhrase();

        if ($httpStatusCode >= 200 && $httpStatusCode < 300) {
            $success = true;
        }

        if ($httpStatusCode == 429) {
            $rateLimited = true;
        }

        $response = new ClientResponse;
        $response->sdk->outcome->success = $success ?? false;
        $response->sdk->outcome->rateLimited = $rateLimited ?? false;
        $response->sdk->outcome->http->statusCode = $httpStatusCode ?? null;
        $response->sdk->outcome->http->message = $httpMessage ?? null;
        $response->sdk->outcome->http->pco = $responseBody;
        $response->sdk->outcome->http->attempts = $this->attempts ?? 1;

        if ($success ?? false) {
            $responseBody = json_decode($responseBody);
            $response->pco = $responseBody;
            $response->sdk->page->previous = $responseBody->meta->prev->offset ?? null;
            $response->sdk->page->next = $responseBody->meta->next->offset ?? null;
        }

        return $response;
    }
}
