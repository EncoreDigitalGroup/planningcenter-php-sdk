<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use EncoreDigitalGroup\PlanningCenter\Configuration\AuthorizationOptions;
use EncoreDigitalGroup\PlanningCenter\Configuration\ClientConfiguration;
use EncoreDigitalGroup\PlanningCenter\Objects\People\Attributes\EmailAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\PlanningCenterClient;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use Illuminate\Support\Arr;
use PHPGenesis\Common\Container\PhpGenesisContainer;
use PHPGenesis\Http\HttpClient;
use stdClass;

class Email
{
    use HasPlanningCenterClient;

    public int|string|null $id;
    public EmailAttributes $attributes;
    protected AuthorizationOptions $auth;

    public function __construct(?PlanningCenterClient $client = null)
    {
        $this->client = $client ?? new PlanningCenterClient();
        $this->attributes = new EmailAttributes();
        $this->auth = PhpGenesisContainer::getInstance()->get(ClientConfiguration::class)->authorization();
    }

    public function get(): ClientResponse
    {
        $http = HttpClient::withBasicAuth($this->auth->getClientId(), $this->auth->getClientSecret())
            ->get($this->client->getBaseUrl() . '/people/v2/emails/' . $this->id);

        $clientResponse = new ClientResponse($http);
        $this->mapFromPco($http->json('data'));
        $clientResponse->data = $this->attributes;

        return $clientResponse;

    }

    public function forPerson(): ClientResponse
    {
        $http = HttpClient::withBasicAuth($this->auth->getClientId(), $this->auth->getClientSecret())
            ->get($this->client->getBaseUrl() . '/people/v2/people/' . $this->attributes->personId . '/emails');

        $clientResponse = new ClientResponse($http);
        $clientResponse->data = [];

        foreach ($http->json('data') as $email) {
            $e = new Email($this->client);
            $e->mapFromPco($email);
            $clientResponse->data[] = $e;
        }

        return $clientResponse;
    }

    public function update(): ClientResponse
    {
        $http = HttpClient::withBasicAuth($this->auth->getClientId(), $this->auth->getClientSecret())
            ->patch($this->client->getBaseUrl() . '/people/v2/emails/' . $this->id, $this->mapToPco());

        $clientResponse = new ClientResponse($http);
        $this->mapFromPco($http->json('data'));
        $clientResponse->data = $this->attributes;

        return $clientResponse;
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
