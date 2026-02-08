<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024-2025. Encore Digital Group
 */

namespace Tests\Unit\Webhooks;

use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\AvailableEvent;
use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Delivery;
use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Event;
use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\WebhookSubscription;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use PHPGenesis\Http\HttpClient;
use Tests\Helpers\BaseMock;
use Tests\Helpers\ObjectType;

class WebhookMocks extends BaseMock
{
    use HasPlanningCenterClient;

    public const string WEBHOOK_SUBSCRIPTION_ID = "1";
    public const string WEBHOOK_SUBSCRIPTION_NAME = "Test Webhook";
    public const string WEBHOOK_SUBSCRIPTION_URL = "https://example.com/webhook";
    public const string EVENT_ID = "1";
    public const string DELIVERY_ID = "1";
    public const string AVAILABLE_EVENT_ID = "1";

    public static function setup(): void
    {
        self::useWebhookSubscriptionCollection();
        self::useSpecificWebhookSubscription();
        self::useWebhookSubscriptionRotateSecret();
        self::useEventCollection();
        self::useSpecificEvent();
        self::useEventActions();
        self::useDeliveryCollection();
        self::useSpecificDelivery();
        self::useAvailableEventCollection();
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

    public static function useEventCollection(): void
    {
        HttpClient::fake([
            self::HOSTNAME . WebhookSubscription::ENDPOINT . "/1/events" => function ($request) {
                return match ($request->method()) {
                    "GET" => HttpClient::response(self::useCollectionResponse(ObjectType::WebhookEvent)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    public static function useSpecificEvent(): void
    {
        HttpClient::fake([
            self::HOSTNAME . WebhookSubscription::ENDPOINT . "/1/events/1" => function ($request) {
                return match ($request->method()) {
                    "GET" => HttpClient::response(self::useSingleResponse(ObjectType::WebhookEvent)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    public static function useEventActions(): void
    {
        HttpClient::fake([
            self::HOSTNAME . WebhookSubscription::ENDPOINT . "/1/events/1/ignore" => function ($request) {
                return match ($request->method()) {
                    "POST" => HttpClient::response(self::useSingleResponse(ObjectType::WebhookEvent)),
                    default => HttpClient::response([], 405),
                };
            },
            self::HOSTNAME . WebhookSubscription::ENDPOINT . "/1/events/1/redeliver" => function ($request) {
                return match ($request->method()) {
                    "POST" => HttpClient::response(self::useSingleResponse(ObjectType::WebhookEvent)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    public static function useDeliveryCollection(): void
    {
        HttpClient::fake([
            self::HOSTNAME . WebhookSubscription::ENDPOINT . "/1/events/1/deliveries" => function ($request) {
                return match ($request->method()) {
                    "GET" => HttpClient::response(self::useCollectionResponse(ObjectType::WebhookDelivery)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    public static function useSpecificDelivery(): void
    {
        HttpClient::fake([
            self::HOSTNAME . WebhookSubscription::ENDPOINT . "/1/events/1/deliveries/1" => function ($request) {
                return match ($request->method()) {
                    "GET" => HttpClient::response(self::useSingleResponse(ObjectType::WebhookDelivery)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    public static function useAvailableEventCollection(): void
    {
        HttpClient::fake([
            self::HOSTNAME . AvailableEvent::ENDPOINT => function ($request) {
                return match ($request->method()) {
                    "GET" => HttpClient::response(self::useCollectionResponse(ObjectType::WebhookAvailableEvent)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    protected static function webhook_subscription(): array
    {
        return [
            "type" => "WebhookSubscription",
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

    protected static function webhook_event(): array
    {
        return [
            "type" => "Event",
            "id" => self::EVENT_ID,
            "attributes" => [
                "created_at" => "2000-01-01T12:00:00Z",
                "updated_at" => "2000-01-01T12:00:00Z",
                "uuid" => "123e4567-e89b-12d3-a456-426614174000",
                "payload" => '{"data": {"id": "1", "type": "Person"}}',
                "status" => "delivered",
            ],
            "relationships" => [
                "subscription" => [
                    "data" => [
                        "type" => "WebhookSubscription",
                        "id" => self::WEBHOOK_SUBSCRIPTION_ID,
                    ],
                ],
                "person" => [
                    "data" => [
                        "type" => "Person",
                        "id" => "1",
                    ],
                ],
            ],
        ];
    }

    protected static function webhook_delivery(): array
    {
        return [
            "type" => "Delivery",
            "id" => self::DELIVERY_ID,
            "attributes" => [
                "created_at" => "2000-01-01T12:00:00Z",
                "updated_at" => "2000-01-01T12:00:00Z",
                "object_url" => "https://api.planningcenteronline.com/people/v2/people/1",
                "request_body" => '{"data": {"id": "1"}}',
                "request_headers" => '{"Content-Type": "application/json"}',
                "response_body" => '{"success": true}',
                "response_headers" => '{"Content-Type": "application/json"}',
                "status" => 200,
                "timing" => 0.123,
            ],
            "relationships" => [
                "event" => [
                    "data" => [
                        "type" => "Event",
                        "id" => self::EVENT_ID,
                    ],
                ],
            ],
        ];
    }

    protected static function available_event(): array
    {
        return [
            "type" => "AvailableEvent",
            "id" => self::AVAILABLE_EVENT_ID,
            "attributes" => [
                "action" => "created",
                "app" => "people",
                "name" => "people.v2.events.person.created",
                "resource" => "person",
                "type" => "Event",
                "version" => "v2",
            ],
        ];
    }
}
