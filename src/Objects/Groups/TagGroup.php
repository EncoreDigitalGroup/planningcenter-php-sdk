<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\TagGroupAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;

/** @api */
class TagGroup
{
    use HasPlanningCenterClient;

    public const string TAG_GROUP_ENDPOINT = "/groups/v2/tag_groups";

    public TagGroupAttributes $attributes;

    public static function make(string $clientId, string $clientSecret): TagGroup
    {
        $tagGroup = new self($clientId, $clientSecret);
        $tagGroup->attributes = new TagGroupAttributes;
        $tagGroup->setApiVersion(PlanningCenterApiVersion::GROUPS_DEFAULT);

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
            ->tagGroup($query);
    }

    protected function mapFromPco(ClientResponse $clientResponse): void
    {
        $records = objectify($clientResponse->meta->response->json("data", []));

        if (!is_iterable($records)) {
            return;
        }

        foreach ($records as $record) {
            $this->attributes->tagGroupId = $record->id;
            $attributeMap = [
                "tagGroupId" => "id",
                "displayPublicly" => "display_publicly",
                "multipleOptionsEnabled" => "multiple_options_enabled",
                "name" => "name",
                "position" => "position",
            ];

            AttributeMapper::from($record, $this->attributes, $attributeMap);
            $clientResponse->data->add($this);
        }
    }
}