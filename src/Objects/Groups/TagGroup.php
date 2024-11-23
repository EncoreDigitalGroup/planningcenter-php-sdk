<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\TagGroupAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;

/** @api */
class TagGroup
{
    use HasPlanningCenterClient;

    public const string TAG_GROUP_ENDPOINT = '/groups/v2/tag_groups';

    public TagGroupAttributes $attributes;

    public static function make(string $clientId, string $clientSecret): TagGroup
    {
        $tagGroup = new self($clientId, $clientSecret);
        $tagGroup->attributes = new TagGroupAttributes;
        $tagGroup->setApiVersion(PlanningCenterApiVersion::GROUPS_DEFAULT);

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
            ->get($this->hostname() . self::TAG_GROUP_ENDPOINT . '/' . $this->attributes->tagGroupId . '/tags', $query);

        return $this->processResponse($http);
    }

    protected function mapFromPco(array $pco): void
    {
        $pco = objectify($pco);

        $this->attributes->tagGroupId = $pco->id;
        $this->attributes->displayPublicly = $pco->attributes->display_publicly;
        $this->attributes->multipleOptionsEnabled = $pco->attributes->multiple_options_enabled;
        $this->attributes->name = $pco->attributes->name;
        $this->attributes->position = $pco->attributes->position;
    }
}
