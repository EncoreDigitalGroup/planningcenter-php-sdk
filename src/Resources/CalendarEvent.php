<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Collection;

class CalendarEvent
{
    use HasAttributes, HasClient;

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
     * Fetch a single calendar event by ID (read-only)
     */
    public function get(): self
    {
        if (!$this->getAttribute('id')) {
            throw new \InvalidArgumentException('Cannot fetch calendar event without an ID. Use withId() first.');
        }

        $response = $this->client()->get(
            $this->hostname() . $this->endpoint . '/' . $this->getAttribute('id')
        );

        $this->hydrateFromResponse($response);

        return $this;
    }

    /**
     * List all calendar events with pagination (read-only)
     */
    public static function all(
        string $clientId,
        string $clientSecret,
        array $query = []
    ): Paginator {
        $instance = new static($clientId, $clientSecret);

        $response = $instance->client()->get(
            $instance->hostname() . $instance->endpoint,
            $query
        );

        $data = collect($response->json('data'))->map(function ($item) use ($clientId, $clientSecret) {
            $resource = new static($clientId, $clientSecret);
            $resource->hydrateFromArray($item);
            return $resource;
        });

        $meta = $response->json('meta');

        return new Paginator(
            data: $data,
            nextUrl: $response->json('links.next'),
            prevUrl: $response->json('links.prev'),
            totalCount: $meta['total_count'] ?? 0,
            perPage: $meta['per_page'] ?? 25
        );
    }

    /**
     * Hydrate attributes from API response
     */
    protected function hydrateFromResponse($response): void
    {
        $data = $response->json('data');

        // Handle array responses (list endpoints)
        if (is_array($data) && isset($data[0])) {
            $data = $data[0];
        }

        $this->hydrateFromArray($data);
    }
}
