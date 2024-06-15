<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People\PersonMerger;

use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use EncoreDigitalGroup\SdkClientFoundation\SdkObjects\ClientResponse;
use GuzzleHttp\Psr7\Request;

class PersonMerger
{
    use HasPlanningCenterClient;

    public string $id;
    public PersonMergerAttributes $attributes;
    public PersonMergerRelationships $relationships;

    public function get(): static
    {
        $headers = $this->buildHeaders();

        $request = new Request('GET', 'people/v2/people/' . $this->id, $headers);

        $response = $this->client->send($request);

        return $this->map($response);
    }

    protected function map(ClientResponse $payload): static
    {
        $payload = $payload->service;

        $this->id = $payload->id;

        $this->attributes = new PersonMergerAttributes();
        $this->attributes->createdAt = $payload->attributes->created_at;
        $this->attributes->personToKeepId = $payload->attributes->person_to_keep_id;
        $this->attributes->personToRemoveId = $payload->attributes->person_to_remove_id;

        $this->relationships = new PersonMergerRelationships();

        $this->relationships->personToKeep = new PersonMergerData();
        $this->relationships->personToKeep->type = $payload->relationships->person_to_keep->type;
        $this->relationships->personToKeep->id = $payload->relationships->person_to_keep->id;

        $this->relationships->personToRemove = new PersonMergerData();
        $this->relationships->personToRemove->type = $payload->relationships->person_to_remove->type;
        $this->relationships->personToRemove->id = $payload->relationships->person_to_remove->id;

        return $this;
    }
}