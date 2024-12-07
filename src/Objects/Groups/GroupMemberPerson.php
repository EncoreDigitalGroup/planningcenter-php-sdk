<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\GroupMemberPersonAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;

/**
 * @internal
 *
 * @api
 */
class GroupMemberPerson
{
    use HasPlanningCenterClient;

    public GroupMemberPersonAttributes $attributes;
    private string $groupId;

    public static function make(string $clientId, string $clientSecret): GroupMemberPerson
    {
        $group = new self($clientId, $clientSecret);
        $group->attributes = new GroupMemberPersonAttributes;
        $group->setApiVersion(PlanningCenterApiVersion::GROUPS_DEFAULT);

        return $group;
    }

    public function forGroupId(string $groupId): static
    {
        $this->groupId = $groupId;

        return $this;
    }

    public function get(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . Group::GROUPS_ENDPOINT . "/{$this->groupId}/people", $query);

        return $this->processResponse($http);
    }

    protected function mapFromPco(ClientResponse $clientResponse): void
    {
        $records = objectify($clientResponse->meta->response->json("data", []));

        if (!is_iterable($records)) {
            return;
        }

        foreach ($records as $record) {
            $this->attributes->personId = $record->id;
            $attributeMap = [
                "child" => "child",
                "firstName" => "first_name",
                "lastName" => "last_name",
            ];

            AttributeMapper::from($record, $this->attributes, $attributeMap);
            $clientResponse->data->add($this);
        }

    }
}