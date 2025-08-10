<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People\PersonMerger;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships\BasicRelationshipData;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use PHPGenesis\Common\Support\Objectify;

class PersonMerger
{
    use HasPlanningCenterClient;

    public const string PERSON_MERGER_ENDPOINT = "/people/v2/person_mergers";

    public PersonMergerAttributes $attributes;
    public PersonMergerRelationships $relationships;

    public static function make(string $clientId, string $clientSecret): PersonMerger
    {
        $personMerger = new self($clientId, $clientSecret);
        $personMerger->attributes = new PersonMergerAttributes;
        $personMerger->relationships = new PersonMergerRelationships;

        return $personMerger;
    }

    public function forPersonId(string $personId): static
    {
        $this->attributes->personMergerId = $personId;

        return $this;
    }

    public function get(?array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::PERSON_MERGER_ENDPOINT . "/{$this->attributes->personMergerId}", $query);

        return $this->processResponse($http);
    }

    protected function mapFromPco(mixed $payload): static
    {
        $payload = Objectify::make($payload);

        $attributeMap = [
            "personMergerId" => "id",
            "createdAt" => "created_at",
            "personToKeepId" => "person_to_keep_id",
            "personToRemoveId" => "person_to_remove_id",
        ];

        $this->attributes = new PersonMergerAttributes;
        AttributeMapper::from($payload, $this->attributes, $attributeMap);

        $this->relationships = new PersonMergerRelationships;

        $personToAttributeMap = [
            "type" => "type",
            "id" => "id",
        ];

        $this->relationships->personToKeep = new BasicRelationshipData;
        AttributeMapper::from($payload, $this->relationships->personToKeep, $personToAttributeMap);

        $this->relationships->personToRemove = new BasicRelationshipData;
        AttributeMapper::from($payload, $this->relationships->personToRemove, $personToAttributeMap);

        return $this;
    }
}
