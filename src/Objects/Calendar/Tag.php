<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes\TagAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;

class Tag
{
    use HasPlanningCenterClient;

    public TagAttributes $attributes;
    private string $tagGroupId;

    public static function make(string $clientId, string $clientSecret): Tag
    {
        $tagGroup = new self($clientId, $clientSecret);
        $tagGroup->attributes = new TagAttributes;
        $tagGroup->setApiVersion(PlanningCenterApiVersion::CALENDAR_DEFAULT);

        return $tagGroup;
    }

    public function forTagGroupId(string $tagGroupId): static
    {
        $this->tagGroupId = $tagGroupId;

        return $this;
    }

    public function all(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . TagGroup::TAG_GROUP_ENDPOINT . "/{$this->tagGroupId}/tags", $query);

        return $this->processResponse($http);
    }

    /** @internal */
    public function mapFromPco(ClientResponse $clientResponse): void
    {
        $records = objectify($clientResponse->meta->response->json("data"));

        foreach ($records as $record) {
            $this->attributes->tagId = $record->id;

            $attributeMap = [
                "churchCenterCategory" => "church_center_category",
                "color" => "color",
                "createdAt" => "created_at",
                "name" => "name",
                "position" => "position",
                "updatedAt" => "updated_at",
            ];

            AttributeMapper::from($record, $this->attributes, $attributeMap, ["created_at", "updated_at"]);
            $clientResponse->data->add($this);
        }

    }
}
