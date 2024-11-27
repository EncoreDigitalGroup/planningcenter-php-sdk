<?php

namespace Tests\Unit\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\EventInstance;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe('Calendar EventInstance Tests', function () {
    test('EventInstance: Can Get EventInstance By ID', function () {
        $eventInstance = EventInstance::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $eventInstance->attributes->eventInstanceId = "1";

        $response = $eventInstance->get();
        /** @var EventInstance $calendarEventInstance */
        $calendarEventInstance = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($calendarEventInstance->attributes->eventInstanceId)->toBe(CalendarMocks::EVENT_INSTANCE_ID)
            ->and($calendarEventInstance->relationships->event->data->id)->toBe(CalendarMocks::EVENT_ID);
    });

    test('EventInstance: Can List All EventInstances', function () {
        $eventInstance = EventInstance::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $eventInstance->relationships->event->data->id = "1";

        $response = $eventInstance->all();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    });
})->group('calendar.eventInstance');