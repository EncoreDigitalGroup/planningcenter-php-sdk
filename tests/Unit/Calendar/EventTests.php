<?php

namespace Tests\Unit\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Event;
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\EventInstance;
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Tag;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("Calendar Event Tests", function (): void {
    test("Event: Can Get Event By ID", function (): void {
        $event = Event::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $event->forEventId("1")->get();
        /** @var Event $calendarEvent */
        $calendarEvent = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($calendarEvent->attributes->name)->toBe(CalendarMocks::EVENT_NAME)
            ->and($calendarEvent->attributes->eventId)->toBe(CalendarMocks::EVENT_ID);
    });

    test("Event: Can List All Events", function (): void {
        $event = Event::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $event->all();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    });

    test("Event: Can List All Event Instances For A Specific Event", function (): void {
        $event = Event::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $event->forEventId("1")->instances();

        /** @var EventInstance $eventInstance */
        $eventInstance = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1)
            ->and($eventInstance->relationships->event->data->id)->toBe(CalendarMocks::EVENT_ID)
            ->and($eventInstance->attributes->eventInstanceId)->toBe(CalendarMocks::EVENT_INSTANCE_ID);
    });

    test("Event: Can List All Tags Associated with an Event", function (): void {
        $event = Event::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $event->forEventId("1")->tags();

        /** @var Event $calendarEvent */
        $calendarEvent = $response->data->first();

        /** @var Tag $tag */
        $tag = $calendarEvent->relationships->tags->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1)
            ->and($tag->attributes->tagId)->toBe(CalendarMocks::TAG_ID)
            ->and($tag->attributes->name)->toBe(CalendarMocks::TAG_NAME);
    });
})->group("calendar.event");