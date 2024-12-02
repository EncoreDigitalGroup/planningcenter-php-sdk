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

    public function forTagGroupId(string $tagGroupId): static
    {
        $this->attributes->tagGroupId = $tagGroupId;

        return $this;
    }

    public function all(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::TAG_GROUP_ENDPOINT, $query);

        return $this->processResponse($http);
    }

    public function tags(array $query = []): ClientResponse
    {
        return Tag::make($this->clientId, $this->clientSecret)
            ->forTagGroupId($this->attributes->tagGroupId)
            ->all($query);
    }

    private function mapFromPco(ClientResponse $clientResponse): void
    {
        $records = objectify($clientResponse->meta->response->json("data"));

        foreach ($records as $record) {
            $this->attributes->tagGroupId = $record->id;
            $attributeMap = [
                "createdAt" => "created_at",
                "name" => "name",
                "updatedAt" => "updated_at",
                "required" => "required",
            ];

            AttributeMapper::from($record, $this->attributes, $attributeMap, ["created_at", "updated_at"]);
            $clientResponse->data->add($this);
        }
    }
}
