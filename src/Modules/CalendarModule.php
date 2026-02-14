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

    /**
     * Create a new CalendarEvent resource (read-only)
     */
    public function event(): CalendarEvent
    {
        return new CalendarEvent($this->clientId, $this->clientSecret);
    }

    /**
     * Create a new EventInstance resource (read-only)
     */
    public function eventInstance(): EventInstance
    {
        return new EventInstance($this->clientId, $this->clientSecret);
    }

    /**
     * Create a new CalendarTag resource (read-only)
     */
    public function tag(): CalendarTag
    {
        return new CalendarTag($this->clientId, $this->clientSecret);
    }

    /**
     * Create a new CalendarTagGroup resource (read-only)
     */
    public function tagGroup(): CalendarTagGroup
    {
        return new CalendarTagGroup($this->clientId, $this->clientSecret);
    }

    /**
     * List all calendar events with pagination (read-only)
     */
    public function all(array $query = []): Paginator
    {
        return CalendarEvent::all($this->clientId, $this->clientSecret, $query);
    }
}
