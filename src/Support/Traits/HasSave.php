<?php

namespace EncoreDigitalGroup\PlanningCenter\Support\Traits;

trait HasSave
{
    /**
     * Smart save - creates if no ID, updates if ID exists and resource supports updates
     *
     * If the resource has an ID but doesn't support updates (no HasUpdate trait),
     * this becomes a no-op and just returns the resource as-is.
     */
    public function save(): self
    {
        $hasId = $this->getAttribute("id") !== null;

        // If has ID and supports updates, update
        if ($hasId && $this->supportsUpdate()) {
            return $this->update();
        }

        // If has ID but doesn't support updates, no-op
        if ($hasId) {
            return $this;
        }

        // Otherwise, create
        return $this->create();
    }

    /**
     * Check if this resource supports update operations
     */
    private function supportsUpdate(): bool
    {
        return in_array(HasUpdate::class, class_uses($this), true);
    }
}