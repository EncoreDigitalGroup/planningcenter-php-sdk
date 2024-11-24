<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use EncoreDigitalGroup\PlanningCenter\Objects\People\Attributes\EmailAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use Illuminate\Support\Arr;
use stdClass;

/** @api */
class Email
{
    use HasPlanningCenterClient;

    public const string EMAIL_ENDPOINT = '/people/v2/emails';

    public EmailAttributes $attributes;

    public static function make(?string $clientId = null, ?string $clientSecret = null): Email
    {
        $email = new self($clientId, $clientSecret);
        $email->attributes = new EmailAttributes;
        $email->setApiVersion(PlanningCenterApiVersion::PEOPLE_DEFAULT);

        return $email;
    }

    public function get(): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::EMAIL_ENDPOINT . '/' . $this->attributes->emailAddressId);

        return $this->processResponse($http);

    }

    public function forPerson(): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . Person::PEOPLE_ENDPOINT . '/' . $this->attributes->personId . '/emails');

        $clientResponse = new ClientResponse($http);

        foreach ($http->json('data') as $email) {
            $pcoEmail = new Email($this->clientId, $this->clientSecret);
            $pcoEmail->mapFromPco($email);
            $clientResponse->data->push($pcoEmail);
        }

        return $clientResponse;
    }

    public function update(): ClientResponse
    {
        $http = $this->client()
            ->patch($this->hostname() . self::EMAIL_ENDPOINT . '/' . $this->attributes->emailAddressId, $this->mapToPco());

        return $this->processResponse($http);
    }

    private function mapFromPco(mixed $pco): void
    {
        $pco = pco_objectify($pco);

        if (is_null($pco)) {
            return;
        }

        $attributeMap = [
            'emailAddressId' => 'id',
            'address' => 'address',
            'primary' => 'primary',
        ];

        AttributeMapper::from($pco, $this->attributes, $attributeMap);
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
