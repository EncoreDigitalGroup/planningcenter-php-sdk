<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\EventAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use Illuminate\Support\Carbon;
use stdClass;

/** @api */
class Event
{
    use HasPlanningCenterClient;

    public const string EVENT_ENDPOINT = '/groups/v2/events';

    public EventAttributes $attributes;

    public static function make(string $clientId, string $clientSecret): Event
    {
        $event = new self($clientId, $clientSecret);
        $event->attributes = new EventAttributes;
        $event->setApiVersion(PlanningCenterApiVersion::GROUPS_DEFAULT);

        return $event;
    }

    public function all(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::EVENT_ENDPOINT, $query);

        $clientResponse = new ClientResponse($http);

        foreach ($http->json('data') as $groupEvent) {
            $pcoGroupEvent = new Event($this->clientId, $this->clientSecret);
            $pcoGroupEvent->mapFromPco($groupEvent);
            $clientResponse->data->push($pcoGroupEvent);
        }

        return $clientResponse;
    }

    public function get(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::EVENT_ENDPOINT . '/' . $this->id, $query);

        return $this->processResponse($http);
    }

    private function mapFromPco(stdClass $pco): void
    {
        $this->attributes->attendanceRequestsEnabled = $pco->attributes->attendance_requests_enabled;
        $this->attributes->automatedReminderEnabled = $pco->attributes->automated_reminder_enabled;
        $this->attributes->canceled = $pco->attributes->canceled;
        $this->attributes->canceledAt = Carbon::createFromFormat('c', $pco->attributes->canceled_at);
        $this->attributes->description = $pco->attributes->description;
        $this->attributes->endsAt = Carbon::createFromFormat('c', $pco->attributes->description);
        $this->attributes->locationTypePreference = $pco->attributes->location_type_preference;
        $this->attributes->multiDay = $pco->attributes->multi_day;
        $this->attributes->name = $pco->attributes->name;
        $this->attributes->remindersSent = $pco->attributes->reminders_sent;
        $this->attributes->remindersSentAt = Carbon::createFromFormat('c', $pco->attributes->reminders_sent_at);
        $this->attributes->repeating = $pco->attributes->repeating;
        $this->attributes->startsAt = Carbon::createFromFormat('c', $pco->attributes->starts_at);
        $this->attributes->virtualLocationUrl = $pco->attributes->virtual_location_url;
        $this->attributes->visitorsCount = $pco->attributes->visitors_count;
    }
}
