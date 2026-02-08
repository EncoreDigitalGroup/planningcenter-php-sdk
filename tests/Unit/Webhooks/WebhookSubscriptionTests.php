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
        $webhookSubscription->attributes->name = PlanningCenterWebhookEvent::PeoplePersonCreated->value;
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
})->group("webhooks.subscription");
