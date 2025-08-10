<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\TagAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use PHPGenesis\Common\Support\Objectify;

/** @api */
class Tag
{
    use HasPlanningCenterClient;

    public const string TAGS_ENDPOINT = "/groups/v2/tags";

    public TagAttributes $attributes;
    private string $groupId;
    private string $tagGroupId;

    public static function make(string $clientId, string $clientSecret): Tag
    {
        $tag = new self($clientId, $clientSecret);
        $tag->attributes = new TagAttributes;
        $tag->setApiVersion(PlanningCenterApiVersion::GROUPS_DEFAULT);

        return $tag;
    }

    public function forGroupId(string $groupId): static
    {
        $this->groupId = $groupId;

        return $this;
    }

    public function forTagGroupId(string $tagGroupId): static
    {
        $this->tagGroupId = $tagGroupId;

        return $this;
    }

    public function get(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::TAGS_ENDPOINT . "/" . $this->attributes->tagId, $query);

        return $this->processResponse($http);
    }

    public function groups(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . Group::GROUPS_ENDPOINT . "/{$this->groupId}/tags", $query);

        return $this->processResponse($http);
    }

    public function tagGroup(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . TagGroup::TAG_GROUP_ENDPOINT . "/{$this->tagGroupId}/tags", $query);

        return $this->processResponse($http);
    }

    protected function mapFromPco(ClientResponse $clientResponse): void
    {
        $records = Objectify::make($clientResponse->meta->response->json("data", []));

        if (!is_iterable($records)) {
            return;
        }

        foreach ($records as $record) {
            $this->attributes->tagId = $record->id;
            $attributeMap = [
                "name" => "name",
                "position" => "position",
            ];

            AttributeMapper::from($record, $this->attributes, $attributeMap);
            $clientResponse->data->add($this);
        }
    }
}