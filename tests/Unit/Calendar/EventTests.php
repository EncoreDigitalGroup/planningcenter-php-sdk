<?php

namespace Tests\Unit\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes\EventAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Event;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe('Calendar Event Tests', function () {
    test('Event: Can Get Event By ID', function () {
        $event = Event::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $event->attributes->eventId = "1";

        $response = $event->get();
        /** @var EventAttributes $eventAttributes */
        $eventAttributes = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($eventAttributes->name)->toBe(CalendarMocks::EVENT_NAME)
            ->and($eventAttributes->eventId)->toBe(CalendarMocks::EVENT_ID);
    });

    test('Event: Can List All Events', function () {
        $event = Event::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $event->all();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    });
})->group('calendar.event');