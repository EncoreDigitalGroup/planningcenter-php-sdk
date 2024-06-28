<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use DateTime;
use EncoreDigitalGroup\PlanningCenter\Objects\People\Attributes\EmailAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\PlanningCenterClient;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use PHPGenesis\Http\HttpClient;
use stdClass;

class Email
{
    use HasPlanningCenterClient;

    public int|string|null $id;
    public EmailAttributes $attributes;

    public function __construct(?PlanningCenterClient $client = null)
    {
        $this->client = $client ?? new PlanningCenterClient;
        $this->attributes = new EmailAttributes;
    }

    public function get(): ClientResponse
    {
        $http = HttpClient::baseUrl($this->baseUrl)
            ->get('people/v2/emails/' . $this->id);

        $response = new ClientResponse($http);
        $this->mapFromPco($http->json('data'));
        $response->data = $this->attributes;

        return $response;

    }

    public function forPerson(): ClientResponse
    {
        $http = HttpClient::baseUrl($this->baseUrl)
            ->get('people/v2/people/' . $this->attributes->personId . '/emails');

        $response = new ClientResponse($http);
        $response->data = [];

        foreach ($http->json('data') as $email) {
            $e = new Email($this->client);
            $e->mapFromPco($email);
            $response->data[] = $e;
        }

        return $response;
    }

    public function update(): ClientResponse
    {
        $http = HttpClient::baseUrl($this->baseUrl)
            ->patch('people/v2/emails/' . $this->id, $this->mapToPco());

        $response = new ClientResponse($http);
        $this->mapFromPco($http->json('data'));
        $response->data = $this->attributes;

        return $response;
    }

    private function mapFromPco(stdClass $pco): void
    {
        $this->id = $pco->id;
        $this->attributes->emailAddressId = $pco->id;
        $this->attributes->address = $pco->attributes->address;
        $this->attributes->primary = $pco->attributes->primary;
    }

    private function mapToPco(): array
    {
        $email = [
            'data' => [
                'attributes' => [
                    'address' => $this->attributes->address,
                    'primary' => $this->attributes->primary,
                ],
            ],
        ];

        return Arr::whereNotNull($email);
    }
}
