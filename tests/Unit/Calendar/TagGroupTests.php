<?php

namespace Tests\Unit\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes\TagGroupAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\TagGroup;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe('TagGroup Tests', function () {
    test('TagGroup: Can List All TagGroups', function () {
        $tagGroup = TagGroup::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $tagGroup->all();

        /** @var TagGroupAttributes $tagGroupAttributes */
        $tagGroupAttributes = $response->data->first()->attributes;

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1)
            ->and($tagGroupAttributes->tagGroupId)->toBe(CalendarMocks::TAG_GROUP_ID);
    });

    test('TagGroup: Can List All Tags For A Specific TagGroup', function () {
        $tagGroup = TagGroup::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $tagGroup->attributes->tagGroupId = "1";

        $response = $tagGroup->tags();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    })->todo("Create Tag Relationship Object", "onairmarc");
})->group('calendar.tagGroup');