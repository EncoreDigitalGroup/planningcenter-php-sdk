<?php

namespace Tests\Unit\Webhooks;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Delivery;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("Webhook Delivery Tests", function (): void {
    test("Delivery: Can List All Deliveries For Event", function (): void {
        $delivery = Delivery::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $delivery
            ->forWebhookSubscriptionId(WebhookMocks::WEBHOOK_SUBSCRIPTION_ID)
            ->forEventId(WebhookMocks::EVENT_ID)
            ->all();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    });

    test("Delivery: Can Get Delivery By ID", function (): void {
        $delivery = Delivery::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $delivery
            ->forWebhookSubscriptionId(WebhookMocks::WEBHOOK_SUBSCRIPTION_ID)
            ->forEventId(WebhookMocks::EVENT_ID)
            ->forDeliveryId(WebhookMocks::DELIVERY_ID)
            ->get();

        /** @var Delivery $deliveryRecord */
        $deliveryRecord = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($deliveryRecord->attributes->deliveryId)->toBe(WebhookMocks::DELIVERY_ID)
            ->and($deliveryRecord->attributes->status)->toBe(200)
            ->and($deliveryRecord->attributes->timing)->toBe(0.123);
    });
})->group("webhooks.delivery");
