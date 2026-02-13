<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2025. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Webhooks;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Attributes\WebhookSubscriptionAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use Exception;
use Illuminate\Support\Arr;
use PHPGenesis\Common\Support\Objectify;
use TypeError;

/** @api */
class WebhookSubscription
{
    use HasPlanningCenterClient;

    public const string ENDPOINT = "/webhooks/v2/webhook_subscriptions";

    public WebhookSubscriptionAttributes $attributes;

    public static function make(string $clientId, string $clientSecret): WebhookSubscription
    {
        $webhookSubscription = new self($clientId, $clientSecret);
        $webhookSubscription->attributes = new WebhookSubscriptionAttributes;
        $webhookSubscription->setApiVersion(PlanningCenterApiVersion::WEBHOOKS_DEFAULT);

        return $webhookSubscription;
    }

    public function forWebhookSubscriptionId(string $webhookSubscriptionId): static
    {
        $this->attributes->webhookSubscriptionId = $webhookSubscriptionId;

        return $this;
    }

    public function all(array $query = []): ClientResponse
    {
        $http = $this->client()->get($this->hostname() . self::ENDPOINT, $query);

        return $this->processResponse($http);
    }

    public function get(array $query = []): ClientResponse
    {
        $http = $this->client()->get($this->hostname() . self::ENDPOINT . "/{$this->attributes->webhookSubscriptionId}", $query);

        return $this->processResponse($http);
    }

    public function create(): bool
    {
        $http = $this->client()->post($this->hostname() . self::ENDPOINT, $this->mapToPco());

        return $http->successful();
    }

    public function update(): bool
    {
        $http = $this->client()
            ->patch($this->hostname() . self::ENDPOINT . "/{$this->attributes->webhookSubscriptionId}", $this->mapToPco(isUpdate: true));

        return $http->successful();
    }

    public function delete(): bool
    {
        $http = $this->client()->delete($this->hostname() . self::ENDPOINT . "/{$this->attributes->webhookSubscriptionId}");

        return $http->successful();
    }

    public function rotateSecret(): bool
    {
        $http = $this->client()->post($this->hostname() . self::ENDPOINT . "/{$this->attributes->webhookSubscriptionId}/rotate_secret", []);

        return $http->successful();
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
            $webhook = self::make($this->clientId, $this->clientSecret);
            $webhook->attributes->webhookSubscriptionId = $record->id;
            $attributeMap = [
                "active" => "active",
                "applicationId" => "application_id",
                "authenticitySecret" => "authenticity_secret",
                "createdAt" => "created_at",
                "name" => "name",
                "updatedAt" => "updated_at",
                "url" => "url",
            ];

            AttributeMapper::from($record, $webhook->attributes, $attributeMap, [
                "created_at",
                "updated_at",
            ]);

            $clientResponse->data->add($webhook);
        }
    }

    private function mapToPco(bool $isUpdate = false): array
    {
        $webhookSubscription = [
            "data" => [
                "attributes" => [
                    "active" => $this->attributes->active ?? null,
                    "name" => $this->attributes->name,
                    "url" => $this->attributes->url ?? null,
                ],
            ],
        ];

        if ($isUpdate) {
            unset($webhookSubscription["data"]["attributes"]["name"]);
            unset($webhookSubscription["data"]["attributes"]["url"]);
        }

        $webhookSubscription["data"]["attributes"] = Arr::whereNotNull($webhookSubscription["data"]["attributes"]);

        return $webhookSubscription;
    }
}
