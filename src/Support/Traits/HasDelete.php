<?php

namespace EncoreDigitalGroup\PlanningCenter\Support\Traits;

use InvalidArgumentException;

trait HasDelete
{
    /**
     * Delete the resource
     *
     * Requires the resource to have an ID set before calling.
     */
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
}