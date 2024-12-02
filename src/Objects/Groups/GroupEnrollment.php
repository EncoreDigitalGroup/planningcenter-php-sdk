<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\GroupEnrollmentAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;

/**
 * @internal
 *
 * @api
 */
class GroupEnrollment
{
    use HasPlanningCenterClient;

    public GroupEnrollmentAttributes $attributes;

    public static function make(string $clientId, string $clientSecret): GroupEnrollment
    {
        $group = new self($clientId, $clientSecret);
        $group->attributes = new GroupEnrollmentAttributes;
        $group->setApiVersion(PlanningCenterApiVersion::GROUPS_DEFAULT);

        return $group;
    }

    public function forGroupId(string $groupId): static
    {
        $this->attributes->groupId = $groupId;

        return $this;
    }

    public function get(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . Group::GROUPS_ENDPOINT . "/{$this->attributes->groupId}/enrollment", $query);

        return $this->processResponse($http);
    }

    protected function mapFromPco(ClientResponse $clientResponse): void
    {
        $records = objectify($clientResponse->meta->response->json("data"));

        foreach ($records as $record) {
            $this->attributes->groupId = $record->id;
            $attributeMap = [
                "autoClosed" => "auto_closed",
                "autoClosedReason" => "auto_closed_reason",
                "dateLimit" => "date_limit",
                "dateLimitReached" => "date_limit_reached",
                "memberLimit" => "member_limit",
                "memberLimitReached" => "member_limit_reached",
                "status" => "status",
                "strategy" => "strategy",
            ];

            AttributeMapper::from($record, $this->attributes, $attributeMap, ["date_limit"]);
            $clientResponse->data->add($this);
        }

    }
}