<?php

namespace Tests\Unit\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Event;
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\EventInstance;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe('Calendar Event Tests', function () {
    test('Event: Can Get Event By ID', function () {
        $event = Event::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $event->attributes->eventId = "1";

        $response = $event->get();
        /** @var Event $calendarEvent */
        $calendarEvent = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($calendarEvent->attributes->name)->toBe(CalendarMocks::EVENT_NAME)
            ->and($calendarEvent->attributes->eventId)->toBe(CalendarMocks::EVENT_ID);
    });

    test('Event: Can List All Events', function () {
        $event = Event::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $event->all();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    });

    test('Event: Can List All Event Instances For A Specific Event', function () {
        $event = Event::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $event->attributes->eventId = "1";

        $response = $event->instances();

        /** @var EventInstance $eventInstance */
        $eventInstance = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1)
            ->and($eventInstance->relationships->event->data->id)->toBe(CalendarMocks::EVENT_ID)
            ->and($eventInstance->attributes->eventInstanceId)->toBe(CalendarMocks::EVENT_INSTANCE_ID);
    });
})->group('calendar.event');