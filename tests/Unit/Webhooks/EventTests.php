<?php

namespace Tests\Unit\Webhooks;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Event;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("Webhook Event Tests", function (): void {
    test("Event: Can List All Events For Subscription", function (): void {
        $event = Event::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $event
            ->forWebhookSubscriptionId(WebhookMocks::WEBHOOK_SUBSCRIPTION_ID)
            ->all();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    });

    test("Event: Can Get Event By ID", function (): void {
        $event = Event::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $event
            ->forWebhookSubscriptionId(WebhookMocks::WEBHOOK_SUBSCRIPTION_ID)
            ->forEventId(WebhookMocks::EVENT_ID)
            ->get();

        /** @var Event $webhookEvent */
        $webhookEvent = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($webhookEvent->attributes->eventId)->toBe(WebhookMocks::EVENT_ID)
            ->and($webhookEvent->attributes->status)->toBe("delivered");
    });

    test("Event: Can Ignore Event", function (): void {
        $event = Event::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $event
            ->forWebhookSubscriptionId(WebhookMocks::WEBHOOK_SUBSCRIPTION_ID)
            ->forEventId(WebhookMocks::EVENT_ID)
            ->ignore();

        expect($response)->toBeInstanceOf(ClientResponse::class);
    });

    test("Event: Can Redeliver Event", function (): void {
        $event = Event::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $event
            ->forWebhookSubscriptionId(WebhookMocks::WEBHOOK_SUBSCRIPTION_ID)
            ->forEventId(WebhookMocks::EVENT_ID)
            ->redeliver();

        expect($response)->toBeInstanceOf(ClientResponse::class);
    });

    test("Event: Can List Deliveries For Event", function (): void {
        $event = Event::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $event
            ->forWebhookSubscriptionId(WebhookMocks::WEBHOOK_SUBSCRIPTION_ID)
            ->forEventId(WebhookMocks::EVENT_ID)
            ->deliveries();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    });
})->group("webhooks.event");
