<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Collection;

class PersonMerger
{
    use HasAttributes, HasClient;

    protected string $endpoint = '/people/v2/person_mergers';

    protected array $dateAttributes = [
        'created_at',
    ];

    protected array $readOnlyAttributes = [
        'id',
        'created_at',
        'person_to_keep_id',
        'person_to_remove_id',
    ];

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->attributes = new Collection();
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->setApiVersion(PlanningCenterApiVersion::PEOPLE_DEFAULT);
    }

    // Setters
    public function withId(string $value): self
    {
        return $this->setAttribute('id', $value);
    }

    public function withPersonToKeepId(?int $value): self
    {
        return $this->setAttribute('person_to_keep_id', $value);
    }

    public function withPersonToRemoveId(?int $value): self
    {
        return $this->setAttribute('person_to_remove_id', $value);
    }

    // Getters
    public function id(): ?string
    {
        return $this->getAttribute('id');
    }

    public function createdAt(): ?CarbonImmutable
    {
        return $this->getAttribute('created_at');
    }

    public function personToKeepId(): ?int
    {
        return $this->getAttribute('person_to_keep_id');
    }

    public function personToRemoveId(): ?int
    {
        return $this->getAttribute('person_to_remove_id');
    }

    /**
     * Fetch a single person merger by ID (read-only)
     */
    public function get(): self
    {
        if (!$this->getAttribute('id')) {
            throw new \InvalidArgumentException('Cannot fetch person merger without an ID. Use withId() first.');
        }

        $response = $this->client()->get(
            $this->hostname() . $this->endpoint . '/' . $this->getAttribute('id')
        );

        $this->hydrateFromResponse($response);

        return $this;
    }

    /**
     * List all person mergers with pagination
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
