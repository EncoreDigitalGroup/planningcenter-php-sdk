<?php

namespace EncoreDigitalGroup\PlanningCenter\Support\Traits;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

trait HasApiMethods
{
    /**
     * Fetch a single resource by ID
     */
    public function get(): self
    {
        if (!$this->getAttribute('id')) {
            throw new \InvalidArgumentException('Cannot fetch resource without an ID. Use withId() first.');
        }

        $response = $this->client()->get(
            $this->hostname() . $this->endpoint . '/' . $this->getAttribute('id')
        );

        $this->hydrateFromResponse($response);

        return $this;
    }

    /**
     * Smart save - creates if no ID, updates if ID exists
     */
    public function save(): self
    {
        if ($this->getAttribute('id')) {
            return $this->update();
        }

        return $this->create();
    }

    /**
     * Delete the resource
     */
    public function delete(): bool
    {
        if (!$this->getAttribute('id')) {
            throw new \InvalidArgumentException('Cannot delete resource without an ID.');
        }

        $response = $this->client()->delete(
            $this->hostname() . $this->endpoint . '/' . $this->getAttribute('id')
        );

        return $response->successful();
    }

    /**
     * List all resources with pagination
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
     * Query resources with filters
     */
    public static function where(array $query): Paginator
    {
        // This requires singleton credentials, will be implemented via modules
        throw new \BadMethodCallException(
            'where() must be called through a module. Use PlanningCenter::make()->withBasicAuth()->people()->all($query) instead.'
        );
    }

    /**
     * Create a new resource
     */
    protected function create(): self
    {
        $response = $this->client()->post(
            $this->hostname() . $this->endpoint,
            $this->mapToPco()
        );

        $this->hydrateFromResponse($response);

        return $this;
    }

    /**
     * Update an existing resource
     */
    protected function update(): self
    {
        $response = $this->client()->patch(
            $this->hostname() . $this->endpoint . '/' . $this->getAttribute('id'),
            $this->mapToPco()
        );

        $this->hydrateFromResponse($response);

        return $this;
    }

    /**
     * Hydrate attributes from API response
     */
    protected function hydrateFromResponse(Response $response): void
    {
        $data = $response->json('data');

        // Handle array responses (list endpoints)
        if (is_array($data) && isset($data[0])) {
            $data = $data[0];
        }

        $this->hydrateFromArray($data);
    }

    /**
     * Convert attributes to Planning Center API format
     */
    protected function mapToPco(): array
    {
        // Get read-only attributes if defined, otherwise empty array
        $readOnlyAttributes = property_exists($this, 'readOnlyAttributes')
            ? $this->readOnlyAttributes
            : [];

        // Exclude read-only attributes
        $attributes = $this->attributes
            ->except($readOnlyAttributes)
            ->toArray();

        // Convert CarbonImmutable to strings
        foreach ($attributes as $key => $value) {
            if ($value instanceof CarbonImmutable) {
                // Use date-only format for date fields, datetime for others
                $dateOnlyFields = ['birthdate', 'anniversary'];
                $attributes[$key] = in_array($key, $dateOnlyFields)
                    ? $value->toDateString()
                    : $value->toIso8601String();
            }
        }

        return [
            'data' => [
                'attributes' => array_filter($attributes, fn($v) => $v !== null)
            ]
        ];
    }
}
