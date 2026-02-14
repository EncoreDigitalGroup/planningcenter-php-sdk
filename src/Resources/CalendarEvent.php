<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Collection;

class CalendarEvent
{
    use HasApiMethods, HasAttributes, HasClient;

    public const string EVENT_ENDPOINT = '/calendar/v2/events';

    protected string $endpoint = '/calendar/v2/events';

    protected array $dateAttributes = [
        'created_at',
        'updated_at',
    ];

    protected array $readOnlyAttributes = [
        'id',
        'approval_status',
        'created_at',
        'description',
        'featured',
        'image_url',
        'name',
        'percent_approved',
        'percent_rejected',
        'registration_url',
        'summary',
        'updated_at',
        'visible_in_church_center',
    ];

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->attributes = new Collection();
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->setApiVersion(PlanningCenterApiVersion::CALENDAR_DEFAULT);
    }

    /**
     * Static factory method for backward compatibility with tests
     */
    public static function make(string $clientId, string $clientSecret): self
    {
        return new self($clientId, $clientSecret);
    }

    // Setters (for withId only, as this is read-only)
    public function withId(string $value): self
    {
        return $this->setAttribute('id', $value);
    }

    // Getters
    public function id(): ?string
    {
        return $this->getAttribute('id');
    }

    public function approvalStatus(): ?string
    {
        return $this->getAttribute('approval_status');
    }

    public function createdAt(): ?CarbonImmutable
    {
        return $this->getAttribute('created_at');
    }

    public function description(): ?string
    {
        return $this->getAttribute('description');
    }

    public function featured(): ?bool
    {
        return $this->getAttribute('featured');
    }

    public function imageUrl(): ?string
    {
        return $this->getAttribute('image_url');
    }

    public function name(): ?string
    {
        return $this->getAttribute('name');
    }

    public function percentApproved(): ?int
    {
        return $this->getAttribute('percent_approved');
    }

    public function percentRejected(): ?int
    {
        return $this->getAttribute('percent_rejected');
    }

    public function registrationUrl(): ?string
    {
        return $this->getAttribute('registration_url');
    }

    public function summary(): ?string
    {
        return $this->getAttribute('summary');
    }

    public function updatedAt(): ?CarbonImmutable
    {
        return $this->getAttribute('updated_at');
    }

    public function visibleInChurchCenter(): ?bool
    {
        return $this->getAttribute('visible_in_church_center');
    }

    /**
     * Get event instances for this event (lazy-loaded)
     */
    private ?Collection $eventInstances = null;

    public function eventInstances(): Collection
    {
        if ($this->eventInstances === null) {
            $this->eventInstances = EventInstance::forEvent(
                $this->clientId,
                $this->clientSecret,
                $this->getAttribute('id')
            )->items();
        }

        return $this->eventInstances;
    }
}
