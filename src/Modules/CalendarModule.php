<?php

namespace EncoreDigitalGroup\PlanningCenter\Modules;

use EncoreDigitalGroup\PlanningCenter\Resources\CalendarEvent;
use EncoreDigitalGroup\PlanningCenter\Resources\CalendarTag;
use EncoreDigitalGroup\PlanningCenter\Resources\CalendarTagGroup;
use EncoreDigitalGroup\PlanningCenter\Resources\EventInstance;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;

class CalendarModule extends Module
{
    public function __construct(string $clientId, string $clientSecret)
    {
        parent::__construct($clientId, $clientSecret);
        $this->setApiVersion(PlanningCenterApiVersion::CALENDAR_DEFAULT);
    }

    /** Create a new CalendarEvent resource (read-only) */
    public function event(): CalendarEvent
    {
        $resource = new CalendarEvent($this->clientId, $this->clientSecret);
        $resource->setAuthType($this->authType);

        return $resource;
    }

    /** Create a new EventInstance resource (read-only) */
    public function eventInstance(): EventInstance
    {
        $resource = new EventInstance($this->clientId, $this->clientSecret);
        $resource->setAuthType($this->authType);

        return $resource;
    }

    /** Create a new CalendarTag resource (read-only) */
    public function tag(): CalendarTag
    {
        $resource = new CalendarTag($this->clientId, $this->clientSecret);
        $resource->setAuthType($this->authType);

        return $resource;
    }

    /** Create a new CalendarTagGroup resource (read-only) */
    public function tagGroup(): CalendarTagGroup
    {
        $resource = new CalendarTagGroup($this->clientId, $this->clientSecret);
        $resource->setAuthType($this->authType);

        return $resource;
    }

    /** List all calendar events with pagination (read-only) */
    public function all(array $query = []): Paginator
    {
        return CalendarEvent::all($this->clientId, $this->clientSecret, $query, $this->authType);
    }
}
