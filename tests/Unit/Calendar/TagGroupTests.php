<?php

namespace Tests\Unit\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes\TagAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes\TagGroupAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\TagGroup;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("TagGroup Tests", function (): void {
    test("TagGroup: Can List All TagGroups", function (): void {
        $tagGroup = TagGroup::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $tagGroup->all();

        /** @var TagGroupAttributes $tagGroupAttributes */
        $tagGroupAttributes = $response->data->first()->attributes;

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1)
            ->and($tagGroupAttributes->tagGroupId)->toBe(CalendarMocks::TAG_GROUP_ID);
    });

    test("TagGroup: Can List All Tags For A Specific TagGroup", function (): void {
        $tagGroup = TagGroup::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $tagGroup
            ->forTagGroupId("1")
            ->tags();

        /** @var TagAttributes $tagAttributes */
        $tagAttributes = $response->data->first()->attributes;

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1)
            ->and($tagAttributes->tagId)->toBe(CalendarMocks::TAG_ID)
            ->and($tagAttributes->name)->toBe(CalendarMocks::TAG_NAME);
    });
})->group("calendar.tagGroup");