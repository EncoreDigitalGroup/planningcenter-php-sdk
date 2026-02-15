<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Collection;
use InvalidArgumentException;

/** @phpstan-consistent-constructor */
class CalendarEvent
{
    use HasApiMethods, HasAttributes, HasClient;

    public const string ENDPOINT = "/calendar/v2/events";

    protected string $endpoint = self::ENDPOINT;

    /** Get event instances for this event (lazy-loaded) */
    private ?Collection $eventInstances = null;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->attributes = new Collection;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->setApiVersion(PlanningCenterApiVersion::CALENDAR_DEFAULT);
    }

    // Setters (for withId only, as this is read-only)
    public function withId(string $value): self
    {
        return $this->setAttribute("id", $value);
    }

    // Getters
    public function id(): ?string
    {
        return $this->getAttribute("id");
    }

    public function approvalStatus(): ?string
    {
        return $this->getAttribute("approval_status");
    }

    public function createdAt(): ?CarbonImmutable
    {
        return $this->getAttribute("created_at");
    }

    public function description(): ?string
    {
        return $this->getAttribute("description");
    }

    public function featured(): ?bool
    {
        return $this->getAttribute("featured");
    }

    public function imageUrl(): ?string
    {
        return $this->getAttribute("image_url");
    }

    public function name(): ?string
    {
        return $this->getAttribute("name");
    }

    public function percentApproved(): ?int
    {
        return $this->getAttribute("percent_approved");
    }

    public function percentRejected(): ?int
    {
        return $this->getAttribute("percent_rejected");
    }

    public function registrationUrl(): ?string
    {
        return $this->getAttribute("registration_url");
    }

    public function summary(): ?string
    {
        return $this->getAttribute("summary");
    }

    public function updatedAt(): ?CarbonImmutable
    {
        return $this->getAttribute("updated_at");
    }

    public function visibleInChurchCenter(): ?bool
    {
        return $this->getAttribute("visible_in_church_center");
    }

    public function eventInstances(): Collection
    {
        if (!$this->eventInstances instanceof Collection) {
            $eventId = $this->id();
            if ($eventId === null) {
                throw new InvalidArgumentException("Cannot fetch event instances for an event without an ID.");
            }

            $this->eventInstances = EventInstance::forEvent(
                $this->clientId,
                $this->clientSecret,
                $eventId
            )->items();
        }

        return $this->eventInstances;
    }

    protected function dateAttributes(): array
    {
        return [
            "created_at",
            "updated_at",
        ];
    }

    protected function readOnlyAttributes(): array
    {
        return [
            "id",
            "approval_status",
            "created_at",
            "description",
            "featured",
            "image_url",
            "name",
            "percent_approved",
            "percent_rejected",
            "registration_url",
            "summary",
            "updated_at",
            "visible_in_church_center",
        ];
    }
}
