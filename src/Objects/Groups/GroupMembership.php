<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\GroupMembershipAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Relationships\GroupMembershipRelationships;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\RelationshipMapper;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;

/**
 * @internal
 *
 * @api
 */
class GroupMembership
{
    use HasPlanningCenterClient;

    public GroupMembershipAttributes $attributes;
    public GroupMembershipRelationships $relationships;
    private string $groupId;

    public static function make(string $clientId, string $clientSecret): GroupMembership
    {
        $group = new self($clientId, $clientSecret);
        $group->attributes = new GroupMembershipAttributes;
        $group->relationships = new GroupMembershipRelationships;
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
            ->get($this->hostname() . Group::GROUPS_ENDPOINT . "/{$this->groupId}/memberships", $query);

        return $this->processResponse($http);
    }

    protected function mapFromPco(ClientResponse $clientResponse): void
    {
        $records = objectify($clientResponse->meta->response->json("data"));

        foreach ($records as $record) {
            $attributeMap = [
                "joinedAt" => "joined_at",
                "role" => "role",
            ];

            $relationshipMap = [
                "group" => "group",
                "person" => "person",
            ];

            AttributeMapper::from($record, $this->attributes, $attributeMap, ["joined_at"]);
            RelationshipMapper::from($record, $this->relationships, $relationshipMap);
            $clientResponse->data->add($this);
        }
    }
}