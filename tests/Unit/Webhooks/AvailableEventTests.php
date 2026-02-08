<?php

namespace Tests\Unit\Webhooks;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\AvailableEvent;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("Webhook Available Event Tests", function (): void {
    test("AvailableEvent: Can List All Available Events", function (): void {
        $availableEvent = AvailableEvent::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $availableEvent->all();

        /** @var AvailableEvent $event */
        $event = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1)
            ->and($event->attributes->availableEventId)->toBe(WebhookMocks::AVAILABLE_EVENT_ID)
            ->and($event->attributes->action)->toBe("created")
            ->and($event->attributes->app)->toBe("people")
            ->and($event->attributes->name)->toBe("people.v2.events.person.created");
    });
})->group("webhooks.available_event");
