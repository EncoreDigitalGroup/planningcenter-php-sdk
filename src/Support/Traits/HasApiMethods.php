<?php

namespace EncoreDigitalGroup\PlanningCenter\Support\Traits;

use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

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

        return $instance->buildPaginatorFromResponse($response);
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

    /**
     * Build a Paginator from an API response
     *
     * @internal This method is for internal SDK use only.
     *
     * @return Paginator<static>
     */
    public function buildPaginatorFromResponse(Response $response): Paginator
    {
        /** @var array<int, array<string, mixed>> $jsonData */
        $jsonData = $response->json("data");

        /** @var Collection<int, static> $data */
        $data = collect($jsonData)->map(
            fn (array $item): static => static::createFromArray($item, $this->clientId, $this->clientSecret)
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
}
