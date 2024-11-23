<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\EventAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
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
            ->get($this->hostname() . self::EVENT_ENDPOINT . '/' . $this->attributes->eventId, $query);

        return $this->processResponse($http);
    }

    private function mapFromPco(mixed $pco): void
    {
        $pco = objectify($pco);

        $attributeMap = [
            'eventId' => 'id',
            'attendanceRequestsEnabled' => 'attendance_requests_enabled',
            'automatedReminderEnabled' => 'automated_reminder_enabled',
            'canceled' => 'canceled',
            'canceledAt' => 'canceled_at',
            'description' => 'description',
            'endsAt' => 'ends_at',
            'locationTypePreference' => 'location_type_preference',
            'multiDay' => 'multi_day',
            'name' => 'name',
            'remindersSent' => 'reminders_sent',
            'remindersSentAt' => 'reminders_sent_at',
            'repeating' => 'repeating',
            'startsAt' => 'starts_at',
            'virtualLocationUrl' => 'virtual_location_url',
            'visitorsCount' => 'visitors_count',
        ];

        AttributeMapper::from($pco, $this->attributes, $attributeMap, ['canceledAt', 'endsAt', 'remindersSentAt', 'startsAt']);
    }
}
