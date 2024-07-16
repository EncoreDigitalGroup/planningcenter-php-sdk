<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People\PersonMerger;

use EncoreDigitalGroup\PlanningCenter\Configuration\AuthorizationOptions;
use EncoreDigitalGroup\PlanningCenter\Configuration\ClientConfiguration;
use EncoreDigitalGroup\PlanningCenter\PlanningCenterClient;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use PHPGenesis\Common\Container\PhpGenesisContainer;
use PHPGenesis\Http\HttpClient;

class PersonMerger
{
    use HasPlanningCenterClient;

    public string $id;
    public PersonMergerAttributes $attributes;
    public PersonMergerRelationships $relationships;
    protected AuthorizationOptions $auth;

    public function __construct(?PlanningCenterClient $client = null)
    {
        $this->client = $client ?? new PlanningCenterClient();
        $this->attributes = new PersonMergerAttributes();
        $this->auth = PhpGenesisContainer::getInstance()->get(ClientConfiguration::class)->authorization();
    }

    public function get(?array $query = []): static
    {
        $http = HttpClient::withBasicAuth($this->auth->getClientId(), $this->auth->getClientSecret())
            ->get('people/v2/person_mergers/' . $this->id, $query);

        $this->mapFromPco($http->json('data'));

        return $this;

    }

    protected function mapFromPco(mixed $payload): static
    {
        $payload = objectify($payload);

        $this->id = $payload->id; //@phpstan-ignore-line

        $this->attributes = new PersonMergerAttributes();
        $this->attributes->createdAt = $payload->attributes->created_at; //@phpstan-ignore-line
        $this->attributes->personToKeepId = $payload->attributes->person_to_keep_id; //@phpstan-ignore-line
        $this->attributes->personToRemoveId = $payload->attributes->person_to_remove_id; //@phpstan-ignore-line

        $this->relationships = new PersonMergerRelationships();

        $this->relationships->personToKeep = new PersonMergerData();
        $this->relationships->personToKeep->type = $payload->relationships->person_to_keep->data->type; //@phpstan-ignore-line
        $this->relationships->personToKeep->id = $payload->relationships->person_to_keep->data->id; //@phpstan-ignore-line

        $this->relationships->personToRemove = new PersonMergerData();
        $this->relationships->personToRemove->type = $payload->relationships->person_to_remove->data->type; //@phpstan-ignore-line
        $this->relationships->personToRemove->id = $payload->relationships->person_to_remove->data->id; //@phpstan-ignore-line

        return $this;
    }
}
