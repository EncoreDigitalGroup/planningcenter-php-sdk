<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use EncoreDigitalGroup\PlanningCenter\Objects\People\Attributes\PersonAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\People\Traits\HasEmails;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use Exception;
use Illuminate\Support\Arr;
use PHPGenesis\Common\Support\Objectify;
use TypeError;

/** @api */
class Person
{
    use HasEmails, HasPlanningCenterClient;

    public const string PEOPLE_ENDPOINT = "/people/v2/people";

    public PersonAttributes $attributes;

    public static function make(?string $clientId = null, ?string $clientSecret = null): Person
    {
        $person = new self($clientId, $clientSecret);
        $person->attributes = new PersonAttributes;
        $person->setApiVersion(PlanningCenterApiVersion::PEOPLE_DEFAULT);

        return $person;
    }

    public function forPersonId(string $personId): static
    {
        $this->attributes->personId = $personId;

        return $this;
    }

    public function all(?array $query = null): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::PEOPLE_ENDPOINT, $query);

        return $this->processResponse($http);
    }

    public function get(?array $query = null): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::PEOPLE_ENDPOINT . "/{$this->attributes->personId}", $query);

        return $this->processResponse($http);
    }

    public function create(): ClientResponse
    {
        $http = $this->client()
            ->post($this->hostname() . self::PEOPLE_ENDPOINT, $this->mapToPco());

        return $this->processResponse($http);
    }

    public function update(): ClientResponse
    {
        $http = $this->client()
            ->patch($this->hostname() . self::PEOPLE_ENDPOINT . "/{$this->attributes->personId}", $this->mapToPco());

        return $this->processResponse($http);
    }

    public function delete(): ClientResponse
    {
        $http = $this->client()
            ->delete($this->hostname() . self::PEOPLE_ENDPOINT . "/{$this->attributes->personId}");

        return $this->processResponse($http);
    }

    private function mapFromPco(ClientResponse $clientResponse): void
    {
        try {
            $records = Objectify::make($clientResponse->meta->response->json("data", []));
        } catch (Exception|TypeError) {
            return;
        }

        if (!is_iterable($records)) {
            return;
        }

        foreach ($records as $record) {
            $this->attributes->personId = $record->id;
            $attributeMap = [
                "firstName" => "first_name",
                "middleName" => "middle_name",
                "lastName" => "last_name",
                "birthdate" => "birthdate",
                "anniversary" => "anniversary",
                "gender" => "gender",
                "grade" => "grade",
                "child" => "child",
                "graduationYear" => "graduation_year",
                "siteAdministrator" => "site_administrator",
                "accountingAdministrator" => "accounting_administrator",
                "peoplePermissions" => "people_permissions",
                "membership" => "membership",
                "inactivatedAt" => "inactivated_at",
                "medicalNotes" => "medical_notes",
                "mfaConfigured" => "mfa_configured",
                "createdAt" => "created_at",
                "updatedAt" => "updated_at",
                "avatar" => "avatar",
                "name" => "name",
                "demographicAvatarUrl" => "demographic_avatar_url",
                "directoryStatus" => "directory_status",
                "passedBackgroundCheck" => "passed_background_check",
                "canCreateForms" => "can_create_forms",
                "canEmailLists" => "can_email_lists",
                "schoolType" => "school_type",
                "status" => "status",
                "primaryCampusId" => "primary_campus_id",
                "remoteId" => "remote_id",
            ];

            AttributeMapper::from($record, $this->attributes, $attributeMap, [
                "birthdate",
                "anniversary",
                "created_at",
                "updated_at",
                "inactivated_at",
            ]);
            $clientResponse->data->add($this);
        }

    }

    private function mapToPco(): array
    {
        $person = [
            "data" => [
                "attributes" => [
                    "id" => $this->attributes->personId ?? null,
                    "first_name" => $this->attributes->firstName ?? null,
                    "middle_name" => $this->attributes->middleName ?? null,
                    "last_name" => $this->attributes->lastName ?? null,
                    "birthdate" => $this->attributes->birthdate?->toDateString() ?? null,
                    "anniversary" => $this->attributes->anniversary?->toDateString() ?? null,
                    "gender" => $this->attributes->gender ?? null,
                    "grade" => $this->attributes->grade ?? null,
                    "child" => $this->attributes->child ?? null,
                    "graduation_year" => $this->attributes->graduationYear ?? null,
                    "site_administrator" => $this->attributes->siteAdministrator ?? null,
                    "accounting_administrator" => $this->attributes->accountingAdministrator ?? null,
                    "people_permissions" => $this->attributes->peoplePermissions ?? null,
                    "membership" => $this->attributes->membership ?? null,
                    "inactivated_at" => $this->attributes->inactivatedAt?->toDateTimeString() ?? null,
                    "medical_notes" => $this->attributes->medicalNotes ?? null,
                    "mfa_configured" => $this->attributes->mfaConfigured ?? null,
                    "created_at" => $this->attributes->createdAt?->toDateTimeString() ?? null,
                    "updated_at" => $this->attributes->updatedAt?->toDateTimeString() ?? null,
                    "avatar" => $this->attributes->avatar ?? null,
                    "name" => $this->attributes->name ?? null,
                    "demographic_avatar_url" => $this->attributes->demographicAvatarUrl ?? null,
                    "directory_status" => $this->attributes->directoryStatus ?? null,
                    "passed_background_check" => $this->attributes->passedBackgroundCheck ?? null,
                    "can_create_forms" => $this->attributes->canCreateForms ?? null,
                    "can_email_lists" => $this->attributes->canEmailLists ?? null,
                    "school_type" => $this->attributes->schoolType ?? null,
                    "status" => $this->attributes->status ?? null,
                    "primary_campus_id" => $this->attributes->primaryCampusId ?? null,
                    "remote_id" => $this->attributes->remoteId ?? null,
                ],
            ],
        ];

        unset(
            $person["data"]["attributes"]["id"],
            $person["data"]["attributes"]["created_at"],
            $person["data"]["attributes"]["updated_at"],
            $person["data"]["attributes"]["name"],
            $person["data"]["attributes"]["demographic_avatar_url"]
        );

        $person["data"]["attributes"] = Arr::whereNotNull($person["data"]["attributes"]);

        return $person;
    }
}
