<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Collection;

class CalendarTag
{
    use HasAttributes, HasClient;

    protected string $endpoint = '/calendar/v2/tags';

    protected array $dateAttributes = [
        'created_at',
        'updated_at',
    ];

    protected array $readOnlyAttributes = [
        'id',
        'church_center_category',
        'color',
        'created_at',
        'name',
        'position',
        'updated_at',
    ];

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->attributes = new Collection();
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->setApiVersion(PlanningCenterApiVersion::CALENDAR_DEFAULT);
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

    public function churchCenterCategory(): ?bool
    {
        return $this->getAttribute('church_center_category');
    }

    public function color(): ?string
    {
        return $this->getAttribute('color');
    }

    public function createdAt(): ?CarbonImmutable
    {
        return $this->getAttribute('created_at');
    }

    public function name(): ?string
    {
        return $this->getAttribute('name');
    }

    public function position(): ?int
    {
        return $this->getAttribute('position');
    }

    public function updatedAt(): ?CarbonImmutable
    {
        return $this->getAttribute('updated_at');
    }

    /**
     * Fetch a single calendar tag by ID (read-only)
     */
    public function get(): self
    {
        if (!$this->getAttribute('id')) {
            throw new \InvalidArgumentException('Cannot fetch calendar tag without an ID. Use withId() first.');
        }

        $response = $this->client()->get(
            $this->hostname() . $this->endpoint . '/' . $this->getAttribute('id')
        );

        $this->hydrateFromResponse($response);

        return $this;
    }

    /**
     * List all calendar tags with pagination (read-only)
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
