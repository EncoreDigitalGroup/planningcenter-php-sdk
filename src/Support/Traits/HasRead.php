<?php

namespace EncoreDigitalGroup\PlanningCenter\Support\Traits;

use InvalidArgumentException;

trait HasRead
{
    /**
     * Fetch a single resource by ID
     *
     * Requires the resource to have an ID set via withId() before calling.
     */
    public function get(): self
    {
        if (!$this->getAttribute("id")) {
            throw new InvalidArgumentException("Cannot fetch resource without an ID. Use withId() first.");
        }

        $response = $this->client()->get(
            $this->hostname() . $this->endpoint . "/" . $this->getAttribute("id")
        );

        $this->setResponse($response);
        $this->hydrateFromResponse($response);

        return $this;
    }
}