<?php

namespace Tests\Unit\Calendar;

use EncoreDigitalGroup\PlanningCenter\PlanningCenter;
use EncoreDigitalGroup\PlanningCenter\Resources\CalendarTag;
use EncoreDigitalGroup\PlanningCenter\Resources\CalendarTagGroup;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("Calendar TagGroup Tests", function (): void {
    test("CalendarTagGroup: Can List All Tag Groups (Read-Only)", function (): void {
        $paginator = CalendarTagGroup::all(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        expect($paginator)->toBeInstanceOf(Paginator::class)
            ->and($paginator->items())->toBeInstanceOf(Collection::class);
    });

    test("CalendarTagGroup: Can Get Tag Group By ID (Read-Only)", function (): void {
        $tagGroup = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->calendar()
            ->tagGroup()
            ->withId(CalendarMocks::TAG_GROUP_ID)
            ->get();

        expect($tagGroup)->toBeInstanceOf(CalendarTagGroup::class)
            ->and($tagGroup->id())->toBe(CalendarMocks::TAG_GROUP_ID);
    });

    test("CalendarTagGroup: Can Get Tags For Tag Group", function (): void {
        $tagGroup = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->calendar()
            ->tagGroup()
            ->withId(CalendarMocks::TAG_GROUP_ID)
            ->get();

        $tags = $tagGroup->tags();

        expect($tags)->toBeInstanceOf(Paginator::class)
            ->and($tags->items())->toBeInstanceOf(Collection::class)
            ->and($tags->items()->first())->toBeInstanceOf(CalendarTag::class)
            ->and($tags->items()->first()->id())->toBe(CalendarMocks::TAG_ID)
            ->and($tags->items()->first()->name())->toBe(CalendarMocks::TAG_NAME)
            ->and($tags->response())->not->toBeNull();
    });
})->group("calendar.taggroup");
