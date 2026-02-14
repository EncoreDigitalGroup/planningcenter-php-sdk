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
})->group("calendar.eventinstance");
