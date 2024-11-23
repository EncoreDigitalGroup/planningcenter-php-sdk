<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes\TagGroupAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;

/**
 * Class TagGroup
 *
 * @property int $tagGroupId
 * @property int $tagId
 * @api
 */
class TagGroup
{
    use HasPlanningCenterClient;

    public const string TAG_GROUP_ENDPOINT = '/calendar/v2/tag_groups';

    public TagGroupAttributes $attributes;

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

    private function mapFromPco(mixed $pco): void
    {
        $attributeMap = [
            'tagGroupId' => 'id',
            'createAt' => 'create_at',
            'name' => 'name',
            'updateAt' => 'updated_at',
            'required' => 'required',
        ];

        AttributeMapper::from($pco, $this->attributes, $attributeMap, ['created_at', 'updated_at']);
    }
}
