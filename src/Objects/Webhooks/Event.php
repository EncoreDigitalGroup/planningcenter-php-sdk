<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2025. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Webhooks;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Attributes\EventAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Relationships\EventRelationships;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use Exception;
use PHPGenesis\Common\Support\Objectify;
use TypeError;

/** @api */
class Event
{
    use HasPlanningCenterClient;

    public const string ENDPOINT = "/webhooks/v2/subscriptions";

    public EventAttributes $attributes;
    public EventRelationships $relationships;

    public static function make(string $clientId, string $clientSecret): Event
    {
        $event = new self($clientId, $clientSecret);
        $event->attributes = new EventAttributes;
        $event->relationships = new EventRelationships;
        $event->setApiVersion(PlanningCenterApiVersion::WEBHOOKS_DEFAULT);

        return $event;
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

    public function all(array $query = []): ClientResponse
    {
        $http = $this->client()->get($this->hostname() . $this->buildEndpoint(), $query);

        return $this->processResponse($http);
    }

    public function get(array $query = []): ClientResponse
    {
        $http = $this->client()->get($this->hostname() . $this->buildEndpoint() . "/{$this->attributes->eventId}", $query);

        return $this->processResponse($http);
    }

    public function ignore(): ClientResponse
    {
        $http = $this->client()->post($this->hostname() . $this->buildEndpoint() . "/{$this->attributes->eventId}/ignore", []);

        return $this->processResponse($http);
    }

    public function redeliver(): ClientResponse
    {
        $http = $this->client()->post($this->hostname() . $this->buildEndpoint() . "/{$this->attributes->eventId}/redeliver", []);

        return $this->processResponse($http);
    }

    public function deliveries(array $query = []): ClientResponse
    {
        $delivery = Delivery::make($this->clientId, $this->clientSecret);

        return $delivery->forWebhookSubscriptionId($this->attributes->webhookSubscriptionId)
            ->forEventId($this->attributes->eventId)
            ->all($query);
    }

    private function buildEndpoint(): string
    {
        return self::ENDPOINT . "/{$this->attributes->webhookSubscriptionId}/events";
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
            $this->attributes->eventId = $record->id;
            $attributeMap = [
                "createdAt" => "created_at",
                "updatedAt" => "updated_at",
                "uuid" => "uuid",
                "payload" => "payload",
                "status" => "status",
            ];

            AttributeMapper::from($record, $this->attributes, $attributeMap, [
                "created_at",
                "updated_at",
            ]);
            $clientResponse->data->add($this);
        }
    }
}
