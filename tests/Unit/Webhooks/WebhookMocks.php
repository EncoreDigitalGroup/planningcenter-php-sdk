<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024-2025. Encore Digital Group
 */

namespace Tests\Unit\Webhooks;

use EncoreDigitalGroup\PlanningCenter\Resources\WebhookSubscription;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use PHPGenesis\Http\HttpClient;
use Tests\Helpers\BaseMock;
use Tests\Helpers\ObjectType;

class WebhookMocks extends BaseMock
{
    use HasClient;

    public const string WEBHOOK_SUBSCRIPTION_ID = "1";
    public const string WEBHOOK_SUBSCRIPTION_NAME = "people.v2.events.person.created";
    public const string WEBHOOK_SUBSCRIPTION_URL = "https://example.com/webhook";

    public static function setup(): void
    {
        self::useWebhookSubscriptionCollection();
        self::useSpecificWebhookSubscription();
        self::useWebhookSubscriptionRotateSecret();
    }

    public static function useWebhookSubscriptionCollection(): void
    {
        HttpClient::fake([
            self::HOSTNAME . WebhookSubscription::ENDPOINT => function ($request) {
                return match ($request->method()) {
                    "POST" => HttpClient::response(self::useSingleResponse(ObjectType::WebhookSubscription)),
                    "GET" => HttpClient::response(self::useCollectionResponse(ObjectType::WebhookSubscription)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    public static function useSpecificWebhookSubscription(): void
    {
        HttpClient::fake([
            self::HOSTNAME . WebhookSubscription::ENDPOINT . "/1" => function ($request) {
                return match ($request->method()) {
                    "PUT", "PATCH", "GET" => HttpClient::response(self::useSingleResponse(ObjectType::WebhookSubscription)),
                    "DELETE" => HttpClient::response(self::deleteResponse()),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    public static function useWebhookSubscriptionRotateSecret(): void
    {
        HttpClient::fake([
            self::HOSTNAME . WebhookSubscription::ENDPOINT . "/1/rotate_secret" => function ($request) {
                return match ($request->method()) {
                    "POST" => HttpClient::response(self::useSingleResponse(ObjectType::WebhookSubscription)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    protected static function webhook_subscription(): array
    {
        return [
            "type" => "Subscription",
            "id" => self::WEBHOOK_SUBSCRIPTION_ID,
            "attributes" => [
                "active" => true,
                "application_id" => "app_123",
                "authenticity_secret" => "secret_abc123",
                "created_at" => "2000-01-01T12:00:00Z",
                "name" => self::WEBHOOK_SUBSCRIPTION_NAME,
                "updated_at" => "2000-01-01T12:00:00Z",
                "url" => self::WEBHOOK_SUBSCRIPTION_URL,
            ],
            "relationships" => [],
        ];
    }
}
