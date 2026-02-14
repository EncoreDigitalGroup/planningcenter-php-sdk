<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Collection;

class EventInstance
{
    use HasAttributes, HasClient;

    public const string EVENT_INSTANCE_ENDPOINT = '/calendar/v2/event_instances';

    protected string $endpoint = '/calendar/v2/event_instances';

    protected array $dateAttributes = [
        'created_at',
        'ends_at',
        'starts_at',
        'updated_at',
    ];

    protected array $readOnlyAttributes = [
        'id',
        'all_day_event',
        'compact_recurrence_description',
        'created_at',
        'ends_at',
        'location',
        'recurrence',
        'recurrence_description',
        'starts_at',
        'updated_at',
        'church_center_url',
        'published_start_at',
        'published_ends_at',
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

    public function allDayEvent(): ?bool
    {
        return $this->getAttribute('all_day_event');
    }

    public function compactRecurrenceDescription(): ?string
    {
        return $this->getAttribute('compact_recurrence_description');
    }

    public function createdAt(): ?CarbonImmutable
    {
        return $this->getAttribute('created_at');
    }

    public function endsAt(): ?CarbonImmutable
    {
        return $this->getAttribute('ends_at');
    }

    public function location(): ?string
    {
        return $this->getAttribute('location');
    }

    public function recurrence(): ?string
    {
        return $this->getAttribute('recurrence');
    }

    public function recurrenceDescription(): ?string
    {
        return $this->getAttribute('recurrence_description');
    }

    public function startsAt(): ?CarbonImmutable
    {
        return $this->getAttribute('starts_at');
    }

    public function updatedAt(): ?CarbonImmutable
    {
        return $this->getAttribute('updated_at');
    }

    public function churchCenterUrl(): ?string
    {
        return $this->getAttribute('church_center_url');
    }

    public function publishedStartAt(): ?string
    {
        return $this->getAttribute('published_start_at');
    }

    public function publishedEndsAt(): ?string
    {
        return $this->getAttribute('published_ends_at');
    }

    /**
     * Fetch a single event instance by ID (read-only)
     */
    public function get(): self
    {
        if (!$this->getAttribute('id')) {
            throw new \InvalidArgumentException('Cannot fetch event instance without an ID. Use withId() first.');
        }

        $response = $this->client()->get(
            $this->hostname() . $this->endpoint . '/' . $this->getAttribute('id')
        );

        $this->hydrateFromResponse($response);

        return $this;
    }

    /**
     * List all event instances with pagination (read-only)
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
