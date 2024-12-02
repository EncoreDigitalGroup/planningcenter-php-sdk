<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\GroupAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\GroupEnrollmentAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;

/** @api */
class Group
{
    use HasPlanningCenterClient;

    public const string GROUPS_ENDPOINT = "/groups/v2/groups";

    public GroupAttributes $attributes;

    public static function make(string $clientId, string $clientSecret): Group
    {
        $group = new self($clientId, $clientSecret);
        $group->attributes = new GroupAttributes;
        $group->setApiVersion(PlanningCenterApiVersion::GROUPS_DEFAULT);

        return $group;
    }

    public function forGroupId(string $groupId): static
    {
        $this->attributes->groupId = $groupId;

        return $this;
    }

    public function all(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::GROUPS_ENDPOINT, $query);

        return $this->processResponse($http);
    }

    public function mine(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::GROUPS_ENDPOINT, array_merge(["filter" => "my_groups"], $query));

        return $this->processResponse($http);
    }

    public function get(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::GROUPS_ENDPOINT . "/" . $this->attributes->groupId, $query);

        return $this->processResponse($http);
    }

    public function enrollment(): ClientResponse
    {
        $enrollment = GroupEnrollment::make($this->clientId, $this->clientSecret);

        if (!isset($enrollment->attributes)) {
            $enrollment->attributes = new GroupEnrollmentAttributes;
        }

        $enrollment->attributes->groupId = $this->attributes->groupId;

        return $enrollment->get();
    }

    public function event(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::GROUPS_ENDPOINT . "/" . $this->attributes->groupId . "/events", $query);

        return $this->processResponse($http);
    }

    public function membership(array $query = []): ClientResponse
    {
        return GroupMembership::make($this->clientId, $this->clientSecret)
            ->forGroupId($this->attributes->groupId)
            ->get($query);
    }

    public function people(array $query = []): ClientResponse
    {
        return GroupMemberPerson::make($this->clientId, $this->clientSecret)
            ->forGroupId($this->attributes->groupId)
            ->get($query);
    }

    public function tags(array $query = []): ClientResponse
    {
        return Tag::make($this->clientId, $this->clientSecret)
            ->forGroupId($this->attributes->groupId)
            ->groups($query);
    }

    protected function mapFromPco(ClientResponse $clientResponse): void
    {
        $records = objectify($clientResponse->meta->response->json("data"));

        if (!is_iterable($records)) {
            return;
        }

        foreach ($records as $record) {
            $this->attributes->groupId = $record->id;
            $attributeMap = [
                "archivedAt" => "archived_at",
                "contactEmail" => "contact_email",
                "createdAt" => "created_at",
                "description" => "description",
                "eventVisibility" => "event_visibility",
                "locationTypePreference" => "location_type_preference",
                "membershipsCount" => "memberships_count",
                "name" => "name",
                "publicChurchCenterUrl" => "public_church_center_url",
                "schedule" => "schedule",
                "virtualLocationUrl" => "virtual_location_url",
            ];

            $headerImageAttributeMap = [
                "thumbnail" => "thumbnail",
                "medium" => "medium",
                "original" => "original",
            ];

            AttributeMapper::from($record, $this->attributes, $attributeMap, ["archived_at", "created_at"]);
            AttributeMapper::from($record->attributes->header_image, $this->attributes->headerImage, $headerImageAttributeMap);
            $clientResponse->data->add($this);
        }

    }
}
