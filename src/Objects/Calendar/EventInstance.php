<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes\EventInstanceAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Relationships\EventInstanceRelationships;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;

/** @api */
class EventInstance
{
    use HasPlanningCenterClient;

    public const string EVENT_INSTANCE_ENDPOINT = 'calendar/v2/event_instances';

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

    public function all(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . Event::EVENT_ENDPOINT . '/' . $this->relationships->event->data->id . '/event_instances', $query);

        return $this->processResponse($http);
    }

    public function get(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::EVENT_INSTANCE_ENDPOINT . '/' . $this->attributes->eventInstanceId, $query);

        return $this->processResponse($http);
    }

    private function mapFromPco(mixed $pco): void
    {
        $attributeMap = [
            'eventInstanceId' => 'id',
            'allDayEvent' => 'all_day_event',
            'compactRecurrenceDescription' => 'compact_recurrence_description',
            'createdAt' => 'created_at',
            'endsAt' => 'ends_at',
            'location' => 'location',
            'recurrence' => 'recurrence',
            'recurrenceDescription' => 'recurrence_description',
            'startsAt' => 'starts_at',
            'updatedAt' => 'updated_at',
            'churchCenterUrl' => 'church_center_url',
            'publishedStartAt' => 'published_start_at',
            'publishedEndsAt' => 'published_ends_at',
        ];

        AttributeMapper::from($pco, $this->attributes, $attributeMap, ['createdAt', 'endsAt', 'startsAt', 'updatedAt']);
    }
}
