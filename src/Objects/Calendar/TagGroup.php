<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes\TagGroupAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;

class TagGroup
{
    use HasPlanningCenterClient;

    public const string TAG_GROUP_ENDPOINT = "/calendar/v2/tag_groups";

    public TagGroupAttributes $attributes;

    public static function make(string $clientId, string $clientSecret): TagGroup
    {
        $tagGroup = new self($clientId, $clientSecret);
        $tagGroup->attributes = new TagGroupAttributes;
        $tagGroup->setApiVersion(PlanningCenterApiVersion::CALENDAR_DEFAULT);

        return $tagGroup;
    }

    public function all(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::TAG_GROUP_ENDPOINT, $query);

        return $this->processResponse($http);
    }

    public function tags(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::TAG_GROUP_ENDPOINT . "/" . $this->attributes->tagGroupId . "/tags", $query);

        return $this->processResponse($http);
    }

    private function mapFromPco(mixed $pco): void
    {
        $pco = pco_objectify($pco);

        if (is_null($pco)) {
            return;
        }

        $this->attributes->tagGroupId = $pco->id;

        $attributeMap = [
            "createdAt" => "created_at",
            "name" => "name",
            "updatedAt" => "updated_at",
            "required" => "required",
        ];

        AttributeMapper::from($pco, $this->attributes, $attributeMap, ["created_at", "updated_at"]);
    }
}
