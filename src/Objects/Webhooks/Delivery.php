<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2025. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Webhooks;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Attributes\DeliveryAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Relationships\DeliveryRelationships;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use Exception;
use PHPGenesis\Common\Support\Objectify;
use TypeError;

/** @api */
class Delivery
{
    use HasPlanningCenterClient;

    public const string ENDPOINT = "/webhooks/v2/subscriptions";

    public DeliveryAttributes $attributes;
    public DeliveryRelationships $relationships;

    public static function make(string $clientId, string $clientSecret): Delivery
    {
        $delivery = new self($clientId, $clientSecret);
        $delivery->attributes = new DeliveryAttributes;
        $delivery->relationships = new DeliveryRelationships;
        $delivery->setApiVersion(PlanningCenterApiVersion::WEBHOOKS_DEFAULT);

        return $delivery;
    }

    public function forWebhookSubscriptionId(string $webhookSubscriptionId): static
    {
        $this->attributes->webhookSubscriptionId = $webhookSubscriptionId;

        return $this;
    }

    public function forEventId(string $eventId): static
    {
        $this->attributes->eventId = $eventId;

        return $this;
    }

    public function forDeliveryId(string $deliveryId): static
    {
        $this->attributes->deliveryId = $deliveryId;

        return $this;
    }

    public function all(array $query = []): ClientResponse
    {
        $http = $this->client()->get($this->hostname() . $this->buildEndpoint(), $query);

        return $this->processResponse($http);
    }

    public function get(array $query = []): ClientResponse
    {
        $http = $this->client()->get($this->hostname() . $this->buildEndpoint() . "/{$this->attributes->deliveryId}", $query);

        return $this->processResponse($http);
    }

    private function buildEndpoint(): string
    {
        return self::ENDPOINT . "/{$this->attributes->webhookSubscriptionId}/events/{$this->attributes->eventId}/deliveries";
    }

    private function mapFromPco(ClientResponse $clientResponse): void
    {
        try {
            $records = Objectify::make($clientResponse->meta->response->json("data", []));
        } catch (Exception|TypeError) {
            return;
        }

        if (!is_iterable($records)) {
            return;
        }

        foreach ($records as $record) {
            $this->attributes->deliveryId = $record->id;
            $attributeMap = [
                "createdAt" => "created_at",
                "updatedAt" => "updated_at",
                "objectUrl" => "object_url",
                "requestBody" => "request_body",
                "requestHeaders" => "request_headers",
                "responseBody" => "response_body",
                "responseHeaders" => "response_headers",
                "status" => "status",
                "timing" => "timing",
            ];

            AttributeMapper::from($record, $this->attributes, $attributeMap, [
                "created_at",
                "updated_at",
            ]);
            $clientResponse->data->add($this);
        }
    }
}
