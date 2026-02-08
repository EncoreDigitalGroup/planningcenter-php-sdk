<?php

namespace Tests\Unit\Webhooks;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\WebhookSubscription;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterWebhookEvent;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("Webhook Subscription Tests", function (): void {
    test("WebhookSubscription: Can List All Webhook Subscriptions", function (): void {
        $webhookSubscription = WebhookSubscription::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $webhookSubscription->all();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    });

    test("WebhookSubscription: Can Get Webhook Subscription By ID", function (): void {
        $webhookSubscription = WebhookSubscription::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $webhookSubscription
            ->forWebhookSubscriptionId(WebhookMocks::WEBHOOK_SUBSCRIPTION_ID)
            ->get();

        /** @var WebhookSubscription $subscription */
        $subscription = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($subscription->attributes->webhookSubscriptionId)->toBe(WebhookMocks::WEBHOOK_SUBSCRIPTION_ID)
            ->and($subscription->attributes->name)->toBe(WebhookMocks::WEBHOOK_SUBSCRIPTION_NAME)
            ->and($subscription->attributes->url)->toBe(WebhookMocks::WEBHOOK_SUBSCRIPTION_URL)
            ->and($subscription->attributes->active)->toBeTrue();
    });

    test("WebhookSubscription: Can Create Webhook Subscription", function (): void {
        $webhookSubscription = WebhookSubscription::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $webhookSubscription->attributes->name = WebhookMocks::WEBHOOK_SUBSCRIPTION_NAME;
        $webhookSubscription->attributes->url = WebhookMocks::WEBHOOK_SUBSCRIPTION_URL;
        $webhookSubscription->attributes->active = true;

        $response = $webhookSubscription->create();

        /** @var WebhookSubscription $subscription */
        $subscription = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($subscription->attributes->name)->toBe(WebhookMocks::WEBHOOK_SUBSCRIPTION_NAME)
            ->and($subscription->attributes->url)->toBe(WebhookMocks::WEBHOOK_SUBSCRIPTION_URL);
    });

    test("WebhookSubscription: Can Update Webhook Subscription", function (): void {
        $webhookSubscription = WebhookSubscription::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $webhookSubscription->attributes->webhookSubscriptionId = WebhookMocks::WEBHOOK_SUBSCRIPTION_ID;
        $webhookSubscription->attributes->active = false;

        $response = $webhookSubscription->update();

        expect($response)->toBeInstanceOf(ClientResponse::class);
    });

    test("WebhookSubscription: Can Delete Webhook Subscription", function (): void {
        $webhookSubscription = WebhookSubscription::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $webhookSubscription->attributes->webhookSubscriptionId = WebhookMocks::WEBHOOK_SUBSCRIPTION_ID;

        $response = $webhookSubscription->delete();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data->first())->toBeNull();
    });

    test("WebhookSubscription: Can Rotate Secret", function (): void {
        $webhookSubscription = WebhookSubscription::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $webhookSubscription->attributes->webhookSubscriptionId = WebhookMocks::WEBHOOK_SUBSCRIPTION_ID;

        $response = $webhookSubscription->rotateSecret();

        expect($response)->toBeInstanceOf(ClientResponse::class);
    });

    test("WebhookSubscription: Can List Events For Subscription", function (): void {
        $webhookSubscription = WebhookSubscription::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $webhookSubscription->attributes->webhookSubscriptionId = WebhookMocks::WEBHOOK_SUBSCRIPTION_ID;

        $response = $webhookSubscription->events();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    });

    test("WebhookSubscription: Can Subscribe To Single Event", function (): void {
        $webhookSubscription = WebhookSubscription::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $webhookSubscription->subscribeToEvent(PlanningCenterWebhookEvent::PeoplePersonCreated);

        expect($webhookSubscription->attributes->eventTypes)->toHaveCount(1)
            ->and($webhookSubscription->attributes->eventTypes[0])->toBe("people.v2.events.person.created");
    });

    test("WebhookSubscription: Can Subscribe To Multiple Events", function (): void {
        $webhookSubscription = WebhookSubscription::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $webhookSubscription->subscribeToEvents([
            PlanningCenterWebhookEvent::PeoplePersonCreated,
            PlanningCenterWebhookEvent::PeoplePersonUpdated,
            PlanningCenterWebhookEvent::GroupsGroupCreated,
        ]);

        expect($webhookSubscription->attributes->eventTypes)->toHaveCount(3)
            ->and($webhookSubscription->attributes->eventTypes)->toContain("people.v2.events.person.created")
            ->and($webhookSubscription->attributes->eventTypes)->toContain("people.v2.events.person.updated")
            ->and($webhookSubscription->attributes->eventTypes)->toContain("groups.v2.events.group.created");
    });

    test("WebhookSubscription: Can Unsubscribe From Event", function (): void {
        $webhookSubscription = WebhookSubscription::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $webhookSubscription->subscribeToEvents([
            PlanningCenterWebhookEvent::PeoplePersonCreated,
            PlanningCenterWebhookEvent::PeoplePersonUpdated,
        ]);

        $webhookSubscription->unsubscribeFromEvent(PlanningCenterWebhookEvent::PeoplePersonCreated);

        expect($webhookSubscription->attributes->eventTypes)->toHaveCount(1)
            ->and($webhookSubscription->attributes->eventTypes[0])->toBe("people.v2.events.person.updated");
    });

    test("WebhookSubscription: Can Clear All Event Subscriptions", function (): void {
        $webhookSubscription = WebhookSubscription::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $webhookSubscription->subscribeToEvents([
            PlanningCenterWebhookEvent::PeoplePersonCreated,
            PlanningCenterWebhookEvent::PeoplePersonUpdated,
        ]);

        $webhookSubscription->clearEventSubscriptions();

        expect($webhookSubscription->attributes->eventTypes)->toHaveCount(0);
    });

    test("WebhookSubscription: Can Get Subscribed Events", function (): void {
        $webhookSubscription = WebhookSubscription::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $webhookSubscription->subscribeToEvents([
            PlanningCenterWebhookEvent::PeoplePersonCreated,
            PlanningCenterWebhookEvent::GroupsGroupCreated,
        ]);

        $events = $webhookSubscription->getSubscribedEvents();

        expect($events)->toHaveCount(2)
            ->and($events)->toContain("people.v2.events.person.created")
            ->and($events)->toContain("groups.v2.events.group.created");
    });

    test("WebhookSubscription: Prevents Duplicate Event Subscriptions", function (): void {
        $webhookSubscription = WebhookSubscription::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $webhookSubscription->subscribeToEvent(PlanningCenterWebhookEvent::PeoplePersonCreated);
        $webhookSubscription->subscribeToEvent(PlanningCenterWebhookEvent::PeoplePersonCreated);

        expect($webhookSubscription->attributes->eventTypes)->toHaveCount(1);
    });
})->group("webhooks.subscription");
