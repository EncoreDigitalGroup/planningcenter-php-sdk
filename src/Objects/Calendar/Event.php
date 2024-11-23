<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes\EventAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;

/** @api */
class Event
{
    use HasPlanningCenterClient;

    public const EVENT_ENDPOINT = '/calendar/v2/events';

    public EventAttributes $attributes;

    public static function make(string $clientId, string $clientSecret): Event
    {
        $event = new self($clientId, $clientSecret);
        $event->attributes = new EventAttributes;
        $event->setApiVersion(PlanningCenterApiVersion::CALENDAR_DEFAULT);

        return $event;
    }

    public function all(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::EVENT_ENDPOINT, $query);

        return $this->processResponse($http);
    }

    public function future(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::EVENT_ENDPOINT, array_merge(['filter' => 'future'], $query));

        return $this->processResponse($http);
    }

    public function get(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::EVENT_ENDPOINT . '/' . $this->attributes->eventId, $query);

        return $this->processResponse($http);
    }

    public function instances(array $query = []): ClientResponse
    {
        $eventInstance = new EventInstance($this->clientId, $this->clientSecret);
        $eventInstance->eventId = $this->attributes->eventId;

        return $eventInstance->all($query);
    }
}
