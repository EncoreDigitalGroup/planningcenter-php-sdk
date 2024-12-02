<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes\EventInstanceAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Relationships\EventInstanceRelationships;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships\BasicRelationship;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships\BasicRelationshipData;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\RelationshipMapper;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use EncoreDigitalGroup\StdLib\Exceptions\NullExceptions\NullException;

/** @api */
class EventInstance
{
    use HasPlanningCenterClient;

    public const string EVENT_INSTANCE_ENDPOINT = "calendar/v2/event_instances";

    public EventInstanceAttributes $attributes;
    public EventInstanceRelationships $relationships;

    public static function make(string $clientId, string $clientSecret): EventInstance
    {
        $event = new self($clientId, $clientSecret);
        $event->attributes = new EventInstanceAttributes;
        $event->relationships = new EventInstanceRelationships;
        $event->setApiVersion(PlanningCenterApiVersion::CALENDAR_DEFAULT);

        return $event;
    }

    public function forEventInstanceId(string $eventInstanceId): static
    {
        $this->attributes->eventInstanceId = $eventInstanceId;

        return $this;
    }

    public function forEventId(string $eventId): static
    {
        $this->setupEventRelationship();

        if ($this->relationships->event !== null && $this->relationships->event->data !== null) {
            $this->relationships->event->data->id = $eventId;
        }

        return $this;
    }

    public function all(array $query = []): ClientResponse
    {
        $this->setupEventRelationship();

        if ($this->relationships->event === null) {
            throw new NullException("relationships->event");
        }

        if ($this->relationships->event->data === null) {
            throw new NullException("relationships->event->data");
        }

        if ($this->relationships->event->data->id === null) {
            throw new NullException("relationships->event->data->id");
        }

        $http = $this->client()
            ->get($this->hostname() . Event::EVENT_ENDPOINT . "/{$this->relationships->event->data->id}/event_instances", $query);

        return $this->processResponse($http);
    }

    public function get(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::EVENT_INSTANCE_ENDPOINT . "/" . $this->attributes->eventInstanceId, $query);

        return $this->processResponse($http);
    }

    private function mapFromPco(ClientResponse $clientResponse): void
    {
        $records = objectify($clientResponse->meta->response->json("data"));

        foreach ($records as $record) {
            $this->attributes->eventInstanceId = $record->id;
            $attributeMap = [
                "allDayEvent" => "all_day_event",
                "compactRecurrenceDescription" => "compact_recurrence_description",
                "createdAt" => "created_at",
                "endsAt" => "ends_at",
                "location" => "location",
                "recurrence" => "recurrence",
                "recurrenceDescription" => "recurrence_description",
                "startsAt" => "starts_at",
                "updatedAt" => "updated_at",
                "churchCenterUrl" => "church_center_url",
                "publishedStartAt" => "published_start_at",
                "publishedEndsAt" => "published_ends_at",
            ];

            AttributeMapper::from($record, $this->attributes, $attributeMap, ["created_at", "ends_at", "starts_at", "updated_at"]);

            $relationshipMap = [
                "event" => "event",
            ];

            RelationshipMapper::from($record, $this->relationships, $relationshipMap);
            $clientResponse->data->add($this);

        }

    }

    private function setupEventRelationship(): void
    {
        $this->relationships->event = $this->relationships->event ?? new BasicRelationship;
        $this->relationships->event->data = $this->relationships->event->data ?? new BasicRelationshipData;
    }
}
