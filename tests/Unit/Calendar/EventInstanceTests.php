<?php

namespace Tests\Unit\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\EventInstance;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("Calendar EventInstance Tests", function (): void {
    test("EventInstance: Can Get EventInstance By ID", function (): void {
        $eventInstance = EventInstance::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $eventInstance
            ->forEventInstanceId("1")
            ->get();

        /** @var EventInstance $calendarEventInstance */
        $calendarEventInstance = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($calendarEventInstance->attributes->eventInstanceId)->toBe(CalendarMocks::EVENT_INSTANCE_ID)
            ->and($calendarEventInstance->relationships->event->data->id)->toBe(CalendarMocks::EVENT_ID);
    });

    test("EventInstance: Can List All EventInstances", function (): void {
        $eventInstance = EventInstance::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $eventInstance
            ->forEventId("1")
            ->all();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    });
})->group("calendar.eventInstance");