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

/** @api */
class Tag
{
    use HasPlanningCenterClient;

    public const string TAGS_ENDPOINT = "/groups/v2/tags";

    public TagAttributes $attributes;
    private string $groupId;

    public static function make(string $clientId, string $clientSecret): Tag
    {
        $tag = new self($clientId, $clientSecret);
        $tag->attributes = new TagAttributes;
        $tag->setApiVersion(PlanningCenterApiVersion::GROUPS_DEFAULT);

        return $tag;
    }

    public function forGroup(string $groupId): static
    {
        $this->groupId = $groupId;

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

    protected function mapFromPco(mixed $pco): void
    {
        $pco = pco_objectify($pco);

        if (is_null($pco)) {
            return;
        }

        $this->attributes->tagId = $pco->id;

        $attributeMap = [
            "name" => "name",
            "position" => "position",
        ];

        AttributeMapper::from($pco, $this->attributes, $attributeMap);
    }
}
