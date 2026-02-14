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
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Arr;
use PHPGenesis\Common\Support\Objectify;

/** @api */
class Email
{
    use HasClient;

    public const string EMAIL_ENDPOINT = "/people/v2/emails";

    public EmailAttributes $attributes;

    public static function make(?string $clientId = null, ?string $clientSecret = null): Email
    {
        $email = new self($clientId, $clientSecret);
        $email->attributes = new EmailAttributes;
        $email->setApiVersion(PlanningCenterApiVersion::PEOPLE_DEFAULT);

        return $email;
    }

    public function forEmailAddressId(string $emailAddressId): static
    {
        $this->attributes->emailAddressId = $emailAddressId;

        return $this;
    }

    public function forPersonId(string $personId): static
    {
        $this->attributes->personId = $personId;

        return $this;
    }

    public function get(): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::EMAIL_ENDPOINT . "/" . $this->attributes->emailAddressId);

        return $this->processResponse($http);
    }

    public function person(): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . Person::PEOPLE_ENDPOINT . "/{$this->attributes->personId}/emails");

        return $this->processResponse($http);
    }

    public function update(): ClientResponse
    {
        $http = $this->client()
            ->patch($this->hostname() . self::EMAIL_ENDPOINT . "/{$this->attributes->emailAddressId}", $this->mapToPco());

        return $this->processResponse($http);
    }

    private function mapFromPco(ClientResponse $clientResponse): void
    {
        $records = Objectify::make($clientResponse->meta->response->json("data", []));

        if (!is_iterable($records)) {
            return;
        }

        foreach ($records as $record) {
            $this->attributes->emailAddressId = $record->id;
            $attributeMap = [
                "emailAddressId" => "id",
                "address" => "address",
                "primary" => "primary",
            ];

            AttributeMapper::from($record, $this->attributes, $attributeMap);
            $clientResponse->data->add($this);
        }

    }

    private function mapToPco(): array
    {
        $email = [
            "data" => [
                "attributes" => [
                    "address" => $this->attributes->address,
                    "primary" => $this->attributes->primary,
                ],
            ],
        ];

        return Arr::whereNotNull($email);
    }
}
