<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes\EventAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Relationships\EventInstanceRelationships;
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Relationships\EventRelationships;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships\BasicRelationship;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships\BasicRelationshipData;
use EncoreDigitalGroup\PlanningCenter\Support\AttributeMapper;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;

/** @api */
class Event
{
    use HasPlanningCenterClient;

    public const string EVENT_ENDPOINT = "/calendar/v2/events";

    public EventAttributes $attributes;
    public EventRelationships $relationships;

    public static function make(string $clientId, string $clientSecret): Event
    {
        $event = new self($clientId, $clientSecret);
        $event->attributes = new EventAttributes;
        $event->relationships = new EventRelationships;
        $event->setApiVersion(PlanningCenterApiVersion::CALENDAR_DEFAULT);

        return $event;
    }

    public function forEventId(string $eventId): static
    {
        $this->attributes->eventId = $eventId;

        return $this;
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
            ->get($this->hostname() . self::EVENT_ENDPOINT, array_merge(["filter" => "future"], $query));

        return $this->processResponse($http);
    }

    public function get(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::EVENT_ENDPOINT . "/" . $this->attributes->eventId, $query);

        return $this->processResponse($http);
    }

    public function instances(array $query = []): ClientResponse
    {
        $eventInstance = EventInstance::make($this->clientId, $this->clientSecret);

        $eventInstance->relationships->event->data->id = $this->attributes->eventId;

        return $eventInstance->all($query);
    }

    public function tags(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::EVENT_ENDPOINT . "/{$this->attributes->eventId}/tags", $query);

        if ($this->isUsingSupportedApiVersion()) {
            $tags = $http->json("data");
            foreach ($tags as $tag) {
                $tagRecord = Tag::make($this->clientId, $this->clientSecret);
                $tagRecord->mapFromPco($tag);
                $this->relationships->tags->add($tagRecord);
            }
        }

        $clientResponse = new ClientResponse($http);
        $clientResponse->data->add($this);

        return $clientResponse;
    }

    private function mapFromPco(mixed $pco): void
    {
        $pco = pco_objectify($pco);

        if (is_null($pco)) {
            return;
        }

        $attributeMap = [
            "eventId" => "id",
            "approvalStatus" => "approval_status",
            "createdAt" => "created_at",
            "description" => "description",
            "featured" => "featured",
            "imageUrl" => "image_url",
            "name" => "name",
            "percentApproved" => "percent_approved",
            "percentRejected" => "percent_rejected",
            "registrationUrl" => "registration_url",
            "summary" => "summary",
            "updatedAt" => "updated_at",
            "visibleInChurchCenter" => "visible_in_church_center",
        ];

        AttributeMapper::from($pco, $this->attributes, $attributeMap, ["created_at", "updated_at"]);
    }
}
