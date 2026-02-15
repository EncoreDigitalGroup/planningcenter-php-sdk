<?php

namespace EncoreDigitalGroup\PlanningCenter\Support\Traits;

use BadMethodCallException;
use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use InvalidArgumentException;

trait HasApiMethods
{
    /**
     * List all resources with pagination
     *
     * @return Paginator<static>
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

        return static::buildPaginatorFromResponse($response, $clientId, $clientSecret);
    }

    /**
     * Build a Paginator from an API response
     *
     * @return Paginator<static>
     */
    protected static function buildPaginatorFromResponse(
        Response $response,
        string $clientId,
        string $clientSecret
    ): Paginator {
        /** @var array<int, array<string, mixed>> $jsonData */
        $jsonData = $response->json("data");

        /** @var Collection<int, static> $data */
        $data = collect($jsonData)->map(
            fn (array $item): static => static::createFromArray($item, $clientId, $clientSecret)
        );

        $meta = $response->json("meta");

        return new Paginator(
            data: $data,
            nextUrl: $response->json("links.next"),
            prevUrl: $response->json("links.prev"),
            totalCount: $meta["total_count"] ?? 0,
            perPage: $meta["per_page"] ?? 25
        );
    }

    /**
     * Create and hydrate a new instance from array data
     *
     * @param  array<string, mixed>  $data
     */
    protected static function createFromArray(array $data, string $clientId, string $clientSecret): static
    {
        $instance = new static($clientId, $clientSecret);
        $instance->hydrateFromArray($data);

        return $instance;
    }

    /** Fetch a single resource by ID */
    public function get(): self
    {
        if (!$this->getAttribute("id")) {
            throw new InvalidArgumentException("Cannot fetch resource without an ID. Use withId() first.");
        }

        $response = $this->client()->get(
            $this->hostname() . $this->endpoint . "/" . $this->getAttribute("id")
        );

        $this->hydrateFromResponse($response);

        return $this;
    }

    /** Smart save - creates if no ID, updates if ID exists */
    public function save(): self
    {
        if ($this->getAttribute("id")) {
            return $this->update();
        }

        return $this->create();
    }

    /** Delete the resource */
    public function delete(): bool
    {
        if (!$this->getAttribute("id")) {
            throw new InvalidArgumentException("Cannot delete resource without an ID.");
        }

        $response = $this->client()->delete(
            $this->hostname() . $this->endpoint . "/" . $this->getAttribute("id")
        );

        return $response->successful();
    }

    /** Create a new resource */
    public function create(): self
    {
        $response = $this->client()->post(
            $this->hostname() . $this->endpoint,
            $this->mapToPco()
        );

        $this->hydrateFromResponse($response);

        return $this;
    }

    /** Update an existing resource */
    public function update(): self
    {
        $response = $this->client()->patch(
            $this->hostname() . $this->endpoint . "/" . $this->getAttribute("id"),
            $this->mapToPco()
        );

        $this->hydrateFromResponse($response);

        return $this;
    }

    /** Hydrate attributes from API response */
    protected function hydrateFromResponse(Response $response): void
    {
        $data = $response->json("data");

        // Handle array responses (list endpoints)
        if (is_array($data) && isset($data[0])) {
            $data = $data[0];
        }

        $this->hydrateFromArray($data);
    }

    /** Convert attributes to Planning Center API format */
    protected function mapToPco(): array
    {
        // Exclude read-only attributes
        $attributes = $this->attributes
            ->except($this->readOnlyAttributes())
            ->toArray();

        // Convert CarbonImmutable to strings
        foreach ($attributes as $key => $value) {
            if ($value instanceof CarbonImmutable) {
                // Use date-only format for specified fields, datetime for others
                $attributes[$key] = in_array($key, $this->dateOnlyAttributes(), strict: true)
                    ? $value->toDateString()
                    : $value->toIso8601String();
            }
        }

        return [
            "data" => [
                "attributes" => array_filter($attributes, fn ($v): bool => $v !== null),
            ],
        ];
    }
}
