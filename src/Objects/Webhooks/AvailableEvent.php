<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2025. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Webhooks;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Attributes\AvailableEventAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use Exception;
use PHPGenesis\Common\Support\Objectify;
use TypeError;

/** @api */
class AvailableEvent
{
    use HasPlanningCenterClient;

    public const string ENDPOINT = "/webhooks/v2/available_events";

    public AvailableEventAttributes $attributes;

    public static function make(string $clientId, string $clientSecret): AvailableEvent
    {
        $availableEvent = new self($clientId, $clientSecret);
        $availableEvent->attributes = new AvailableEventAttributes;
        $availableEvent->setApiVersion(PlanningCenterApiVersion::WEBHOOKS_DEFAULT);

        return $availableEvent;
    }

    public function all(array $query = []): ClientResponse
    {
        $http = $this->client()->get($this->hostname() . self::ENDPOINT, $query);

        return $this->processResponse($http);
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
            $this->attributes->availableEventId = $record->id;
            $attributeMap = [
                "action" => "action",
                "app" => "app",
                "name" => "name",
                "resource" => "resource",
                "type" => "type",
                "version" => "version",
            ];

            AttributeMapper::from($record, $this->attributes, $attributeMap, []);
            $clientResponse->data->add($this);
        }
    }
}
