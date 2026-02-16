<?php

namespace Tests\Unit\Calendar;

use EncoreDigitalGroup\PlanningCenter\PlanningCenter;
use EncoreDigitalGroup\PlanningCenter\Resources\EventInstance;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("Calendar EventInstance Tests", function (): void {
    test("EventInstance: Can List All Event Instances (Read-Only)", function (): void {
        $paginator = EventInstance::all(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        expect($paginator)->toBeInstanceOf(Paginator::class)
            ->and($paginator->items())->toBeInstanceOf(Collection::class);
    });

    test("EventInstance: Can Get Event Instance By ID (Read-Only)", function (): void {
        $instance = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->calendar()
            ->eventInstance()
            ->withId(CalendarMocks::EVENT_INSTANCE_ID)
            ->get();

        expect($instance)->toBeInstanceOf(EventInstance::class)
            ->and($instance->id())->toBe(CalendarMocks::EVENT_INSTANCE_ID);
    });

    test("EventInstance: Handles Null Data Response Gracefully", function (): void {
        CalendarMocks::useNullEventInstance();

        $instance = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->calendar()
            ->eventInstance()
            ->withId("999")
            ->get();

        // Should not throw TypeError when data is null
        expect($instance)->toBeInstanceOf(EventInstance::class)
            ->and($instance->id())->toBe("999") // ID was set before get()
            ->and($instance->startsAt())->toBeNull() // But no attributes were hydrated
            ->and($instance->endsAt())->toBeNull();
    });

    test("EventInstance: Filters Out Null Items in Paginator", function (): void {
        CalendarMocks::useEventInstanceCollectionWithNulls();

        $paginator = EventInstance::all(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        // Should filter out null items, leaving only 2 valid items
        expect($paginator->items()->count())->toBe(2)
            ->and($paginator->totalCount())->toBe(2);
    });
})->group("calendar.eventinstance");
