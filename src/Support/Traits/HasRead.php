<?php

namespace EncoreDigitalGroup\PlanningCenter\Support\Traits;

use InvalidArgumentException;

trait HasRead
{
    /**
     * Fetch a single resource by ID
     *
     * Requires the resource to have an ID set via withId() before calling.
     *
     * @param  array<string, mixed>  $query  Optional query parameters
     */
    public function get(array $query = []): self
    {
        if (!$this->getAttribute("id")) {
            throw new InvalidArgumentException("Cannot fetch resource without an ID. Use withId() first.");
        }

        // Merge with accumulated query parameters if HasQueryParameters trait is used
        $mergedQuery = method_exists($this, 'mergeQueryParameters')
            ? $this->mergeQueryParameters($query)
            : $query;

        $response = $this->client()->get(
            $this->hostname() . $this->endpoint . "/" . $this->getAttribute("id"),
            $mergedQuery
        );

        $this->setResponse($response);
        $this->hydrateFromResponse($response);

        return $this;
    }
}