<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People\PersonMerger;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships\BasicRelationshipData;
use EncoreDigitalGroup\PlanningCenter\Support\AuthorizationOptions;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use Illuminate\Support\Carbon;

class PersonMerger
{
    use HasPlanningCenterClient;

    public const string PERSON_MERGER_ENDPOINT = '/people/v2/person_mergers';

    public PersonMergerAttributes $attributes;
    public PersonMergerRelationships $relationships;

    public static function make(string $clientId, string $clientSecret): PersonMerger
    {
        $personMerger = new self($clientId, $clientSecret);
        $personMerger->attributes = new PersonMergerAttributes();
        $personMerger->relationships = new PersonMergerRelationships();

        return $personMerger;
    }

    public function get(?array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::PERSON_MERGER_ENDPOINT . '/' . $this->id, $query);

        return $this->processResponse($http);
    }

    protected function mapFromPco(mixed $payload): static
    {
        $payload = objectify($payload);

        $this->attributes = new PersonMergerAttributes();
        $this->attributes->personMergerId = $payload->id; //@phpstan-ignore-line
        $this->attributes->createdAt = Carbon::createFromFormat('c', $payload->attributes->created_at); //@phpstan-ignore-line
        $this->attributes->personToKeepId = $payload->attributes->person_to_keep_id; //@phpstan-ignore-line
        $this->attributes->personToRemoveId = $payload->attributes->person_to_remove_id; //@phpstan-ignore-line

        $this->relationships = new PersonMergerRelationships();

        $this->relationships->personToKeep = new BasicRelationshipData();
        $this->relationships->personToKeep->type = $payload->relationships->person_to_keep->data->type; //@phpstan-ignore-line
        $this->relationships->personToKeep->id = $payload->relationships->person_to_keep->data->id; //@phpstan-ignore-line

        $this->relationships->personToRemove = new BasicRelationshipData();
        $this->relationships->personToRemove->type = $payload->relationships->person_to_remove->data->type; //@phpstan-ignore-line
        $this->relationships->personToRemove->id = $payload->relationships->person_to_remove->data->id; //@phpstan-ignore-line

        return $this;
    }
}
